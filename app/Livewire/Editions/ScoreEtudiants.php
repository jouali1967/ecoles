<?php

namespace App\Livewire\Editions;

use App\Models\Note;
use Livewire\Component;
use App\Models\Inscription;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;

class ScoreEtudiants extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";

  public $annee_scolaire;
  public $semestre;
  public $annees_scolaires;
  public $showResults = false;
  public function mount()
  {
    // Récupérer les années scolaires distinctes depuis la table inscriptions
    $this->annees_scolaires = Inscription::select('annee_scol')
      ->distinct()
      ->orderBy('annee_scol', 'desc')
      ->pluck('annee_scol')
      ->toArray();
  }
  public function rechercher()
  {
    $this->showResults = true;
    $this->resetPage();
  }

  public function render()
  {
    $etudiants = collect();
    if ($this->showResults) {
      $annee_scol = $this->annee_scolaire;
      $semestre = $this->semestre;
      $etudiants = Note::where('annee_scol', $annee_scol)
        ->where('semestre', $semestre)
        //->with(['etudiant', 'etudiant.lastInscription.classe'])
        ->with([
          'etudiant',
          'etudiant.inscriptions' => function ($query) use ($annee_scol) {
            $query->where('annee_scol', $annee_scol)
              ->with('classe');
          },
        ])
        ->select('etudiant_id', DB::raw('AVG(note_calc) as moyenne'))
        ->groupBy('etudiant_id')
        ->orderBy('moyenne', 'desc')
        ->paginate(5);
      /*$etudiants = DB::table('etudiants') // Assurez-vous que cette table existe
        ->Join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
        ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
        ->join('notes', function ($join) use ($annee_scol, $semestre) {
          $join->on('etudiants.id', '=', 'notes.etudiant_id')
            ->where('notes.annee_scol', $annee_scol)
            ->where('notes.semestre', $semestre);
        })
        ->select(
          'etudiants.id as etudiant_id',
          'etudiants.nom',
          'etudiants.prenom',
          'etudiants.num_enr',
          'etudiants.code_massar',
          'etudiants.etud_photo',
          'classes.nom_classe',
          'classes.abr_classe',
          DB::raw('SUM(notes.note_calc * notes.coefficient) as total_notes'),
          DB::raw('SUM(notes.coefficient) as total_coefficients'),
          DB::raw('SUM(notes.note_calc * notes.coefficient) / NULLIF(SUM(notes.coefficient), 0) as moyenne')
        )
        ->groupBy(
          'etudiants.id',
          'etudiants.nom',
          'etudiants.prenom',
          'etudiants.num_enr',
          'etudiants.etud_photo',
          'etudiants.code_massar',
          'classes.nom_classe',
          'classes.abr_classe'
        )
        ->orderBy('moyenne', 'desc')
        ->paginate(5);*/
    }

    return view('livewire.editions.score-etudiants', compact('etudiants'));
  }

  public function imprimer()
  {
    $params = route('editions.score.pdf', [
      'annee_scol' => $this->annee_scolaire ?? '',
      'semestre' => $this->semestre ?? '',
    ]);
    $this->dispatch('openEtatWindow', url: $params);
  }
}
