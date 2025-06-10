<?php

namespace App\Livewire\Matieres;

use App\Models\Matiere;
use Livewire\Component;

class CreateMatiere extends Component
{
  public $nom_matiere;
  public $description;

  protected $rules = [
      'nom_matiere' => 'required',
      'description' => 'required',
  ];

    public function render()
    {
        return view('livewire.matieres.create-matiere');
    }
    public function save(){
      $this->validate();
      Matiere::create($this->all());
      $this->reset();
      $this->dispatch('actualiser');
    }

}
