<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentAdministratif extends Model
{
    protected $table = 'documents_administratifs';

    protected $fillable = [
        'type',
        'titre',
        'reference',
        'beneficiaire',
        'id_beneficiaire',
        'famille',
        'categorie',
        'statut',
        'date_document',
        'remarque',
    ];

    protected function casts(): array
    {
        return [
            'date_document' => 'date',
        ];
    }

    public static function typeLabels(): array
    {
        return [
            'attestation' => 'Attestation',
            'diplomes' => 'Diplômes',
            'certificats' => 'Certificats',
            'releve-notes' => 'Relevé De Notes',
            'etudiant-stagiaire' => 'Étudiant / Stagiaire',
        ];
    }

    public static function typePrefixes(): array
    {
        return [
            'attestation' => 'ATT',
            'diplomes' => 'DIP',
            'certificats' => 'CER',
            'releve-notes' => 'REL',
            'etudiant-stagiaire' => 'ETS',
        ];
    }

    public static function statutLabels(): array
    {
        return [
            'livre' => 'Livré',
            'non_livre' => 'Non Livré',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->type] ?? Str::upper((string) $this->type);
    }

    public function getStatutLabelAttribute(): string
    {
        return self::statutLabels()[$this->statut] ?? 'Non Livré';
    }

    public static function generateReference(string $type): string
    {
        $prefix = self::typePrefixes()[$type] ?? 'DOC';
        $year = now()->format('Y');
        $pattern = $prefix.'-'.$year.'-';

        $last = self::query()
            ->where('type', $type)
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

        foreach (array_keys(self::typeLabels()) as $type) {
            $refs[$type] = self::generateReference($type);
        }

        return $refs;
    }
}
