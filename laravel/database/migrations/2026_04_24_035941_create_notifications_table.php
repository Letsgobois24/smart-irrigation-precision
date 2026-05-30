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
            $table->enum('source_type', ['global', 'tree']);
            $table->string('sensor_type');
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->float('value', 2);
            $table->float('threshold', 2);
            $table->unsignedInteger('node_id')->nullable();
            $table->foreignId('tree_id')
                ->nullable()
                ->constrained('trees', 'tree_id');
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
