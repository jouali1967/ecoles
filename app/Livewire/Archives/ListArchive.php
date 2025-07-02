<?php

namespace App\Livewire\Archives;

use App\Models\Archive;
use Livewire\Component;
use App\Models\Inscription;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;


class ListArchive extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme = "bootstrap";
  public $annee_scolaire;
  public $annees_scolaires;
  public $sup_a;
  public $inf_a;
  public $search = '';

  public function mount()
  {
    $this->annees_scolaires = Inscription::select('annee_scol')
      ->distinct()
      ->orderBy('annee_scol', 'desc')
      ->pluck('annee_scol')
      ->toArray();
  }

  public $showResults = false;

  public function filterArchives()
  {
    $validated = $this->validate([
      'annee_scolaire' => 'required',
      'sup_a' => 'nullable|numeric|min:0|max:20',
      'inf_a' => 'nullable|numeric|min:0|max:20',
    ], [
      'annee_scolaire.required' => 'Veuillez sélectionner une année scolaire.',
      'sup_a.numeric' => 'La borne supérieure doit être un nombre.',
      'sup_a.min' => 'La borne supérieure doit être au moins 0.',
      'sup_a.max' => 'La borne supérieure ne peut dépasser 20.',
      'inf_a.numeric' => 'La borne inférieure doit être un nombre.',
      'inf_a.min' => 'La borne inférieure doit être au moins 0.',
      'inf_a.max' => 'La borne inférieure ne peut dépasser 20.',
    ]);
    $this->showResults = true;
  }

  public function render()
  {
    $archives = collect();
    if ($this->showResults && !empty($this->annee_scolaire)) {
      $archives = Archive::with(['etudiant.lastInscription.classe'])
        ->selectRaw('etudiant_id, annee_scol,
                  MAX(CASE WHEN semestre = 1 THEN moyenne END) as moy_s1,
                  MAX(CASE WHEN semestre = 2 THEN moyenne END) as moy_s2,
                  AVG(moyenne) as moyenne_annuelle')
        ->where('annee_scol', $this->annee_scolaire)
        ->groupBy('etudiant_id', 'annee_scol')
        ->when(
          is_numeric($this->sup_a) && $this->sup_a !== '',
          function ($query) {
            $query->havingRaw('AVG(moyenne) > ?', [$this->sup_a]);
          }
        )
        ->when(
          is_numeric($this->inf_a) && $this->inf_a !== '',
          function ($query) {
            $query->havingRaw('AVG(moyenne) < ?', [$this->inf_a]);
          }
        )
        // Ajout du filtre search sur nom, prénom, code massar
        ->when(
          $this->search,
          function ($query) {
            $search = '%' . trim($this->search) . '%';
            $etudiantIds = \App\Models\Etudiant::where('nom', 'like', $search)
              ->orWhere('prenom', 'like', $search)
              ->orWhere('code_massar', 'like', $search)
              ->pluck('id');
            $query->whereIn('etudiant_id', $etudiantIds);
          }
        )
        ->paginate(2);
    }
    return view('livewire.archives.list-archive', [
      'archives' => $archives,
      'showResults' => $this->showResults
    ]);
  }
}
