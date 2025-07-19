<?php

namespace App\Livewire\Evenements;

use Livewire\Component;
use App\Models\Evenement;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class ListeEvenement extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";
  public $search = '';


  public function edit($id)
  {
    // Rediriger ou ouvrir le formulaire d'édition
  }

  public function delete($id)
  {
    Evenement::find($id)?->delete();
    $this->resetPage();
  }

  public function render()
  {
    $evenements = Evenement::with([
      'etudiant.lastInscription.classe'
    ])
    ->latest('date_event')
  ->when($this->search, function ($query) {
      $query->whereHas('etudiant', function ($q) {
          $q->where('nom', 'like', '%' . $this->search . '%')
            ->orWhere('prenom', 'like', '%' . $this->search . '%')
            ->orWhere('code_massar', 'like', '%' . $this->search . '%');
      });
    })
    ->paginate(5);
    return view('livewire.evenements.liste-evenement', compact('evenements'));
  }
}
