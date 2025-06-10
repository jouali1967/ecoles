<?php

namespace App\Livewire\ClassesMatieres;

use App\Models\Classe;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\ClassesMatiere;

class MajClassesMatieres extends Component
{
    public $classe_id;
    public $matiere_id;
    public $coefficient;
    public $classeMatiere;

    protected $rules = [
        'classe_id' => 'required',
        'matiere_id' => 'required',
        'coefficient' => 'required|integer|min:1'
    ];

    public function mount(ClassesMatiere $classeMatiere)
    {
      $this->classe_id = $classeMatiere->classe_id;
        $this->matiere_id = $classeMatiere->matiere_id;
        $this->coefficient = $classeMatiere->coefficient;
    }

    public function update()
    {
        $data=$this->validate();

        // Vérifier si l'association existe déjà (sauf pour l'enregistrement actuel)
        $exists = ClassesMatiere::where('classe_id', $this->classe_id)
            ->where('matiere_id', $this->matiere_id)
            ->where('id', '!=', $this->classeMatiere->id)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Cette association existe déjà.');
            return;
        }

        $this->classeMatiere->update($data);
        return $this->redirect('/classes-matieres',navigate:true);
    }

    public function render()
    {
      $classes = Classe::all();
      $matieres = Matiere::all();
      return view('livewire.classes-matieres.maj-classes-matieres',
    compact('classes','matieres'));
    }
}
