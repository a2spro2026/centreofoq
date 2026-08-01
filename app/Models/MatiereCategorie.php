<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatiereCategorie extends Model
{
    protected $table = 'matiere_categories';

    protected $fillable = [
        'titre',
        'ordre',
    ];

    public function cartes(): HasMany
    {
        return $this->hasMany(MatiereCarte::class, 'matiere_categorie_id')->orderBy('ordre')->orderBy('id');
    }
}
