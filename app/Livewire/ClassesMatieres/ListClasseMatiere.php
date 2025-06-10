<?php

namespace App\Livewire\ClassesMatieres;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClassesMatiere;

class ListClasseMatiere extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['refreshList' => '$refresh'];

    public function render()
    {
      $classesMatieres = ClassesMatiere::with(['classe', 'matiere'])
            ->when($this->search, function($query) {
                $query->whereHas('classe', function($q) {
                    $q->where('nom_classe', 'like', '%' . $this->search . '%');
                })->orWhereHas('matiere', function($q) {
                    $q->where('nom_matiere', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.classes-matieres.list-classe-matiere', [
            'classesMatieres' => $classesMatieres
        ]);
    }

    public function delete($id)
    {
        ClassesMatiere::find($id)->delete();
        session()->flash('message', 'Association supprimée avec succès.');
    }
}
