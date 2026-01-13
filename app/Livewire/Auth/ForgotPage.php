<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

class ForgotPage extends Component
{
    #[Title('Forget Password page')]

    public $email;

    public function save(){
        $this->validate([
            'email' => 'required|exists:users,email|max:255'
        ]);
        $status = Password::sendResetLink(['email' => $this->email]);

        if($status=== Password::RESET_LINK_SENT){
            session()->flash('success' ,'Password reset link has been sent to your email');
        }
//       Mail::raw('Hello from Laravel + Mailtrap!', function ($message) {
//     $message->to($this->email)
//             ->subject('Test Email');
// });
        $this->email = '';
    }
    public function render()
    {
        return view('livewire.auth.forgot-page');
    }
}
