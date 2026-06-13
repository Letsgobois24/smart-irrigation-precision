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
        Schema::create('trees', function (Blueprint $table) {
            $table->unsignedSmallInteger('tree_id')->autoIncrement();
            $table->unsignedSmallInteger('node_id');
            $table->string('variant')->nullable();
            $table->unsignedSmallInteger('row_idx')->constrained();
            $table->unsignedSmallInteger('col_idx')->constrained();
            $table->unique(['row_idx', 'col_idx']);
            $table->boolean('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trees');
    }
};
