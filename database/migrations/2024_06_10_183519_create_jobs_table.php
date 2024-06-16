<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // 'title' => 'required',
            // 'description' => 'required',
            // 'location' => 'required',
            // 'salary' => 'required',
            // 'company' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('salary');
            $table->string('company');
            $table->string('email');
            $table->string('phone');
            // $table->string('status')->default('pending');
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