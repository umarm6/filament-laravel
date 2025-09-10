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
        Schema::create('type_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('type_assignment_type');
            $table->integer('type_assigment_id');
            $table->string('my_bonus_filed');
            $table->integer('type_id');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_assigments');
    }
};
