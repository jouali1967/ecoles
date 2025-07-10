<?php

namespace App\Livewire\Etudiants;

use App\Models\Classe;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class CreateEtudiant extends Component
{
  use WithFileUploads;

  #[Rule('required', message: 'Le numéro enregistrement est obligatoire.')]
  public $num_enr;
  #[Rule('required', message: 'Le code massar est obligatoire.')]
  public $code_massar;
  #[Rule('required', message: 'Le nom est obligatoire.')]
  public $nom;
  #[Rule('required', message: 'Le prenom est obligatoire.')]
  // #[Rule('regex:/^[a-z0-9\s]+$/', message: 'Le prénom oblogatoire, des chiffres et des espaces.')]
  public $prenom;
  #[Rule('required', message: 'Nom arabe obligatoire')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $nom_ar;
  #[Rule('required', message: 'Prénom arabe obligatoire')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Prénom doit etre en arabe')]
  public $prenom_ar;
  #[Rule('required', message: "La date naissance est obligatoire.")]
  #[Rule('date_format:d/m/Y', message: "Le format de la date doit être JJ/MM/AAAA.")]
  public $date_nais;
  #[Rule('nullable')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Lieu naissance doit etre en arabe')]
  public $lieu_naiss_ar;
  #[Rule('nullable')]
  public $cin_ar;
  #[Rule('nullable')]
  public $num_acte_nais;
  #[Rule('nullable')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $nom_pere;
  #[Rule('nullable')]
  public $tel_pere;
  #[Rule('nullable')]
  public $cin_pere;
  #[Rule('nullable')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $nom_mere;
  #[Rule('nullable')]
  public $tel_mere;
  #[Rule('nullable')]
  public $cin_mere;
  #[Rule('required', message: 'Sexe est obligatoire')]
  public $sexe = 'F';
  #[Rule('nullable')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $adresse_ben;
  #[Rule('nullable')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $dom_ter;
  #[Rule('required',message:'الوضع الاجتماعي ضروري')]
  #[Rule('regex:/^[\x{0600}-\x{06FF} ]+$/u', message: 'Nom doit etre en arabe')]
  public $sit_soc;
  #[Rule('required', message: 'Sexe est obligatoire')]
  public $handicap = 'non';
  #[Rule('required')]
  public $niv_scol;

  #[Rule('required', message: "La date inscription est obligatoire.")]
  #[Rule('date_format:d/m/Y', message: "Le format de la date doit être JJ/MM/AAAA.")]
  public $date_insc;
  #[Rule('nullable')]
  #[Rule('date_format:d/m/Y', message: "Le format de la date doit être JJ/MM/AAAA.")]
  public $date_sortie;
  #[Rule('required')]
  public $ben_part = 'oui';
  #[Rule('nullable')]
  public $mont_part;

  public $etud_photo;
  #[Rule('required', message: 'Classe obligatoire')]
  public $classe_id;
  #[Rule('required', message: 'Année Scolaire obligatoire')]
  public $annee_scol;

  #[Rule('required', message: 'Champ orphelin obligatoire')]
  public $orphelin = 'non';
  #[Rule('nullable')]
  public $type_handicap;
  #[Rule('nullable')]
  public $type_orphelin;

  public function mount()
  {
    $annee = date('Y');
    $annee_suiv = $annee + 1;
    $this->annee_scol = $annee . '/' . $annee_suiv;
  }

  public function render()
  {
    $classes = Classe::get();
    return view('livewire.etudiants.create-etudiant', compact('classes'));
  }

  public function save()
  {
    $dataEtudiant = $this->validate();
    // S'assurer que le dossier uploads existe
    if (!file_exists(public_path('uploads'))) {
      mkdir(public_path('uploads'), 0777, true);
    }
    // Gestion de l'upload de la photo
    if ($this->etud_photo) {
      $nomFichier = uniqid() . '.' . $this->etud_photo->getClientOriginalExtension();
      $destination = public_path('uploads/' . $nomFichier);
      $tmpPath = $this->etud_photo->getRealPath();
      // Utiliser copy() puis unlink() pour éviter les problèmes de verrouillage Windows
      if (copy($tmpPath, $destination)) {
        @unlink($tmpPath);
        $dataEtudiant['etud_photo'] = $nomFichier;
      } else {
        // Gestion d'erreur explicite
        session()->flash('error', "Erreur lors de la copie de la photo. Vérifiez les permissions du dossier uploads.");
        return;
      }
    } else {
      $dataEtudiant['etud_photo'] = null;
    }
    //Créer un nouvel étudiant
    $etudiant = Etudiant::create($dataEtudiant);
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
