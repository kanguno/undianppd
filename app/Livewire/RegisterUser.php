<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUser extends Component
{
    public $name, $email, $password, $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        // Hanya izinkan admin untuk mendaftar pengguna baru
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'User registered successfully.');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
