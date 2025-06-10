<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable=['nom_matiere'];
    public function classes(){
      return $this->belongsToMany(Classe::class, 'classes_matieres')
                  ->withPivot('coefficient');
    }
}
