<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable=['etudiant_id','date_event','description'];
    protected $casts = [
    'date_event' => 'date:d/m/Y',
  ];
    protected function dateEvent(): Attribute
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
      public function etudiant(): BelongsTo
  {
    return $this->belongsTo(Etudiant::class);
  }


}
