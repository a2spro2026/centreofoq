<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FraisFinancier extends Model
{
    protected $table = 'frais_financiers';

    protected $fillable = [
        'categorie',
        'reference',
        'date_frais',
        'designation',
        'beneficiaire',
        'type_frais',
        'montant',
        'solde',
        'remarque',
    ];

    protected function casts(): array
    {
        return [
            'date_frais' => 'date',
            'montant' => 'decimal:2',
            'solde' => 'decimal:2',
        ];
    }

    public static function categorieLabels(): array
    {
        return [
            'frais-formation' => 'Frais de Formation',
            'frais-profs' => 'Frais des Profs',
            'frais-personnels' => 'Frais Personnels',
            'frais-charges' => 'Frais des Charges',
            'frais-salaires' => 'Frais des Salaires',
        ];
    }

    public static function categoriePrefixes(): array
    {
        return [
            'frais-formation' => 'FFO',
            'frais-profs' => 'FPR',
            'frais-personnels' => 'FPE',
            'frais-charges' => 'FCH',
            'frais-salaires' => 'FSA',
        ];
    }

    public function getCategorieLabelAttribute(): string
    {
        return self::categorieLabels()[$this->categorie] ?? Str::upper((string) $this->categorie);
    }

    public static function generateReference(string $categorie): string
    {
        $prefix = self::categoriePrefixes()[$categorie] ?? 'FRA';
        $year = now()->format('Y');
        $pattern = $prefix.'-'.$year.'-';

        $last = self::query()
            ->where('categorie', $categorie)
            ->where('reference', 'like', $pattern.'%')
            ->orderByDesc('id')
            ->value('reference');

        $next = 1;
        if (is_string($last) && preg_match('/(\d+)$/', $last, $matches)) {
            $next = ((int) $matches[1]) + 1;
        }

        return $pattern.str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    public static function nextReferences(): array
    {
        $refs = [];

        foreach (array_keys(self::categorieLabels()) as $categorie) {
            $refs[$categorie] = self::generateReference($categorie);
        }

        return $refs;
    }
}
