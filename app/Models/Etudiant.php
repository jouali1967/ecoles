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
        'nom',
        'prenom',
        'date_nais',
        'adresse',
        'phone',
        'email'
    ];

    protected $casts = [
        'date_nais' => 'date:d/m/Y'
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

    protected function dateNais(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?
                Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y')
                : null,
            set: fn ($value) => $value
                ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
                : null,
        );
    }
}
