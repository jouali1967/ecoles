<?php

namespace App\Livewire\Evenements;

use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;

class EditEvenement extends Component
{
  #[Rule('required', message: "Veuillez choisir un étudiant.")]
  public $etudiant_id;
  public $etudiants;
  public $selectedEtudiant;
  public $searchEtudiant = '';
  #[Rule('required')]
  public $date_event;
  #[Rule('required', message: "Descriotion est obligatoire.")]
  public $description;

  public $evenement;

  public function mount($id = null)
  {
    if ($id) {
      $this->evenement = \App\Models\Evenement::with('etudiant')->findOrFail($id);
      $this->etudiant_id = $this->evenement->etudiant_id;
      $this->date_event = $this->evenement->date_event;
      $this->description = $this->evenement->description;
      $this->selectedEtudiant = $this->evenement->etudiant;
    }
  }
  public function updatedSearchEtudiant()
  {
    if (strlen($this->searchEtudiant) >= 2) {
      $this->etudiants = Etudiant::with(['lastInscription.classe'])
        ->where(function ($query) {
          $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
            ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%')
            ->orWhere('code_massar', 'like', '%' . $this->searchEtudiant . '%');
        })
        ->get();
    } else {
      $this->etudiants = collect();
    }
  }
  public function selectEtudiant($id)
  {
    $this->etudiant_id = $id;
    $this->selectedEtudiant = Etudiant::with(['lastInscription.classe'])->find($id);
    $this->resetValidation('etudiant_id');
    $this->searchEtudiant = '';
    $this->etudiants = collect();
  }

  public function save()
  {
    $data = $this->validate();
    $this->evenement->update($data);
    session()->flash('success', 'Événement modifié avec succès.');
    return $this->redirectRoute('evenements.index', navigate: true);  
}

  public function render()
  {
    return view('livewire.evenements.edit-evenement');
  }
}
