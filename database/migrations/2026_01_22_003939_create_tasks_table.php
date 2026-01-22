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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // Relasi ke Project
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            // User yang ditugaskan (Assigned To)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable();

            // Status & Prioritas
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['todo', 'in_progress', 'review', 'done'])->default('todo');

            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps(); // Memuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};