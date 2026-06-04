<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_identities', function (Blueprint $table) {
            $table->string('naungan')->nullable();
            $table->string('accreditation')->nullable();
            $table->date('accreditation_date')->nullable();
            $table->string('accreditation_decree')->nullable();
            $table->string('certification')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('headmaster')->nullable();
            $table->string('operator')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('school_identities', function (Blueprint $table) {
            $table->dropColumn([
                'naungan',
                'accreditation',
                'accreditation_date',
                'accreditation_decree',
                'certification',
                'phone',
                'email',
                'website',
                'headmaster',
                'operator',
            ]);
        });
    }
};
