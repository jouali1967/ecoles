<?php

namespace App\Livewire\Classes;

use App\Models\Classe;
use Livewire\Component;
use App\Models\Inscription;

class CreateClasse extends Component
{
    public $nom_classe;
    public $abr_classe;
    public $editing = false;
    public $classe_id;

    protected $rules = [
        'nom_classe' => 'required',
        'abr_classe' => 'required',
    ];

    protected $listeners = ['editClasse'];

    public function editClasse($id)
    {
        $classe = Classe::find($id);
        if ($classe) {
            $this->classe_id = $classe->id;
            $this->nom_classe = $classe->nom_classe;
            $this->abr_classe = $classe->abr_classe;
            $this->editing = true;
        }
    }

    public function render()
    {
        $anneesScolaires = Inscription::select('annee_scol')
            ->distinct()
            ->orderBy('annee_scol','desc')
            ->pluck('annee_scol');
        return view('livewire.classes.create-classe');
    }

    public function save()
    {
        $this->validate();

        if ($this->editing) {
            $classe = Classe::find($this->classe_id);
            $classe->update([
                'nom_classe' => $this->nom_classe,
                'abr_classe' => $this->abr_classe,
            ]);
            session()->flash('message', 'Classe mise à jour avec succès.');
        } else {
            Classe::create([
                'nom_classe' => $this->nom_classe,
                'abr_classe' => $this->abr_classe,
            ]);
            session()->flash('message', 'Classe créée avec succès.');
        }

        $this->reset(['nom_classe','abr_classe', 'editing', 'classe_id']);
        $this->dispatch('actualiser');
    }

    public function cancel()
    {
        $this->reset(['nom_classe', 'editing', 'classe_id']);
    }
}
