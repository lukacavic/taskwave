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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->smallInteger('user_id');
            $table->nullableMorphs('related');
            $table->smallInteger('priority_id');
            $table->smallInteger('status_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
