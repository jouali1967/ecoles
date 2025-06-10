<?php

namespace App\Livewire\Parents;

use App\Models\Parental;
use Livewire\Component;
use Livewire\WithPagination;

class ListParent extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['parentUpdated' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $parent = Parental::find($id);
        if ($parent) {
            $parent->delete();
            session()->flash('message', 'Parent supprimé avec succès.');
        }
    }

    public function render()
    {
        $parents = Parental::with(['etudiant.inscriptions.classe'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nom_pere', 'like', '%' . $this->search . '%')
                      ->orWhere('nom_mere', 'like', '%' . $this->search . '%')
                      ->orWhereHas('etudiant', function($q) {
                          $q->where('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('prenom', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.parents.list-parent', [
            'parents' => $parents
        ]);
    }
} 