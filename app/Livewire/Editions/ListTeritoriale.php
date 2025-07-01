<?php

namespace App\Livewire\Editions;

use Livewire\Component;
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
      //$annee_scol = $this->annee_scolaire;
      $etudiants = DB::table('etudiants')
    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiant_id')
    ->leftJoin('classes', 'inscriptions.classe_id', '=', 'classes.id')
    ->where('etudiants.dom_ter', $this->dom_ter) // boursiers
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
    ->paginate(5);
    
    }
  
      return view('livewire.editions.list-teritoriale',compact('etudiants'));
    }

  public function imprimer(){
      $params = route('editions.listterit.pdf', [
      'dom_ter' => $this->dom_ter ?? '',
    ]);
    $this->dispatch('openEtatWindow', url: $params);
  }

}
