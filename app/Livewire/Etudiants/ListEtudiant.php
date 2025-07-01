<?php

namespace App\Livewire\Etudiants;

use App\Models\Etudiant;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListEtudiant extends Component
{
  use WithPagination;
  use WithoutUrlPagination;
  public $paginationTheme="bootstrap";


  public $search = '';
  public $sortField = 'nom';
  public $sortDirection = 'asc';
  public $annee_scol;
  public $niv_scol;

  public function mount()
  {
    $this->annee_scol = date('Y')  . '/' . (date('Y'))+1;
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function sortBy($field)
  {
    if ($this->sortField === $field) {
      $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
      $this->sortField = $field;
      $this->sortDirection = 'asc';
    }
  }

  public function delete($id)
  {
    $etudiant = Etudiant::find($id);
    if ($etudiant) {
      $etudiant->delete();
      session()->flash('message', 'Étudiant supprimé avec succès.');
    }
  }

  public function render()
  {
    $etudiants = Etudiant::query()
      ->whereHas('lastInscription')
      ->with(['lastInscription.classe'])
      ->when($this->niv_scol, function ($query) {
        $query->where('niv_scol', $this->niv_scol);
      })

      ->when($this->search, function ($query) {
        $query->where(function ($query) {
          $query->where('nom', 'like', '%' . $this->search . '%')
            ->orWhere('prenom', 'like', '%' . $this->search . '%')
            ->orWhere('code_massar', 'like', '%' . $this->search . '%')
            ->orWhere('cin_ar', 'like', '%' . $this->search . '%')
            ->orWhere('num_enr', 'like', '%' . $this->search . '%');
        });
      })
      ->orderBy($this->sortField, $this->sortDirection)
      ->paginate(5);
    //dd($etudiants);

    return view('livewire.etudiants.list-etudiant',
     compact('etudiants'));
  }
}
