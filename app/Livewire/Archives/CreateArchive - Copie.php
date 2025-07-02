<?php

namespace App\Livewire\Archives;

use App\Models\Classe;
use App\Models\Archive;
use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;

class CreateArchive extends Component
{
  public $etudiant_id;
  public $etudiants;
  public $selectedEtudiant;
  public $searchEtudiant = '';
  #[Rule('required')]
  public $annee_scol;
  #[Rule('required')]
  public $classe_id;
  #[Rule('required')]
  public $semestre;
  #[Rule('required|numeric|min:0|max:20|regex:/^\d+(\.\d{1,2})?$/')]
  public $moyenne;
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
    // Pré-sélectionner la classe de l'étudiant si elle existe
    $this->classe_id = $this->selectedEtudiant->lastInscription->classe->id ?? null;
    $this->searchEtudiant = '';
    $this->etudiants = collect();
  }

  public function render()
  {
    $classes = Classe::all();
    return view('livewire.archives.create-archive', compact('classes'));
  }
  public function save()
  {
    $data = $this->validate();
    //dd($data);
    // Vérifier l'unicité de la combinaison etudiant_id, annee_scol, semestre
    $exists = Archive::where('etudiant_id', $data['etudiant_id'])
      ->where('annee_scol', $data['annee_scol'])
      ->where('semestre', $data['semestre'])
      ->exists();
    if ($exists) {
      session()->flash('error', 'Cet étudiant a déjà une moyenne enregistrée pour cette année et ce semestre.');
      return;
    }
    //Archive::create($data);
    session()->flash('success', 'La moyenne est enregistrée avec succès.');
    $this->reset();
  }
}
