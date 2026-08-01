<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matiere_categories', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();
        });

        Schema::create('matiere_cartes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_categorie_id')->constrained('matiere_categories')->cascadeOnDelete();
            $table->string('nom');
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();

            $table->index('matiere_categorie_id');
        });

        $now = now();

        $defaults = [
            [
                'titre' => 'Communication',
                'cartes' => ['Arabe', 'Français', 'Anglais', 'Espagnol', 'Allemand'],
            ],
            [
                'titre' => 'Matières Scientifiques',
                'cartes' => ['Math', 'Physique', 'Chimie', 'SVT'],
            ],
            [
                'titre' => 'C/ Soutien',
                'cartes' => [],
            ],
        ];

        foreach ($defaults as $index => $group) {
            $categorieId = DB::table('matiere_categories')->insertGetId([
                'titre' => $group['titre'],
                'ordre' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($group['cartes'] as $carteIndex => $nom) {
                DB::table('matiere_cartes')->insert([
                    'matiere_categorie_id' => $categorieId,
                    'nom' => $nom,
                    'ordre' => $carteIndex + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('matiere_cartes');
        Schema::dropIfExists('matiere_categories');
    }
};
