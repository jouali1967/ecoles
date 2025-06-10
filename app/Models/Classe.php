<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $fillable=['nom_classe'];
    public function matieres(){
      return $this->belongsToMany(Matiere::class, 'classes_matieres')
                  ->withPivot('coefficient');
    }
}
