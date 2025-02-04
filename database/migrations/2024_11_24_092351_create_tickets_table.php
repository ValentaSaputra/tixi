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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->string('address');
            $table->string('thumbnail');
            $table->string('path_video');
            $table->unsignedBigInteger('price'); //unsigned tidak bisa negatif
            $table->boolean('is_popular');
            $table->text('about');
            $table->time('open_time_at');
            $table->time('closed_time_at');
            $table->decimal('rating', 2, 1)->nullable(); 
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained()->cascadeOnDelete();
            $table->softDeletes(); //data akan di hapus agar tidak muncul di interface tetapi data masih tetap ada di database

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
