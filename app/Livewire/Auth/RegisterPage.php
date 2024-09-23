<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.auth.register-page')->title(__('Register'));
    }

    public function save(){
        $this->validate([
            'name'      => 'required|min:3|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:8|max:255',
        ]);

        $user = User::create([
            'name'  => $this->name,
            'email' => $this->email,
            'password'  => Hash::make($this->password)
        ]);

        auth()->login($user);
        return redirect()->intended();

    }
}
