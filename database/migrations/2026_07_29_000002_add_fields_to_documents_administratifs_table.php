<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents_administratifs', function (Blueprint $table) {
            $table->string('id_beneficiaire')->nullable()->after('beneficiaire');
            $table->string('famille')->nullable()->after('id_beneficiaire');
            $table->string('categorie')->nullable()->after('famille');
            $table->string('statut', 20)->default('non_livre')->after('categorie');
        });
    }

    public function down(): void
    {
        Schema::table('documents_administratifs', function (Blueprint $table) {
            $table->dropColumn(['id_beneficiaire', 'famille', 'categorie', 'statut']);
        });
    }
};
