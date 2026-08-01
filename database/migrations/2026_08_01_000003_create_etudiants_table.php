<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date_etudiant');
            $table->date('date_inscription');
            $table->string('nom_complet');
            $table->string('niveau_scolaire');
            $table->string('matiere');
            $table->string('type_paie', 30);
            $table->string('mode_paie', 30);
            $table->string('photo')->nullable();
            $table->decimal('revenu', 12, 2)->default(0);
            $table->decimal('solde', 12, 2)->default(0);
            $table->timestamps();

            $table->index('date_etudiant');
            $table->index('date_inscription');
            $table->index('matiere');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
