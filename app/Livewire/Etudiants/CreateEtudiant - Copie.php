<?php

namespace App\Livewire\Etudiants;

use App\Models\Classe;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use Livewire\Attributes\Rule;

class CreateEtudiant extends Component
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

  #[Rule('required|min:2|regex:/^[\x{0600}-\x{06FF} ]+$/u')]
  public $nom_ar;
  #[Rule('required|min:2|regex:/^[\x{0600}-\x{06FF} ]+$/u')]
  public $prenom_ar;

  public function render()
  {
    $classes = Classe::get();
    return view('livewire.etudiants.create-etudiant', compact('classes'));
  }

  public function save()
  {
    $this->validate();

    // Créer un nouvel étudiant
    $etudiant = Etudiant::create([
      'nom' => $this->nom,
      'prenom' => $this->prenom,
      'nom_ar' => $this->nom_ar,
      'prenom_ar' => $this->prenom_ar,
      'date_nais' => $this->date_nais,
      'adresse' => $this->adresse,
      'phone' => $this->phone,
      'email' => $this->email
    ]);

    // Créer l'inscription
    Inscription::create([
      'etudiant_id' => $etudiant->id,
      'classe_id' => $this->classe_id,
      'annee_scol' => $this->annee_scol
    ]);

    session()->flash('message', 'Étudiant créé et inscrit avec succès.');
    return redirect()->route('etudiants.index');
  }
}
