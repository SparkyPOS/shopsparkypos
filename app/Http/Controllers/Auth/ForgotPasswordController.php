<?php

namespace App\Http\Controllers\Auth;

use App\Rules\RealEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function showLinkRequestForm(){
        if (isModuleActive('Otp') && otp_configuration('otp_on_password_reset')) {
            return view(theme('auth.reset_user_otp'));
        }
        return view(theme('auth.email'));
    }
    protected function validateEmail(Request $request)
    {
        if (env('NOCAPTCHA_FOR_EMAIL') == "true" && app('theme')->folder_path == 'amazy') {
            $g_recaptcha = 'required';
        }else{
            $g_recaptcha = 'nullable';
        }
        $request->validate(['email' => ['required','email', new RealEmail()],
        'g-recaptcha-response' => $g_recaptcha,
        ],[
            'g-recaptcha-response.required' => 'The google recaptcha field is required.',
        ]);
    }

}
