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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('people');
            $table->foreign('child_id')->references('id')->on('people');

            $table->index('created_by');
            $table->index('parent_id');
            $table->index('child_id');
            $table->unique(['parent_id', 'child_id'], 'parent_child_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
