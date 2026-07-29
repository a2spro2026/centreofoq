<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frais_financiers', function (Blueprint $table) {
            $table->id();
            $table->string('categorie', 50);
            $table->string('reference')->nullable();
            $table->date('date_frais');
            $table->string('designation');
            $table->string('beneficiaire')->nullable();
            $table->string('type_frais')->nullable();
            $table->decimal('montant', 12, 2)->default(0);
            $table->decimal('solde', 12, 2)->default(0);
            $table->text('remarque')->nullable();
            $table->timestamps();

            $table->index('categorie');
            $table->index('date_frais');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frais_financiers');
    }
};
