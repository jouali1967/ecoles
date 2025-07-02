<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    protected $fillable =['etudiant_id','annee_scol','classe_id','semestre','moyenne'];
    public function etudiant(){
      return $this->belongsTo(Etudiant::class);
    }
}
