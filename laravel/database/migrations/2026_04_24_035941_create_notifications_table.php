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
        // $sensor_type = ['pH', 'arus air', 'katup utama', 'arus listrik', 'kelembaban tanah', 'katup'];

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->text('recomendation');
            $table->enum('source_type', ['global', 'pohon']);
            $table->string('sensor_type');
            $table->enum('severity', ['rendah', 'sedang', 'tinggi']);
            $table->float('value', 2);
            $table->float('threshold', 2);
            $table->unsignedInteger('node_id')->nullable();
            $table->unsignedInteger('tree_id')->nullable();
            $table->boolean('is_active');
            $table->boolean('is_read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
