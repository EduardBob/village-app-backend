<?php namespace Modules\Village\Http\Controllers;

use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Http\Requests\LoginRequest;

class AuthController extends BasePublicController
{
    public function getLogin()
    {
        return view('village::public.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];
        $remember = (bool) $request->get('remember_me', false);

        $error = $this->auth->login($credentials, $remember);
        if (!$error) {
            Flash::success(trans('user::messages.successfully logged in'));

            return redirect()->intended('/backend');
        }

        Flash::error($error);

        return redirect()->back()->withInput();
    }

    public function getLogout()
    {
        $this->auth->logout();

        return redirect()->route('login');
    }

    public function getActivate($userId, $code)
    {
        if ($this->auth->activate($userId, $code)) {
            Flash::success(trans('user::messages.account activated you can now login'));

            return redirect()->route('login');
        }
        Flash::error(trans('user::messages.there was an error with the activation'));

        return redirect()->route('register');
    }
}
