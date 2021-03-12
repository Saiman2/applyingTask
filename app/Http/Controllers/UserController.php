<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return response(['success' => true, 'users' => User::where('email', 'LIKE', '%' . $request->search . '%')->where('role', 0)->get()->take(10)], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $user = User::findOrFail($request->id);
        if (!$user) {
            return response(json_encode(['msg' => 'Няма намерен потребител!']), 400);
        }
        return response(['success' => true, 'user' => $user], 200);
    }
}
