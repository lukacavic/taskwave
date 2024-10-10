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
        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('user_id');
            $table->string('color')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('organisation_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_categories');
    }
};
