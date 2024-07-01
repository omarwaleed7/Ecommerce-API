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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('f_name',45);
            $table->string('l_name',45);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_picture',512)->nullable();
            $table->string('phone_number',20);
            $table->string('provider_id')->nullable();
            $table->string('provider_type')->nullable();
            $table->enum('is_admin',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
