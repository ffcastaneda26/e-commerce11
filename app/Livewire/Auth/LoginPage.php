<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class LoginPage extends Component
{
    public $email;
    public $password;

    public function render()
    {
        
        return view('livewire.auth.login-page')->title(__('Log In'));
    }

    public function save()
    {
        $this->validate([
            'email'     => 'required|email|max:255|exists:users,email',
            'password'  => 'required|min:8|max:255'
        ]);

        if(!auth()->attempt(['email' => $this->email,'password' => $this->password])){
            session()->flash('error',__('Invalid credentials'));
            return;
        }else{
            session()->flash('error','NI PASO POR EL ANTERIOR IF');
        }

        return redirect()->intended();
    }
}
