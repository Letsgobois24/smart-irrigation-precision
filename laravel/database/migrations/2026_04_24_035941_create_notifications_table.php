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
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('event_id', 17);
            $table->unsignedSmallInteger('tree_id');
            $table->unsignedSmallInteger('node_id')->nullable();
            $table->string('dominant_feature', 40);
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('tree_id')->references('tree_id')->on('trees');
            $table->foreign('dominant_feature')->references('feature')->on('notification_rules');
            $table->index('severity');
            $table->index('is_active');
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
