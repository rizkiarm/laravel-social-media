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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->unique()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('photo_path')->nullable();
            $table->text('description')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('location')->nullable();
            $table->boolean('private')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
