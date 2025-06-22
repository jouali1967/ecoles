<?php

namespace App\Livewire\Editions;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Etudiant;

class EtatEtudiant extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";

  public $annee_inscriptions;
  public $annee_inscription;
  public $scol_lib;
  public $showResults = false;

  // protected $queryString = ['annee_inscription', 'niv_scol'];

  public function updatingNivScol()
  {
    $this->resetPage();
  }
  public function updatingAnneeInscription()
  {
    $this->resetPage();
  }

  public function mount()
  {
    $this->annee_inscriptions = Etudiant::selectRaw('YEAR(date_insc) as annee')
      ->distinct()
      ->orderBy('annee', 'desc')
      ->pluck('annee')
      ->toArray();
  }

  public function rechercher()
  {
    $this->showResults = true;
    $this->resetPage();
  }
  public function imprimer()
  {
    $params = route('editions.etat_etud.pdf', [
      'annee_insc' => $this->annee_inscription ?? '',
      'scol_lib' => $this->scol_lib ?? '',
    ]);
    $this->dispatch('openEtatWindow', url: $params);
  }
  public function render()
  {
    $etudiants = collect();
    if ($this->showResults) {
      $etudiants = Etudiant::query()
        ->whereHas('lastInscription')
        ->with(['lastInscription.classe'])
        ->when($this->annee_inscription, function ($query) {
          $query->whereYear('date_insc', $this->annee_inscription);
        })
        ->when($this->scol_lib, function ($query) {
          $query->where('niv_scol', $this->scol_lib);
        })
        ->paginate(10);
    }
    return view('livewire.editions.etat-etudiant', [
      'etudiants' => $etudiants
    ]);
  }
}
