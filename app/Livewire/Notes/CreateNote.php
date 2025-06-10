<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use App\Models\Matiere;
use Livewire\Component;
use App\Models\Etudiant;
use Illuminate\Support\Facades\DB;

class CreateNote extends Component
{
    public $etudiant_id;
    public $matiere_id;
    public $note;
    public $semestre;
    public $matieres;
    public $note_calc;
    public $annee_scol;
    public $searchEtudiant = '';
    public $etudiants;
    public $selectedEtudiant;

    protected $rules = [
        'etudiant_id' => 'required|exists:etudiants,id',
        'matiere_id' => 'required|exists:matieres,id',
        'note' => 'required|numeric|min:0|max:20|regex:/^\d+(\.\d{1,2})?$/',
        'semestre' => 'required|in:1,2',
    ];

    protected function rules()
    {
        return array_merge($this->rules, [
            'matiere_id' => [
                'required',
                'exists:matieres,id',
                function ($attribute, $value, $fail) {
                    $exists = Note::where('etudiant_id', $this->etudiant_id)
                        ->where('matiere_id', $value)
                        ->where('semestre', $this->semestre)
                        ->where('annee_scol', $this->annee_scol)
                        ->exists();
                    
                    if ($exists) {
                        $fail('Une note existe déjà pour cette matière dans ce semestre pour cet étudiant.');
                    }
                },
            ],
        ]);
    }

    public function updatedEtudiantId($value)
    {
        $this->matiere_id = null; // Réinitialiser la matière sélectionnée
        $this->annee_scol = null; // Réinitialiser l'année scolaire
        
        if ($value) {
            $etudiant = Etudiant::with(['inscriptions' => function($query) {
                $query->join(DB::raw('(
                    SELECT etudiant_id, MAX(annee_scol) as max_annee
                    FROM inscriptions
                    GROUP BY etudiant_id
                ) as latest_inscriptions'), function($join) {
                    $join->on('inscriptions.etudiant_id', '=', 'latest_inscriptions.etudiant_id')
                         ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
                });
            }, 'inscriptions.classe.matieres' => function($query) {
                $query->orderBy('nom_matiere');
            }])->find($value);
            
            $classe = $etudiant->inscriptions->first()?->classe;
            
            if ($classe) {
                $this->matieres = $classe->matieres;
                $this->annee_scol = $etudiant->inscriptions->first()->annee_scol;
            } else {
                $this->matieres = collect();
            }
        } else {
            $this->matieres = collect();
        }
    }

    public function updatedNote($value)
    {
        if ($this->matiere_id && $value) {
            $etudiant = Etudiant::with('inscriptions.classe')->find($this->etudiant_id);
            $classe = $etudiant->inscriptions->first()?->classe;
            
            if ($classe) {
                $coefficient = $classe->matieres()
                    ->where('matieres.id', $this->matiere_id)
                    ->first()
                    ->pivot
                    ->coefficient;
                
                $this->note_calc = round((float)$value * (float)$coefficient, 2);
            }
        } else {
            $this->note_calc = null;
        }
    }

    public function updatedMatiereId($value)
    {
        if ($this->note && $value) {
            $etudiant = Etudiant::with('inscriptions.classe')->find($this->etudiant_id);
            $classe = $etudiant->inscriptions->first()?->classe;
            
            if ($classe) {
                $coefficient = $classe->matieres()
                    ->where('matieres.id', $value)
                    ->first()
                    ->pivot
                    ->coefficient;
                
                $this->note_calc = round((float)$this->note * (float)$coefficient, 2);
            }
        } else {
            $this->note_calc = null;
        }
    }

    public function save()
    {
        $data = $this->validate($this->rules());
        
        $etudiant = Etudiant::with(['inscriptions.classe.matieres' => function($query) {
            $query->where('matieres.id', $this->matiere_id);
        }])->find($this->etudiant_id);
        
        $classe = $etudiant->inscriptions->first()?->classe;
        
        if ($classe) {
            $matiere = $classe->matieres->first();
            if ($matiere && isset($matiere->pivot->coefficient)) {
                $coefficient = $matiere->pivot->coefficient;
                $this->note_calc = round((float)$this->note * (float)$coefficient, 2);
            } else {
                session()->flash('error', 'Le coefficient n\'est pas défini pour cette matière dans cette classe.');
                return;
            }
        }
        Note::create([
            'etudiant_id' => $this->etudiant_id,
            'matiere_id' => $this->matiere_id,
            'note' => $this->note,
            'note_calc' => $this->note_calc,
            'semestre' => $this->semestre,
            'annee_scol' => $this->annee_scol,
        ]);
        $this->reset();
        // session()->flash('message', 'Note créée avec succès.');
        // return redirect()->route('notes.index');
    }

    public function updatedSearchEtudiant()
    {
        if (strlen($this->searchEtudiant) >= 2) {
            $this->etudiants = Etudiant::with(['inscriptions' => function($query) {
                $query->join(DB::raw('(
                    SELECT etudiant_id, MAX(annee_scol) as max_annee
                    FROM inscriptions
                    GROUP BY etudiant_id
                ) as latest_inscriptions'), function($join) {
                    $join->on('inscriptions.etudiant_id', '=', 'latest_inscriptions.etudiant_id')
                         ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
                });
            }, 'inscriptions.classe'])
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
                      ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%');
            })
            ->limit(10)
            ->get();
        } else {
            $this->etudiants = collect();
        }
    }

    public function selectEtudiant($id)
    {
        $this->etudiant_id = $id;
        $this->selectedEtudiant = Etudiant::with(['inscriptions' => function($query) {
            $query->join(DB::raw('(
                SELECT etudiant_id, MAX(annee_scol) as max_annee
                FROM inscriptions
                GROUP BY etudiant_id
            ) as latest_inscriptions'), function($join) {
                $join->on('inscriptions.etudiant_id', '=', 'latest_inscriptions.etudiant_id')
                     ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
            });
        }, 'inscriptions.classe'])->find($id);
        
        $this->searchEtudiant = '';
        $this->etudiants = collect();
        
        $this->updatedEtudiantId($id);
    }

    public function render()
    {
        return view('livewire.notes.create-note');
    }
} 