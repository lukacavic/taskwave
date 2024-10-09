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
        Schema::create('ticket_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('imap_host')->nullable();
            $table->string('imap_username')->nullable();
            $table->string('imap_password')->nullable();
            $table->string('imap_port')->nullable();
            $table->string('imap_encryption')->nullable();
            $table->string('imap_folder')->nullable();
            $table->boolean('imap_delete_after_import')->default(false);
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
        Schema::dropIfExists('ticket_departments');
    }
};
