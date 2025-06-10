<?php

namespace App\Livewire\Etudiants;

use App\Models\Etudiant;
use Livewire\Component;
use Livewire\WithPagination;

class ListEtudiant extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';
    public $annee_scol;

    public function mount()
    {
        $this->annee_scol = (date('Y')-1) . '/' . date('Y');
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
        return view('livewire.etudiants.list-etudiant', [
            'etudiants' => Etudiant::query()
                ->whereHas('inscriptions', function($query) {
                    $query->where('annee_scol', $this->annee_scol);
                })
                ->with(['inscriptions' => function($query) {
                    $query->where('annee_scol', $this->annee_scol);
                }, 'inscriptions.classe'])
                ->when($this->search, function ($query) {
                    $query->where(function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('prenom', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
}
