<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AddEditRepairRequest;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Mail;

class RepairRequestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('repairRequests.add');
    }

    /**
     * @param AddEditRepairRequest $request
     * @return mixed
     */
    public function addRepairRequest(AddEditRepairRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $userId = $request->user_id;
            if (!$userId) {
                $userData = $request->all();
                $userData['password'] = Hash::make($request->password);
                $user = User::create($userData);

                if (!$user) {
                    return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
                }
                $userId = $user->id;
            }
            $status = Status::select('id')->where('label', 'Изчакване')->first();
            $data = $request->all();
            $data['user_id'] = $userId;
            $data['status_id'] = $status->id;
            $repairRequest = RepairRequest::create($data);
            if (!$repairRequest) {
                return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
            }
            return response(['success' => true, 'msg' => 'Успешно създадена заявка за ремонт!'], 200);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {

        if (!$request->id || !$request->statusId) {
            return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
        }
        $repairRequest = RepairRequest::find($request->id);
        if (!$repairRequest) {
            return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
        }
        $repairRequest->update(['status_id' => $request->statusId]);
        if ($repairRequest->status->label == 'Завършен') {
            Mail::send('mail',
                [
                    'user' => $repairRequest->user,
                    'finishedCar' => $repairRequest->brand . ' ' . $repairRequest->model . ' ' . $repairRequest->year . 'г.'
                ], function ($m) use ($repairRequest) {
                    $m->to($repairRequest->user->email)->subject('Звършен ремонт');
                });
        }
        return response()->json(['success' => true, 'msg' => 'Успешно сменен статус!']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $repairRequest = RepairRequest::findOrFail($id);
        if (!$repairRequest) {
            App::abort(404);
        }
        $statuses = Status::all();
        return view('repairRequests.edit', compact('repairRequest', 'statuses'));
    }

    /**
     * @param AddEditRepairRequest $request
     * @return mixed
     */
    public function editSave(AddEditRepairRequest $request)
    {

        return DB::transaction(function () use ($request) {
            $userId = $request->user_id;
            if (!$userId) {
                $userData = $request->all();
                $userData['password'] = Hash::make($request->password);
                $user = User::create($userData);
                if (!$user) {
                    return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
                }
                $userId = $user->id;
            } else {
                User::where('id', $userId)->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
            }
            $data = $request->all();
            $data['user_id'] = $userId;
            $repairRequest = RepairRequest::find($request->id);
            if (!$repairRequest) {
                return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
            }
            $repairRequest->update($data);
            if ($repairRequest->status->label == 'Завършен') {
                Mail::send('mail',
                    [
                        'user' => $repairRequest->user,
                        'finishedCar' => $repairRequest->brand . ' ' . $repairRequest->model . ' ' . $repairRequest->year . 'г.'
                    ], function ($m) use ($repairRequest) {
                        $m->to($repairRequest->user->email)->subject('Звършен ремонт');
                    });
            }
            return response(['success' => true, 'msg' => 'Успешно редактирана заявка за ремонт!'], 200);
        });
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id)
    {
        $repairRequest = RepairRequest::findOrFail($id);
        if (!$repairRequest) {
            App::abort(404);
        }
        return view('repairRequests.detail', compact('repairRequest'));
    }

    public function delete(Request $request)
    {
        $repairRequest = RepairRequest::findOrFail($request->id);
        if (!$repairRequest) {
            return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
        }
        $repairRequest->delete();
        return response(['success' => true, 'msg' => 'Успешно изтрита заявка за ремонт!'], 200);
    }
}
