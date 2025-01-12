<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id'); // ID de la fiche personne modifiée ou concernée
            $table->unsignedBigInteger('proposed_by'); // ID de l'utilisateur qui propose la modification
            $table->text('description'); // Description de la modification proposée
            $table->json('data'); // Les données spécifiques de la proposition (par exemple, les détails de la relation)
            $table->integer('approvals')->default(0); // Compteur d'approbations
            $table->integer('rejections')->default(0); // Compteur de rejets
            $table->boolean('is_approved')->default(false); // Statut de l'approbation
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('proposed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propositions');
    }
};
