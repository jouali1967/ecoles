<?php

namespace App\Livewire\Archives;

use Livewire\Component;
use App\Models\Archive;

class EditArchive extends Component
{
  public $etudiant_id;
  public $annee_scol;
  public $archives = [];
  public $editIndex = null;
  public $editMoyenne = null;

  public function mount($etudiant_id, $annee_scol)
  {
    $this->etudiant_id = $etudiant_id;
    // Décodage de l'année scolaire (remplace - par /)
    $decoded_annee = str_replace('-', '/', $annee_scol);
    $this->annee_scol = $decoded_annee;
    $this->archives = Archive::where('etudiant_id', $etudiant_id)
      ->where('annee_scol', $decoded_annee)
      ->get()->toArray();
  }

  public function startEdit($index)
  {
    $this->editIndex = $index;
    $this->editMoyenne = $this->archives[$index]['moyenne'];
  }

  public function saveEdit($archiveId)
  {
    $this->validate([
      'editMoyenne' => 'required|numeric|min:0|max:20',
    ], [
      'editMoyenne.required' => 'La moyenne est requise.',
      'editMoyenne.numeric' => 'La moyenne doit être un nombre.',
      'editMoyenne.min' => 'La moyenne doit être au moins 0.',
      'editMoyenne.max' => 'La moyenne ne peut dépasser 20.',
    ]);
    $archive = Archive::find($archiveId);
    if ($archive) {
      $archive->moyenne = $this->editMoyenne;
      $archive->save();
      $this->archives[$this->editIndex]['moyenne'] = $this->editMoyenne;
    }
    $this->editIndex = null;
    $this->editMoyenne = null;
  }

  public function cancelEdit()
  {
    $this->editIndex = null;
    $this->editMoyenne = null;
  }

  public function render()
  {
    return view('livewire.archives.edit-archive', [
      'archives' => $this->archives,
      'editIndex' => $this->editIndex,
      'editMoyenne' => $this->editMoyenne
    ]);
  }
}
