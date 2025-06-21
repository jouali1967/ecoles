<?php

namespace App\Livewire\Etudiants;

use App\Models\Classe;
use App\Models\Inscription;
use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;

class CreateInscription extends Component
{
  public $etudiant_id;
  public $etudiants;
  public $selectedEtudiant;
  public $searchEtudiant = '';
  #[Rule('required')]
  public $annee_scol;
  #[Rule('required')]
  public $classe_id;
  protected $rules = [
    'etudiant_id' => 'required|exists:etudiants,id',
  ];
  public function mount()
  {
    $annee = date('Y');
    $annee_suiv = $annee + 1;
    $this->annee_scol = $annee . '/' . $annee_suiv;
  }

  public function updatedSearchEtudiant()
  {
    if (strlen($this->searchEtudiant) >= 2) {
      $this->etudiants = Etudiant::with(['inscriptions.classe'])
        ->whereNotIn('id', function ($query) {
          $query->select('etudiant_id')
            ->from('parentals');
        })
        ->where(function ($query) {
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
    $this->selectedEtudiant = Etudiant::with(['lastInscription.classe'])->find($id);
    $this->searchEtudiant = '';
    $this->etudiants = collect();
  }
  public function save()
  {
    $data = $this->validate();
    Inscription::create($data);
    // Réinitialiser les champs pour permettre une nouvelle inscription
    $this->reset(['etudiant_id', 'selectedEtudiant', 'classe_id']);
    $this->searchEtudiant = '';
    $this->etudiants = collect();
    // Optionnel : message de succès
    session()->flash('success', 'Inscription enregistrée. Sélectionnez un autre étudiant.');
  }


  public function render()
  {
    $classes = Classe::all();
    return view(
      'livewire.etudiants.create-inscription',
      compact('classes')
    );
  }
}
