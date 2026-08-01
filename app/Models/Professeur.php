<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Professeur extends Model
{
    protected $table = 'professeurs';

    protected $fillable = [
        'reference',
        'date_prof',
        'nom_complet',
        'matiere',
        'statut',
        'etablissement',
        'niveau',
        'type',
        'paiement',
    ];

    protected function casts(): array
    {
        return [
            'date_prof' => 'date',
        ];
    }

    public static function statutLabels(): array
    {
        return [
            'etat' => 'État',
            'prive' => 'Privé',
        ];
    }

    public static function niveauLabels(): array
    {
        return [
            'primaire' => 'Primaire',
            'college' => 'Collège',
            'lycee' => 'Lycée',
        ];
    }

    public static function typeLabels(): array
    {
        return [
            'permanent' => 'Permanent',
            'vacataire' => 'Vacataire',
        ];
    }

    public static function paiementLabels(): array
    {
        return [
            'par-mois' => 'Par/Mois',
            'par-heu' => 'Par/Heu',
            'par-etu' => 'Par/Etu',
            'par-pct' => 'Par/%',
        ];
    }

    public function getStatutLabelAttribute(): string
    {
        return self::statutLabels()[$this->statut] ?? Str::upper((string) $this->statut);
    }

    public function getNiveauLabelAttribute(): string
    {
        return self::niveauLabels()[$this->niveau] ?? Str::upper((string) $this->niveau);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->type] ?? Str::upper((string) $this->type);
    }

    public function getPaiementLabelAttribute(): string
    {
        return self::paiementLabels()[$this->paiement] ?? Str::upper((string) $this->paiement);
    }

    public static function generateReference(): string
    {
        $prefix = 'PR-';

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
