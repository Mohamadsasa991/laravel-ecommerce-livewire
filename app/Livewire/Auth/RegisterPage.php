<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class RegisterPage extends Component
{
    #[Title('Sign up')]

    public $name;
    public $email;

    public $password;

    public function save() {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255|min:6'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        Auth::login($user);
        redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
