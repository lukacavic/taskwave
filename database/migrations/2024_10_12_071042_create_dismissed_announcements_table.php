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
        Schema::create('dismissed_announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('announcement_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('contact_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dismissed_announcements');
    }
};
