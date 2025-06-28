<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Support\Facades\DB;

class SuiviNote extends Component
{
  public $nom_etudiant;
  public $annee_scolaire;
  public $semestre;
  public $notes = [];
  public $etudiant = null;
  public $annees_scolaires = [];
  public $showResults = false;
  public $classe = null;
  public $searchEtudiant = '';
  public $etudiants = [];
  public $selectedEtudiant = null;

  public function mount()
  {
    // Récupérer les années scolaires distinctes depuis la table inscriptions
    $this->annees_scolaires = Inscription::select('annee_scol')
      ->distinct()
      ->orderBy('annee_scol', 'desc')
      ->pluck('annee_scol')
      ->toArray();
  }

  public function updatedSearchEtudiant()
  {
    if (strlen($this->searchEtudiant) >= 2) {
      $this->etudiants = Etudiant::where(function ($query) {
        $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
          ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%')
          ->orWhere('code_massar', 'like', '%' . $this->searchEtudiant . '%');
      })
        ->with(['inscriptions.classe'])
        ->orderBy('nom')
        ->limit(10)
        ->get();
    } else {
      $this->etudiants = collect();
    }
  }

  public function selectEtudiant($id)
  {
    $this->nom_etudiant = $id;
    $this->selectedEtudiant = Etudiant::with(['inscriptions.classe'])->find($id);
    $this->searchEtudiant = $this->selectedEtudiant->nom . ' ' . $this->selectedEtudiant->prenom;
    $this->etudiants = collect();
    // Réinitialiser les résultats
    $this->showResults = false;
    $this->notes = [];
    $this->classe = null;
    $this->etudiant = null;
  }

  public function rechercher()
  {
    $this->validate([
      'nom_etudiant' => 'required|exists:etudiants,id',
      'annee_scolaire' => 'required',
      'semestre' => 'required|in:1,2',
    ]);

    // Récupérer l'étudiant avec ses informations complètes
    $this->etudiant = Etudiant::findOrFail($this->nom_etudiant);

    // Récupérer la classe de l'étudiant
    $this->classe = DB::table('inscriptions')
      ->join('classes', 'inscriptions.classe_id', '=', 'classes.id')
      ->where('inscriptions.etudiant_id', $this->etudiant->id)
      ->where('inscriptions.annee_scol', $this->annee_scolaire)
      ->value('classes.nom_classe');

    $this->showResults = true;

    // Récupérer toutes les matières de la classe, avec ou sans notes
    $classe_id = DB::table('inscriptions')
      ->where('etudiant_id', $this->etudiant->id)
      ->where('annee_scol', $this->annee_scolaire)
      ->value('classe_id');

    $this->notes = DB::table('matieres')
      ->join('classes_matieres', function ($join) use ($classe_id) {
        $join->on('matieres.id', '=', 'classes_matieres.matiere_id')
          ->where('classes_matieres.classe_id', '=', $classe_id);
      })
      ->leftJoin('notes', function ($join) {
        $join->on('notes.matiere_id', '=', 'matieres.id')
          ->where('notes.etudiant_id', '=', $this->etudiant->id)
          ->where('notes.annee_scol', '=', $this->annee_scolaire)
          ->where('notes.semestre', '=', $this->semestre);
      })
      ->select(
        'matieres.nom_matiere as matiere',
        'notes.note1',
        'notes.note2',
        'notes.note3',
        'notes.note4',
        'notes.note_calc',
        'classes_matieres.coefficient'
      )
      ->orderBy('matieres.nom_matiere')
      ->get();
    //dd($this->notes);
  }
  public function render()
  {
    return view('livewire.notes.suivi-note');
  }
}
