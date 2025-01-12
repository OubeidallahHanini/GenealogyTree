<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id'); // ID de la fiche personne
            $table->string('email'); // Email de l'invité
            $table->unsignedBigInteger('invited_by'); // Utilisateur qui invite
            $table->string('token', 64)->unique(); // Token d'invitation pour la sécurité
            $table->boolean('accepted')->default(false); // Statut de l'invitation
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('invited_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
