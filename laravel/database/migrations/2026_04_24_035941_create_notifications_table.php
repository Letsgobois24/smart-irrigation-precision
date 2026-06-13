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
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('event_id', 40)->primary();
            $table->unsignedSmallInteger('tree_id');
            $table->unsignedSmallInteger('node_id')->nullable();
            $table->string('dominant_feature', 40);
            $table->decimal('anomaly_ratio', 6, 3);
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->boolean('is_solved')->default(false);
            $table->timestamps();

            $table->foreign('tree_id')->references('id')->on('trees');
            $table->foreign('dominant_feature')->references('feature_name')->on('notification_rules');
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
