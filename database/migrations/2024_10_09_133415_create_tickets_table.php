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
            $table->uuid('uuid')->default(\Illuminate\Support\Str::uuid());
            $table->string('subject');
            $table->text('body');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('priority_id');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('assigned_user_id')->nullable();
            $table->timestamp('last_reply_at')->nullable();
            $table->unsignedInteger('organisation_id');
            $table->softDeletes();
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
