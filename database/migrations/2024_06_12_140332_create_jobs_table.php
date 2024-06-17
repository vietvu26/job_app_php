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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('vacancy')->nullable();
            $table->string('salary');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->text('benefits');
            $table->text('responsibility')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('keywords')->nullable();
            $table->text('experience');
            $table->text('company_name');
            $table->text('company_location')->nullable();
            $table->text('company_website')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};