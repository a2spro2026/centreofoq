<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatiereCarte extends Model
{
    protected $table = 'matiere_cartes';

    protected $fillable = [
        'matiere_categorie_id',
        'nom',
        'ordre',
        'nb_etudiants',
        'nb_profs',
        'revenu_mensuel',
    ];

    protected function casts(): array
    {
        return [
            'nb_etudiants' => 'integer',
            'nb_profs' => 'integer',
            'revenu_mensuel' => 'decimal:2',
        ];
    }
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(MatiereCategorie::class, 'matiere_categorie_id');
    }
}
