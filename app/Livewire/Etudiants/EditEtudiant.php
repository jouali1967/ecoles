<?php

namespace App\Livewire\Etudiants;

use App\Models\Classe;
use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;

class EditEtudiant extends Component
{
  #[Rule('required|min:3')]
  public $nom;
  #[Rule('required|min:3')]
  public $prenom;
  #[Rule('required', 'date_format:d/m/Y')]
  public $date_nais;
  #[Rule('required')]
  public $adresse;
  #[Rule('required')]
  public $phone;
  #[Rule('required|email')]
  public $email;
  #[Rule('required')]
  public $classe_id;
  #[Rule('required')]
  public $annee_scol;

  public $classes;
  public $etudiant;

    public function mount(Etudiant $etudiant)
    {
        $this->etudiant = $etudiant;
        $this->nom = $etudiant->nom;
        $this->prenom = $etudiant->prenom;
        $this->date_nais = $etudiant->date_nais ;
        $this->adresse = $etudiant->adresse;
        $this->phone = $etudiant->phone;
        $this->email = $etudiant->email;
        
        // Récupérer l'inscription active de l'étudiant
        $inscription = $etudiant->inscriptions()->latest()->first();
        $this->classe_id = $inscription ? $inscription->classe_id : null;
        $this->annee_scol = $inscription ? $inscription->annee_scol : null;
        
        $this->classes = Classe::all();
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'date_nais' => 'required|date_format:d/m/Y',
            'adresse' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'classe_id' => 'required',
            'annee_scol' => 'required'
        ]);

        // Mettre à jour les informations de l'étudiant
        $this->etudiant->update([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_nais' => $this->date_nais,
            'adresse' => $this->adresse,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        // Mettre à jour ou créer l'inscription
        $inscription = $this->etudiant->inscriptions()->latest()->first();
        if ($inscription) {
            $inscription->update([
                'classe_id' => $this->classe_id,
                'annee_scol' => $this->annee_scol
            ]);
        } else {
            $this->etudiant->inscriptions()->create([
                'classe_id' => $this->classe_id,
                'annee_scol' => $this->annee_scol
            ]);
        }

        session()->flash('message', 'Étudiant modifié avec succès.');
        return redirect()->route('etudiants.index');
    }

    public function render()
    {
        return view('livewire.etudiants.edit-etudiant');
    }
} 