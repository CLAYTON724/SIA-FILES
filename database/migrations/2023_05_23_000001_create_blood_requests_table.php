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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users');
            $table->string('blood_type');
            $table->string('urgency'); // critical, urgent, moderate
            $table->string('location');
            $table->string('requester_name');
            $table->string('contact_phone');
            $table->integer('units_needed');
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active, fulfilled, cancelled
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
