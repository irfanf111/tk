<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_identities', function (Blueprint $table) {
            $table->id();
            // General Info
            $table->string('school_name')->default('TK Puspitasari');
            $table->string('npsn')->nullable();
            $table->string('status')->default('Swasta');
            $table->string('education_form')->default('TK');
            $table->string('ownership_status')->default('Yayasan');
            $table->string('establishment_decree')->nullable();
            $table->date('establishment_date')->nullable();
            $table->string('operational_decree')->nullable();
            $table->date('operational_date')->nullable();
            // Address
            $table->string('address')->nullable();
            $table->string('hamlet')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_identities');
    }
};
