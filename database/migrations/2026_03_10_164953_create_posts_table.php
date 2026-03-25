<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel posts dulu
        // Di dalam file create_posts_table atau file utama kamu
    Schema::create('posts', function (Blueprint $table) {
        $table->id(); // ID utama
        $table->string('title');
        $table->string('slug')->unique();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete(); 
        $table->string('color')->nullable();
        $table->string('image')->nullable();
        $table->text('body')->nullable();
        $table->boolean('published')->default(false);
        $table->date('published_at')->nullable();
        $table->timestamps();
    });

// Pastikan tabel tags dan post_tag juga ada di bawahnya atau di file terpisah yang urutannya benar
        // 2. Buat tabel tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 3. Terakhir buat tabel pivot post_tag
        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        // Hapus dengan urutan terbalik (pivot dulu baru induk)
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('posts');
    }
};