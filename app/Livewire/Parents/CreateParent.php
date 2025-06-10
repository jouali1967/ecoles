<?php

namespace App\Livewire\Parents;

use App\Models\Etudiant;
use App\Models\Parental;
use Livewire\Component;

class CreateParent extends Component
{
    public $etudiant_id;
    public $nom_pere;
    public $nom_mere;
    public $phone_pere;
    public $phone_mere;
    public $handicape = false;
    public $orphelin = false;
    public $searchEtudiant = '';
    public $etudiants;
    public $selectedEtudiant;

    protected $rules = [
        'etudiant_id' => 'required|exists:etudiants,id',
        'nom_pere' => 'required|string|max:255',
        'nom_mere' => 'required|string|max:255',
        'phone_pere' => 'required|string|max:20',
        'phone_mere' => 'required|string|max:20',
        'handicape' => 'boolean',
        'orphelin' => 'boolean',
    ];

    public function updatedSearchEtudiant()
    {
        if (strlen($this->searchEtudiant) >= 2) {
            $this->etudiants = Etudiant::with(['inscriptions.classe'])
                ->whereNotIn('id', function($query) {
                    $query->select('etudiant_id')
                        ->from('parentals');
                })
                ->where(function($query) {
                    $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
                          ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%');
                })
                ->get();
        } else {
            $this->etudiants = collect();
        }
    }

    public function selectEtudiant($id)
    {
        $this->etudiant_id = $id;
        $this->selectedEtudiant = Etudiant::with(['inscriptions.classe'])->find($id);
        $this->searchEtudiant = '';
        $this->etudiants = collect();
    }

    public function render()
    {
        return view('livewire.parents.create-parent');
    }

    public function save()
    {
        $data = $this->validate();
        Parental::create($data);
        $this->reset();
        session()->flash('message', 'Parent ajouté avec succès.');
        return redirect()->route('parents.index');
    }
}
