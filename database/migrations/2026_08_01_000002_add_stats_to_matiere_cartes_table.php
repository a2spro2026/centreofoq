<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matiere_cartes', function (Blueprint $table) {
            $table->unsignedInteger('nb_etudiants')->default(0)->after('ordre');
            $table->unsignedInteger('nb_profs')->default(0)->after('nb_etudiants');
            $table->decimal('revenu_mensuel', 12, 2)->default(0)->after('nb_profs');
        });

        $samples = [
            'Arabe' => [28, 3, 8400],
            'Français' => [42, 4, 12600],
            'Anglais' => [36, 3, 10800],
            'Espagnol' => [18, 2, 5400],
            'Allemand' => [12, 1, 3600],
            'Math' => [55, 5, 16500],
            'Physique' => [31, 3, 9300],
            'Chimie' => [24, 2, 7200],
            'SVT' => [27, 2, 8100],
        ];

        foreach ($samples as $nom => [$etu, $profs, $revenu]) {
            DB::table('matiere_cartes')
                ->whereRaw('UPPER(nom) = ?', [mb_strtoupper($nom)])
                ->update([
                    'nb_etudiants' => $etu,
                    'nb_profs' => $profs,
                    'revenu_mensuel' => $revenu,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('matiere_cartes', function (Blueprint $table) {
            $table->dropColumn(['nb_etudiants', 'nb_profs', 'revenu_mensuel']);
        });
    }
};
