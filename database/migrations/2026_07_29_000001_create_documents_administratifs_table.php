<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents_administratifs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('titre');
            $table->string('reference')->nullable();
            $table->string('beneficiaire')->nullable();
            $table->date('date_document')->nullable();
            $table->text('remarque')->nullable();
            $table->timestamps();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents_administratifs');
    }
};
