<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parental extends Model
{
    use HasFactory;
        protected $fillable = [
        'etudiant_id',
        'nom_pere',
        'phone_pere',
        'nom_mere',
        'phone_mere',
        'handicape',
        'orphelin',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
