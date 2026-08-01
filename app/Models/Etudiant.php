<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Etudiant extends Model
{
    protected $table = 'etudiants';

    protected $fillable = [
        'reference',
        'date_etudiant',
        'date_inscription',
        'nom_complet',
        'niveau_scolaire',
        'matiere',
        'type_paie',
        'mode_paie',
        'photo',
        'revenu',
        'solde',
    ];

    protected function casts(): array
    {
        return [
            'date_etudiant' => 'date',
            'date_inscription' => 'date',
            'revenu' => 'decimal:2',
            'solde' => 'decimal:2',
        ];
    }

    public static function typePaieLabels(): array
    {
        return [
            'par-mois' => 'Par/Mois',
            'par-trim' => 'Par/Trim',
            'par-an' => 'Par/An',
        ];
    }

    public static function modePaieLabels(): array
    {
        return [
            'esp' => 'Esp',
            'chq' => 'Chq',
            'vir' => 'Vir',
            'vers' => 'Vers',
        ];
    }

    public function getTypePaieLabelAttribute(): string
    {
        return self::typePaieLabels()[$this->type_paie] ?? Str::upper((string) $this->type_paie);
    }

    public function getModePaieLabelAttribute(): string
    {
        return self::modePaieLabels()[$this->mode_paie] ?? Str::upper((string) $this->mode_paie);
    }

    public static function generateReference(): string
    {
        $prefix = 'ID/ET-';

        $last = self::query()
            ->where('reference', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->value('reference');

        $next = 1;
        if (is_string($last) && preg_match('/(\d+)$/', $last, $matches)) {
            $next = ((int) $matches[1]) + 1;
        }

        return $prefix.str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    public static function nextReference(): string
    {
        return self::generateReference();
    }
}
