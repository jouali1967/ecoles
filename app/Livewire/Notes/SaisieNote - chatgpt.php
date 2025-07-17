<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\ClassesMatiere;

class SaisieNote extends Component
{
    public $selectedEtudiant;
    public $classe_etu;
    public $annee_scol;
    public $semestre;
    public $notes = [];

    public function mount()
    {
        if ($this->selectedEtudiant && $this->classe_etu) {
            $this->loadMatieresEtNotes();
        }
    }

    /**
     * Charger les matières et leurs coefficients + notes existantes si elles existent
     */
    public function loadMatieresEtNotes()
    {
        $matieres = ClassesMatiere::where('classe_id', $this->classe_etu->id)
            ->with('matiere')
            ->get();

        foreach ($matieres as $matiere) {
            $existingNote = Note::where('etudiant_id', $this->selectedEtudiant->id)
                ->where('matiere_id', $matiere->matiere_id)
                ->where('semestre', $this->semestre)
                ->where('annee_scol', $this->annee_scol)
                ->first();

            $this->notes[$matiere->matiere_id] = [
                'controle1' => $existingNote->note1 ?? null,
                'controle2' => $existingNote->note2 ?? null,
                'controle3' => $existingNote->note3 ?? null,
                'controle4' => $existingNote->note4 ?? null,
                'coefficient' => $matiere->coefficient,
            ];
        }
    }

    /**
     * Sauvegarde des notes
     */
    public function save()
    {
        if (!$this->selectedEtudiant) {
            session()->flash('error', 'Aucun étudiant sélectionné. Impossible d\'enregistrer les notes.');
            return;
        }

        if (!$this->classe_etu) {
            session()->flash('error', 'Les informations de la classe de l\'étudiant sont manquantes. Impossible d\'enregistrer les notes.');
            return;
        }

        $anyNoteSaved = false;
        $allEmpty = true; // ✅ Vérifier si toutes les matières sont vides

        foreach ($this->notes as $matiere_id => $note_values) {
            $controle1 = $note_values['controle1'] ?? null;
            $controle2 = $note_values['controle2'] ?? null;
            $controle3 = $note_values['controle3'] ?? null;
            $controle4 = $note_values['controle4'] ?? null;

            $isC1Empty = ($controle1 === null || $controle1 === '');
            $isC2Empty = ($controle2 === null || $controle2 === '');
            $isC3Empty = ($controle3 === null || $controle3 === '');
            $isC4Empty = ($controle4 === null || $controle4 === '');

            if ($isC1Empty && $isC2Empty && $isC3Empty && $isC4Empty) {
                continue;
            }

            $allEmpty = false; // ✅ Au moins une note saisie

            $coefficient = $note_values['coefficient'] ?? ClassesMatiere::where('classe_id', $this->classe_etu->id)
                ->where('matiere_id', $matiere_id)
                ->value('coefficient');

            if (is_null($coefficient)) {
                session()->flash('error_matiere_' . $matiere_id, "Coefficient non trouvé pour la matière (ID: {$matiere_id}). Cette note n'a pas été enregistrée.");
                continue;
            }

            $noteData = [
                'etudiant_id' => $this->selectedEtudiant->id,
                'matiere_id' => $matiere_id,
                'note1' => $controle1,
                'note2' => $controle2,
                'note3' => $controle3,
                'note4' => $controle4,
                'note_calc' => $this->calculateNoteCalc([
                    'controle1' => $controle1,
                    'controle2' => $controle2,
                    'controle3' => $controle3,
                    'controle4' => $controle4
                ], $coefficient),
                'semestre' => $this->semestre,
                'annee_scol' => $this->annee_scol,
                'coefficient' => $coefficient
            ];

            $existingNote = Note::where('etudiant_id', $this->selectedEtudiant->id)
                ->where('matiere_id', $matiere_id)
                ->where('semestre', $this->semestre)
                ->where('annee_scol', $this->annee_scol)
                ->first();

            if ($existingNote) {
                $existingNote->update($noteData);
            } else {
                Note::create($noteData);
            }

            $anyNoteSaved = true;
        }

        // ✅ Si toutes les matières sont vides
        if ($allEmpty) {
            session()->flash('error', 'Aucune note renseignée pour aucune matière. Veuillez saisir au moins un contrôle.');
            return;
        }

        if ($anyNoteSaved) {
            session()->flash('message', 'Notes enregistrées avec succès.');
        } else {
            session()->flash('info', 'Aucune note enregistrée. Vérifiez les coefficients ou les données.');
        }

        // ✅ Recharge les coefficients après sauvegarde
        $this->loadMatieresEtNotes();
    }

    /**
     * Exemple de calcul de la note calculée
     */
    private function calculateNoteCalc($notes, $coefficient)
    {
        // Exemple : moyenne simple des contrôles non vides
        $validNotes = array_filter($notes, fn($n) => $n !== null && $n !== '');
        if (count($validNotes) === 0) {
            return null;
        }
        return array_sum($validNotes) / count($validNotes);
    }

    public function render()
    {
        return view('livewire.saisie-note');
    }
}
