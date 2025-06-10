<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListNote extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $annee_scol;

    public function mount()
    {
        $this->annee_scol = (date('Y')-1) . '/' . date('Y');
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
        Note::find($id)->delete();
        session()->flash('message', 'Note supprimée avec succès.');
    }

    public function render()
    {
        return view('livewire.notes.list-note', [
            'notes' => Note::with(['etudiant', 'matiere'])
                ->where('annee_scol', $this->annee_scol)
                ->when($this->search, function($query) {
                    $query->whereHas('etudiant', function($q) {
                        $q->where('nom', 'like', '%' . $this->search . '%')
                          ->orWhere('prenom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('matiere', function($q) {
                        $q->where('nom_matiere', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
} 