<?php

namespace App\Livewire\Editions;

use App\Models\Note;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\Inscription;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;


class ListEtudSuivi extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";

  public $annee_scolaire;
  public $semestre;
  public $annees_scolaires;
  public $matiere_id;
  public $matieres;
  public $showResults = false;

  public function mount()
  {
    // Récupérer les années scolaires distinctes depuis la table inscriptions
    $this->annees_scolaires = Inscription::select('annee_scol')
      ->distinct()
      ->orderBy('annee_scol', 'desc')
      ->pluck('annee_scol')
      ->toArray();
    $this->matieres = Matiere::pluck('nom_matiere', 'id');
  }
  public function rechercher()
  {
    $this->showResults = true;
    $this->resetPage();
  }

  public function render()
  {
    if ($this->showResults) {
      $annee_scol = $this->annee_scolaire;
      $semestre = $this->semestre;
      $matiere_id = $this->matiere_id;
      $etudiants = Note::where('annee_scol', $annee_scol)
        ->where('semestre', $semestre)
        ->where('matiere_id', $matiere_id)
        ->with(['etudiant', 'etudiant.lastInscription.classe'])
        ->select('etudiant_id', DB::raw('AVG(note_calc) as moyenne'))
        ->groupBy('etudiant_id')
        ->havingRaw('AVG(note_calc) < 10')
        ->orderBy('moyenne', 'desc')
        ->paginate(5);
      return view('livewire.editions.list-etud-suivi', compact('etudiants'));
    } else {
      $etudiants = collect();
      return view('livewire.editions.list-etud-suivi', compact('etudiants'));
    }
  }
}
