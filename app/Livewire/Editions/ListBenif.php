<?php

namespace App\Livewire\Editions;

use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;

class ListBenif extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";

  public $annee_scolaire;
  
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
      $etudiants = Etudiant::with('inscriptions.classe')
      ->where('etudiants.ben_part', 'oui') // filtre local sur l'étudiant
      ->whereHas('inscriptions', function ($query) use($annee_scol) {
          $query->where('annee_scol', $annee_scol);
      })
    ->paginate(5);
      /*$etudiants = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
    ->where('etudiants.ben_part', 'oui') // boursiers
    ->where('inscriptions.annee_scol', $annee_scol) // ✅ année scolaire depuis la table inscriptions
    ->select(
        'etudiants.id as etudiant_id',
        'etudiants.nom_ar',
        'etudiants.prenom_ar',
        'etudiants.num_enr',
        'etudiants.code_massar',
        'etudiants.etud_photo',
        'etudiants.tel_pere',
        'etudiants.tel_mere',
        'classes.nom_classe',
        'classes.abr_classe',
    )
    ->orderBy('etudiants.nom_ar')
    ->paginate(5);*/
    }

      return view('livewire.editions.list-benif',compact('etudiants'));
    }

      public function imprimer(){
      $params = route('editions.listbenif.pdf', [
      'annee_scol' => $this->annee_scolaire ?? '',
    ]);
    $this->dispatch('openEtatWindow', url: $params);
  }
  public function imprimer_excel(){
    $params = route('editions.listbenif.excel', [
      'annee_scol' => $this->annee_scolaire ?? '',
    ]);
    $this->dispatch('ouvrir-excel', $params);

  }
}
