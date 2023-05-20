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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('po')->nullable();
            $table->string('itemref');
            $table->string('company');
            $table->string('category');
            $table->string('type');
            $table->longText('price')->nullable();
            $table->longText('description');
            $table->string('images');
            $table->longText('file')->nullable();
            $table->string('addedby');
            $table->string('updatedby')->nullable();
            $table->string('archived')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
