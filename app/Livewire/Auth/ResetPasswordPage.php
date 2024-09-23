<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordPage extends Component
{

    public $token;
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;


    public function mount($token){
        $this->token = $token;
    }
    public function render()
    {
        return view('livewire.auth.reset-password-page')->title(__('Reset password'));
    }

    public function save()
    {
        $this->validate([
            'email'                 => 'required',
            'password'              => 'required|min:8|max:255|confirmed',

        ]);

        $status= Password::reset(
            [
            'email'     => $this->email,
            'password'  => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token],
            function (User $user,string $password){
                $password = $this->password;
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET ? redirect('/login') :session()->flash('error',__('Something was wrong'));

    }


}
