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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('title');
            $table->text('subject')->nullable();
            $table->string('sender')->nullable();
            $table->date('submission_date');
            $table->date('expiry_date')->nullable();
            $table->string('archive_status')->default('current');
            $table->string('document_type');
            $table->text('notes')->nullable();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->foreignId('storage_location_id')
                ->constrained('storage_locations')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes

            $table->index('archive_status');
            $table->index('document_type');
            $table->index('submission_date');
            $table->index(['department_id', 'archive_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
