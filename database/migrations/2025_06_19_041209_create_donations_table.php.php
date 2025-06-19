<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->date('donation_date');
            $table->text('notes')->nullable();
            $table->decimal('total_value', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
};