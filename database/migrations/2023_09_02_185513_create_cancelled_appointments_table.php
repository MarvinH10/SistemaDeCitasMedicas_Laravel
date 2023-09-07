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
        Schema::create('cancelled_appointments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')->references('id')->on('appointments');

            $table->string('justification')->nullable();

            $table->unsignedBigInteger('cancelled_by');
            $table->foreign('cancelled_by')->references('id')->on('users');

            $table->timestamps(); // created_at (cancelled_at), updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_appointments');
    }
};
