<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutButton extends Component

{
  public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        // Redirection vers la page de connexion, en utilisant le routeur de Livewire
        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return <<<'HTML'
        <button wire:click="logout" class="btn btn-default btn-flat float-end">
            <i class="fas fa-sign-out-alt me-2"></i>
            Déconnexion
        </button>
        HTML;
    }
}
