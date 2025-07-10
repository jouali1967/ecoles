<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etudiant extends Model
{
  use HasFactory;

  protected $fillable = [
    'num_enr',
    'code_massar',
    'etud_photo',
    'nom',
    'prenom',
    'nom_ar',
    'prenom_ar',
    'date_nais',
    'lieu_naiss_ar',
    'cin_ar',
    'num_acte_nais',
    'nom_pere',
    'tel_pere',
    'cin_pere',
    'nom_mere',
    'tel_mere',
    'cin_mere',
    'sexe',
    'adresse_ben',
    'dom_ter',
    'sit_soc',
    'handicap',
    'niv_scol',
    'date_insc',
    'date_sortie',
    'ben_part',
    'mont_part','orphelin','type_orphelin','type_handicap'
  ];

  protected $casts = [
    'date_nais' => 'date:d/m/Y',
    'date_insc' => 'date:d/m/Y',
    'date_sortie' => 'date:d/m/Y',
  ];

  public function parental(): HasOne
  {
    return $this->hasOne(Parental::class, 'etudiant_id');
  }

  public function inscriptions(): HasMany
  {
    return $this->hasMany(Inscription::class);
  }

  public function notes(): HasMany
  {
    return $this->hasMany(Note::class);
  }

  public function classe()
  {
    return $this->hasOneThrough(
      Classe::class,
      Inscription::class,
      'etudiant_id',
      'id',
      'id',
      'classe_id'
    );
  }

  /**
   * Dernière inscription de l'étudiant (toutes années)
   */
  public function lastInscription()
  {
    //return $this->hasOne(Inscription::class)->latestOfMany();
    return $this->hasOne(Inscription::class)->orderBy('annee_scol', 'desc');;
  }
  /**
   * Dernière inscription de l'étudiant pour une année donnée
   */
  public function lastInscriptionForYear($annee)
  {
    return $this->hasOne(Inscription::class)
      ->where('annee_scol', $annee)
      ->latestOfMany();
  }

  protected function dateNais(): Attribute
  {
    return Attribute::make(
      get: fn($value) => $value ?
        Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y')
        : null,
      set: fn($value) => $value
        ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        : null,
    );
  }
  protected function dateInsc(): Attribute
  {
    return Attribute::make(
      get: fn($value) => $value ?
        Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y')
        : null,
      set: fn($value) => $value
        ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        : null,
    );
  }
  protected function dateSortie(): Attribute
  {
    return Attribute::make(
      get: fn($value) => $value ?
        Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y')
        : null,
      set: fn($value) => $value
        ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        : null,
    );
  }
}
