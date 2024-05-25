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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->boolean('authorized');
            $table->string('status_details', 255);
            $table->string('access_key', 49);
            $table->text('content')->nullable();
            // Foreign Keys
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'invoice_user')
                ->references('id')->on('users')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
