<?php

namespace App\Livewire\ClassesMatieres;

use App\Models\Classe;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\ClassesMatiere;

class CreateClasseMatiere extends Component
{
    public $classe_id;
    public $matiere_id;
    public $coefficient;

    protected $rules = [
        'classe_id' => 'required',
        'matiere_id' => 'required',
        'coefficient' => 'required|integer|min:1'
    ];


    public function save()
    {
      $data=$this->validate();
      // Vérifier si l'association existe déjà
      $exists = ClassesMatiere::where('classe_id', $this->classe_id)
            ->where('matiere_id', $this->matiere_id)
            ->exists();
      if ($exists) {
        session()->flash('error', 'Cette association existe déjà.');
          return;
      }
       ClassesMatiere::create($data);
        $this->reset();
    }

    public function render()
    {
      $classes = Classe::all();
      $matieres = Matiere::all();
      return view('livewire.classes-matieres.create-classe-matiere',
    compact('classes','matieres'));
    }
}
