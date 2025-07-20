<?php

namespace App\Livewire\Editions;

use Livewire\Component;
use App\Models\Etudiant;
use Illuminate\Support\Facades\DB;

class ListOrphelin extends Component
{
    public function render()
    {
     /* $latestInscriptions = DB::table('inscriptions')
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
      ->where('etudiants.orphelin', 'oui')
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
      ->orderBy('etudiants.nom_ar')
      ->paginate(5);*/
    $etudiants = Etudiant::with('lastInscription.classe')
                  ->where('etudiants.orphelin', 'oui')
    ->paginate(5);

      return view('livewire.editions.list-orphelin',compact('etudiants'));
    }

  public function imprimer()
  {
    $params = route('editions.orphelin.pdf');
    $this->dispatch('openEtatWindow', url: $params);
  }
      
  public function imprimer_excel(){
      $params = route('editions.orphelin.excel');
      $this->dispatch('ouvrir-excel', $params);
  }


}
