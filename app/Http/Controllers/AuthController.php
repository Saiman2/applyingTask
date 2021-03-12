<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {

        return view('auth.login');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function create(RegisterRequest $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $query = $user->save();

        if ($query) {
            Auth::login($user);
            return response()->json(['success' => true, 'msg' => 'Успешна регистрация!']);
        } else {
            return response(json_encode(['msg' => 'Нещо се обърка опитайте по-късно!']), 400);
        }

    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function check(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return response()->json(['success' => true, 'msg' => 'Вие влязохте успешно!']);
            } else {
                return response(json_encode(['msg' => 'Грещна парола!']), 400);
            }
        } else {
            return response(json_encode(['msg' => 'Акаунта не е намерен!']), 400);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            return redirect()->route('home');
        }
        return redirect()->route('home');
    }

}
