<?php

namespace App\Livewire\Matieres;

use App\Models\Matiere;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ListMatiere extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme ='bootstrap';
  public function removeMatiere($id){
    $classe=Matiere::find($id);
    $classe->delete();
    $this->dispatch('actualiser');
  }
  #[On('actualiser')] 
  public function resetPagination()
{
    $this->resetPage();
} 

    public function render()
    {
      $matieres=Matiere::paginate(5) ; 
      return view('livewire.matieres.list-matiere',compact('matieres'));
    }
}
