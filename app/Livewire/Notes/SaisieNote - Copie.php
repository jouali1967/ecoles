<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\ClassesMatiere;
use Illuminate\Support\Facades\DB;

class SaisieNote extends Component
{
  public $searchEtudiant;
  public $etudiant_id;
  public $etudiants;
  public $matiere_id;
  public $annee_scol;
  public $matieres;
  public $classe_etu;
  public $selectedEtudiant;
  public $notesEtudiant;
  public $notes = [];
  public $semestre;

  public function mount()
  {
    // Déterminer automatiquement le semestre selon la date
    $mois = date('n');
    if ($mois >= 2 && $mois <= 8) {
      $this->semestre = 2;
    } else {
      $this->semestre = 1;
    }
  }

  public function updatedSearchEtudiant()
  {
    $this->matieres = collect();
    if (strlen($this->searchEtudiant) >= 2) {
      $this->etudiants = Etudiant::with('lastInscription.classe')
      ->where(function ($query) {
      $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
            ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%');
        })
        ->get();
      /*$this->etudiants = Etudiant::with(['inscriptions' => function ($query) {
        $query->join(DB::raw('(
                SELECT etudiant_id, MAX(annee_scol) as max_annee
                FROM inscriptions
                GROUP BY etudiant_id
            ) as latest_inscriptions'), function ($join) {
          $join->on('inscriptions.etudiant_id', '=', 'latest_inscriptions.etudiant_id')
            ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
        });
      }, 'inscriptions.classe'])
        ->where(function ($query) {
          $query->where('nom', 'like', '%' . $this->searchEtudiant . '%')
            ->orWhere('prenom', 'like', '%' . $this->searchEtudiant . '%');
        })
        ->limit(10)
        ->get();*/
    } else {
      $this->etudiants = collect();
    }
    // Réinitialiser les notes
    $this->notes = [];
  }
  public function selectEtudiant(Etudiant $etudiant)
  {
    $this->notes = []; // Réinitialiser les notes pour le nouvel étudiant sélectionné
    $this->etudiant_id = $etudiant;
   /* $this->selectedEtudiant = Etudiant::with(['inscriptions' => function ($query) {
      $query->join(DB::raw('(
                SELECT etudiant_id, MAX(annee_scol) as max_annee
                FROM inscriptions
                GROUP BY etudiant_id
            ) as latest_inscriptions'), function ($join) {
        $join->on('inscriptions.etudiant_id', '=', 'latest_inscriptions.etudiant_id')
          ->on('inscriptions.annee_scol', '=', 'latest_inscriptions.max_annee');
      });
    }, 'inscriptions.classe'])->find($this->etudiant_id->id);*/
    $this->selectedEtudiant = Etudiant::with(['notes', 'lastInscription.classe'])
                    ->find($this->etudiant_id->id);
    $this->searchEtudiant = '';
    $this->etudiants = collect();
    // Vérifier que l'étudiant a des inscriptions avant d'accéder à la classe
    $inscription = $this->etudiant_id->lastInscription;
    if ($inscription) {
      $this->classe_etu = $inscription->classe;
      $this->annee_scol = $inscription->annee_scol;
      $this->matieres = $this->classe_etu->matieres()->withPivot('coefficient')->get();
    } else {
      $this->classe_etu = null;
      $this->annee_scol = null;
      $this->matieres = collect(); // Réinitialiser les matières si pas d'inscription
    }
    $this->notesEtudiant = $this->selectedEtudiant->notes ? $this->selectedEtudiant->notes->keyBy('matiere_id') : collect();
    //dd( $this->notesEtudiant);

    // Pré-remplir les notes pour les champs de saisie
    foreach ($this->matieres as $matiere) {
      $noteExistante = $this->notesEtudiant->get($matiere->id);
      if ($noteExistante) {
        $this->notes[$matiere->id] = [
          'controle1' => $noteExistante->note1,
          'controle2' => $noteExistante->note2,
          'controle3' => $noteExistante->note3,
          'controle4' => $noteExistante->note4,
        ];
      } else {
        // Initialiser avec des valeurs null si aucune note n'existe, pour éviter les erreurs de liaison
        $this->notes[$matiere->id] = [
          'controle1' => null,
          'controle2' => null,
          'controle3' => null,
          'controle4' => null,
        ];
      }
    }
  }


