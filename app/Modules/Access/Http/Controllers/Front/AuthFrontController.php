<?php

namespace App\Modules\Access\Http\Controllers\Front;

use App\Modules\Access\Http\Requests\RegisterRequest;
use App\Modules\Access\Models\User;
use App\Modules\Generic\Http\Controllers\Front\GenericFrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthFrontController extends GenericFrontController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['only' => ['logout', 'showProfile', 'updateProfile']]);
    }

    public function showRegistrationForm()
    {
        return view('access::Front.register', [
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->except(['_token', 'password_confirmation']));
        Auth::login($user);

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('access::Front.login');

    }

    public function login(Request $request)
    {
        $this->validate($request, ['phone' => 'required', 'password' => 'required']);
        $credentials = $request->only(['phone', 'password']);
        $user = (Auth::attempt($credentials)) ? Auth::getLastAttempted() : FALSE;
        if (!$user) return redirect()->back()->withErrors(['error' => 'Wrong phone or password']);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

    public function showProfile(User $user)
    {
        return view('access::Front.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(User $user, Request $request)
    {
        $user->update($request->except(['_token']));

        return redirect()->back();
    }

    public function showUpdatePasswordForm()
    {
        return view('access::Front.update_password');

    }

    public function updatePassword(User $user, Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        $input = $request->only(['password', 'old_password']);
        $input['user_id'] = Auth::id();
        $credentials['phone'] = $user->phone;
        $credentials['password'] = $input['old_password'];
        $user = (Auth::attempt($credentials)) ? Auth::getLastAttempted() : FALSE;

        if (!$user)
            return redirect()->back()->withErrors(['error' => 'wrong old password']);

        $user->update(['password' => $input['password']]);

        return redirect()->back();

    }


}
