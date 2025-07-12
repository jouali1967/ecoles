<?php

namespace App\Livewire\Editions;

use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;


class ListTeritoriale extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";

  public $dom_ter;

  public $showResults = false;

  public function rechercher()
  {
    $this->showResults = true;
    $this->resetPage();
  }

  public function render()
  {
    $etudiants = collect();
    if ($this->showResults) {
      /*$latestInscriptions = DB::table('inscriptions')
        ->select('etudiant_id', DB::raw('MAX(annee_scol) as max_annee'))
        ->groupBy('etudiant_id');
      $etudiants = DB::table('etudiants')
        ->joinSub($latestInscriptions, 'latest_inscriptions', function ($join) {
          $join->on('etudiants.id', '=', 'latest_inscriptions.etudiant_id');
        })
        ->join('inscriptions', function ($join) {
          $join->on('etudiants.id', '=', 'inscriptions.etudiant_id')
            ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
        })
        ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
        ->where('etudiants.dom_ter', $this->dom_ter)
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
          'classes.abr_classe'
        )
        ->orderBy('etudiants.nom_ar')*/
      $etudiants = Etudiant::with('lastInscription.classe')
                  ->where('etudiants.dom_ter', $this->dom_ter)
      ->paginate(5);
    }

    return view('livewire.editions.list-teritoriale', compact('etudiants'));
  }

  public function imprimer()
  {
    $params = route('editions.listterit.pdf', [
      'dom_ter' => $this->dom_ter ?? '',
    ]);
    $this->dispatch('openEtatWindow', url: $params);
  }
}
