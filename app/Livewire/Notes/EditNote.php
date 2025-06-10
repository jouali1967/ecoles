<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\Etudiant;
use Illuminate\Validation\Rule;

class EditNote extends Component
{
    public $note;
    public $etudiant_id;
    public $matiere_id;
    public $note_value;
    public $semestre;
    public $note_calc;
    public $matieres;

    protected function rules()
    {
        $rules = [
            'matiere_id' => 'required|exists:matieres,id',
            'note_value' => 'required|numeric|min:0|max:20|regex:/^\d+(\.\d{1,2})?$/',
            'semestre' => 'required|in:1,2',
        ];

        // Si la matière a été changée, ajouter la règle d'unicité
        if ($this->matiere_id != $this->note->matiere_id) {
            $rules['matiere_id'] = [
                'required',
                'exists:matieres,id',
                Rule::unique('notes')->where(function ($query) {
                    return $query->where('etudiant_id', $this->etudiant_id)
                                ->where('matiere_id', $this->matiere_id)
                                ->where('semestre', $this->semestre);
                })
            ];
        }

        return $rules;
    }

    protected $messages = [
        'matiere_id.unique' => 'Une note existe déjà pour cet étudiant dans cette matière pour ce semestre.',
    ];

    public function mount(Note $note)
    {
        $this->note = $note;
        $this->etudiant_id = $note->etudiant_id;
        $this->matiere_id = $note->matiere_id;
        $this->note_value = $note->note;
        $this->semestre = $note->semestre;
        $this->note_calc = $note->note_calc;

        // Charger les matières de la classe de l'étudiant
        $this->loadMatieres();
    }

    public function updatedNoteValue()
    {
        $this->calculateNoteCalc();
    }

    public function updatedMatiereId()
    {
        $this->loadMatieres();
        $this->calculateNoteCalc();
    }

    private function calculateNoteCalc()
    {
        if (!$this->matiere_id || !$this->note_value) {
            $this->note_calc = 0;
            return;
        }

        $etudiant = Etudiant::with(['inscriptions.classe.matieres' => function($query) {
            $query->where('matieres.id', $this->matiere_id);
        }])->find($this->etudiant_id);
        
        if (!$etudiant) {
            $this->note_calc = 0;
            return;
        }

        $classe = $etudiant->inscriptions->first()?->classe;
        if (!$classe) {
            $this->note_calc = 0;
            return;
        }

        $matiere = $classe->matieres->first();
        if (!$matiere || !isset($matiere->pivot->coefficient)) {
            $this->note_calc = 0;
            return;
        }

        $coefficient = $matiere->pivot->coefficient;
        $this->note_calc = round((float)$this->note_value * (float)$coefficient, 2);
    }

    private function loadMatieres()
    {
        $etudiant = Etudiant::with('inscriptions.classe.matieres')->find($this->etudiant_id);
        $classe = $etudiant->inscriptions->first()?->classe;
        $this->matieres = $classe ? $classe->matieres : collect();
    }

    public function save()
    {
        $this->validate();
        $this->calculateNoteCalc();

        $this->note->update([
            'matiere_id' => $this->matiere_id,
            'note' => $this->note_value,
            'note_calc' => $this->note_calc,
            'semestre' => $this->semestre,
        ]);

        session()->flash('message', 'Note modifiée avec succès.');
        return redirect()->route('notes.index');
    }

    public function render()
    {
        $etudiant = Etudiant::with('inscriptions.classe')->find($this->etudiant_id);
        return view('livewire.notes.edit-note', [
            'etudiant' => $etudiant
        ]);
    }
} 