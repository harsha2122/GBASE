<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create pivot table for many-to-many relationship
        Schema::create('page_machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade');
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->unique(['page_id', 'machine_id']);
        });

        // Add form fields to pages table
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('has_form')->default(true);
            $table->string('form_type')->default('contact');
        });

        // Update machines table - keep page column for backward compatibility
        // but it won't be used when pivot table is available
    }

    public function down(): void
    {
        Schema::dropIfExists('page_machines');
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['has_form', 'form_type']);
        });
    }
};
