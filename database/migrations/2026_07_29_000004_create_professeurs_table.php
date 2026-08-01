<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date_prof');
            $table->string('nom_complet');
            $table->string('matiere');
            $table->string('statut', 30);
            $table->string('etablissement')->nullable();
            $table->string('niveau', 30);
            $table->string('type', 30);
            $table->string('paiement', 30);
            $table->timestamps();

            $table->index('date_prof');
            $table->index('statut');
            $table->index('niveau');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professeurs');
    }
};
