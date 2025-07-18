<?php

namespace App\Livewire\Evenements;

use App\Models\Evenement;
use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;

class CreateEvenement extends Component
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

  public function render()
  {
    return view('livewire.evenements.create-evenement');
  }
  public function save()
  {
    $data = $this->validate();
    Evenement::create($data);
    $this->reset();
  }
}
