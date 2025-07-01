<?php

namespace App\Livewire\Etudiants;

use App\Models\Classe;
use Livewire\Component;
use App\Models\Etudiant;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class EditEtudiant extends Component
{
  use WithFileUploads;

  #[Rule('required', message: 'Le numéro enregistrement est obligatoire.')]
  public $num_enr;
  #[Rule('required', message: 'Le code massar est obligatoire.')]
  public $code_massar;
  #[Rule('required', message: 'Le nom est obligatoire.')]
  // #[Rule('regex:/^[a-z0-9\s]+$/', message: 'Le nom oblogatoire, des chiffres et des espaces.')]
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

  #[Rule('required', message: 'Classe obligatoire')]
  public $classe_id;
  #[Rule('required', message: 'Année Scolaire obligatoire')]
  public $annee_scol;
  public $classes;
  public $etudiant;
  public $etud_photo;
  public $etud_photo_db;

  public function mount(Etudiant $etudiant)
  {
    $this->etudiant = $etudiant;
    $this->num_enr = $etudiant->num_enr;
    $this->code_massar = $etudiant->code_massar;
    $this->nom = $etudiant->nom;
    $this->prenom = $etudiant->prenom;
    $this->nom_ar = $etudiant->nom_ar;
    $this->prenom_ar = $etudiant->prenom_ar;
    $this->date_nais = $etudiant->date_nais;
    $this->lieu_naiss_ar = $etudiant->lieu_naiss_ar;
    $this->cin_ar = $etudiant->cin_ar;
    $this->num_acte_nais = $etudiant->num_acte_nais;
    $this->nom_pere = $etudiant->nom_pere;
    $this->tel_pere = $etudiant->tel_pere;
    $this->cin_pere = $etudiant->cin_pere;
    $this->nom_mere = $etudiant->nom_mere;
    $this->tel_mere = $etudiant->tel_mere;
    $this->cin_mere = $etudiant->cin_mere;
    $this->sexe = $etudiant->sexe;
    $this->adresse_ben = $etudiant->adresse_ben;
    $this->dom_ter = $etudiant->dom_ter;
    $this->sit_soc = $etudiant->sit_soc;
    $this->handicap = $etudiant->handicap;
    $this->niv_scol = $etudiant->niv_scol;
    $this->date_insc = $etudiant->date_insc;
    $this->date_sortie = $etudiant->date_sortie;
    $this->ben_part = $etudiant->ben_part;
    $this->mont_part = $etudiant->mont_part;
    $this->etud_photo_db = $this->etudiant->etud_photo;
    // Récupérer l'inscription active de l'étudiant
    // $inscription = $etudiant->inscriptions()->latest()->first();
    // $this->classe_id = $inscription ? $inscription->classe_id : null;
    // $this->annee_scol = $inscription ? $inscription->annee_scol : null;

    $inscriptions = $etudiant->inscriptions()->get();
    $derniereInscription = $inscriptions->sortByDesc('annee_scol')->first();
    $this->classe_id = $derniereInscription ? $derniereInscription->classe_id : null;
    $this->annee_scol = $derniereInscription ? $derniereInscription->annee_scol : null;

    $this->classes = Classe::all();
  }

  public function save()
  {
    $validatedData = $this->validate();
    // Gestion de la photo : nouvelle ou ancienne
    if ($this->etud_photo) {
      // S'assurer que le dossier uploads existe
      if (!file_exists(public_path('uploads'))) {
        mkdir(public_path('uploads'), 0777, true);
      }
      $nomFichier = uniqid() . '.' . $this->etud_photo->getClientOriginalExtension();
      $destination = public_path('uploads/' . $nomFichier);
      $tmpPath = $this->etud_photo->getRealPath();
      if (copy($tmpPath, $destination)) {
        @unlink($tmpPath);
        $validatedData['etud_photo'] = $nomFichier;
      } else {
        session()->flash('error', "Erreur lors de la copie de la photo. Vérifiez les permissions du dossier uploads.");
        return;
      }
    } else {
      $validatedData['etud_photo'] = $this->etudiant->etud_photo;
    }
    $this->etudiant->update($validatedData);

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
