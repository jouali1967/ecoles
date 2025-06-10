<?php

namespace App\Livewire\Parents;

use App\Models\Parental;
use Livewire\Component;

class EditParent extends Component
{
    public $parent;
    public $etudiant_id;
    public $nom_pere;
    public $nom_mere;
    public $phone_pere;
    public $phone_mere;
    public $handicape = false;
    public $orphelin = false;

    protected $rules = [
        'etudiant_id' => 'required|exists:etudiants,id',
        'nom_pere' => 'required|string|max:255',
        'nom_mere' => 'required|string|max:255',
        'phone_pere' => 'required|string|max:20',
        'phone_mere' => 'required|string|max:20',
        'handicape' => 'boolean',
        'orphelin' => 'boolean',
    ];

    public function mount($id)
    {
        $this->parent = Parental::with(['etudiant.inscriptions.classe'])->findOrFail($id);
        $this->etudiant_id = $this->parent->etudiant_id;
        $this->nom_pere = $this->parent->nom_pere;
        $this->nom_mere = $this->parent->nom_mere;
        $this->phone_pere = $this->parent->phone_pere;
        $this->phone_mere = $this->parent->phone_mere;
        $this->handicape = (bool) $this->parent->handicape;
        $this->orphelin = (bool) $this->parent->orphelin;
    }

    public function updatedHandicape($value)
    {
        // Suppression de la logique qui désactive orphelin
    }

    public function update()
    {
        $this->validate();

        $this->parent->update([
            'etudiant_id' => $this->etudiant_id,
            'nom_pere' => $this->nom_pere,
            'nom_mere' => $this->nom_mere,
            'phone_pere' => $this->phone_pere,
            'phone_mere' => $this->phone_mere,
            'handicape' => $this->handicape,
            'orphelin' => $this->orphelin
        ]);

        session()->flash('message', 'Parent modifié avec succès.');
        return redirect()->route('parents.index');
    }

    public function render()
    {
        return view('livewire.parents.edit-parent');
    }
} 