<?php

namespace App\Livewire\Classes;

use App\Models\Classe;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ListClasse extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme ='bootstrap';
  public function removeClass($id){
    $classe=Classe::find($id);
    if ($classe) {
      $classe->delete();
      session()->flash('message', 'Classe supprimée avec succès.');
    }
  }
  #[On('actualiser')] 
  public function resetPagination()
{
    $this->resetPage();
} 

    public function edit($id)
    {
        $this->dispatch('editClasse', id: $id);
    }

    public function render()
    {
      $classes=Classe::paginate(5) ;   
      return view('livewire.classes.list-classe',compact('classes'));
    }
}