  public function render()
  {
    return view('livewire.notes.saisie-note');
  }
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

    foreach ($this->notes as $matiere_id => $note_values) {
      // Récupérer les valeurs des contrôles, en s'assurant qu'elles sont null si non fournies
      $controle1 = $note_values['controle1'] ?? null;
      $controle2 = $note_values['controle2'] ?? null;
      $controle3 = $note_values['controle3'] ?? null;
      $controle4 = $note_values['controle4'] ?? null;

      // Vérifier si toutes les notes de contrôle sont vides (null ou chaîne vide)
      $isC1Empty = ($controle1 === null || $controle1 === '');
      $isC2Empty = ($controle2 === null || $controle2 === '');
      $isC3Empty = ($controle3 === null || $controle3 === '');
      $isC4Empty = ($controle4 === null || $controle4 === '');

      if ($isC1Empty && $isC2Empty && $isC3Empty && $isC4Empty) {
        // Si toutes les notes sont vides pour cette matière, passer à la suivante
        continue;
      }

      $coefficient = ClassesMatiere::where('classe_id', $this->classe_etu->id)
        ->where('matiere_id', $matiere_id)
        ->value('coefficient'); // Utiliser value() pour obtenir directement le coefficient

      if (is_null($coefficient)) {
        session()->flash('error_matiere_' . $matiere_id, "Coefficient non trouvé pour la matière (ID: {$matiere_id}). Cette note n'a pas été enregistrée.");
        continue; // Passer à la matière suivante si le coefficient n'est pas trouvé
      }

      $noteData = [
        'etudiant_id' => $this->etudiant_id->id,
        'matiere_id' => $matiere_id,
        'note1' => $controle1,
        'note2' => $controle2,
        'note3' => $controle3,
        'note4' => $controle4,
        'note_calc' => $this->calculateNoteCalc(['controle1' => $controle1, 'controle2' => $controle2, 'controle3' => $controle3, 'controle4' => $controle4], $coefficient),
        'semestre' => $this->semestre, // Utilisation automatique du semestre
        'annee_scol' => $this->annee_scol,
        'coefficient'=>$coefficient
      ];

      $existingNote = Note::where('etudiant_id', $this->etudiant_id->id)
        ->where('matiere_id', $matiere_id)
        ->where('semestre', $this->semestre) // Utilisation automatique du semestre
        ->where('annee_scol', $this->annee_scol)
        ->first();

      if ($existingNote) {
        $existingNote->update($noteData);
      } else {
        Note::create($noteData);
      }
      $anyNoteSaved = true;
    }

    if ($anyNoteSaved) {
      session()->flash('message', 'Notes enregistrées avec succès.');
    } else {
      session()->flash('info', 'Aucune note à enregistrer ou mettre à jour.'); // Ou un message plus spécifique si des erreurs de coefficient ont eu lieu
    }
    // Rediriger ou rafraîchir les données si nécessaire
    return redirect()->to('/notes/saisie'); // Exemple de redirection
  }
  protected function calculateNoteCalc($note_values, $coefficient)
  {
    // Récupérer les notes
    $notes = [
      $note_values['controle1'] ?? null,
      $note_values['controle2'] ?? null,
      $note_values['controle3'] ?? null,
      $note_values['controle4'] ?? null,
    ];

    // Filtrer les notes différentes de null
    $notes = array_filter($notes, function ($value) {
      return $value !== null;
    });

    // Calculer la somme
    $somme = array_sum($notes);

    // Calculer la moyenne si des notes sont présentes
    $countNotes = count($notes);
    $moyenne = $countNotes > 0 ? $somme / $countNotes : 0;

    // Calculer note_calc
    return $moyenne;
  }
}
