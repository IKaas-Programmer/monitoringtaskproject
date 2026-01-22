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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Task: Jika task dihapus, komentar otomatis terhapus
            $table->foreignId('task_id')->constrained()->onDelete('cascade');

            // Foreign Key ke User: Mengetahui siapa pengirimnya
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->text('body');

            // Fitur tambahan: Lampiran file/gambar
            $table->string('attachment')->nullable();

            $table->timestamps(); // Mencatat created_at (waktu chat)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};