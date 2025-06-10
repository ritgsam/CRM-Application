<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('leads', function (Blueprint $table) {
        $table->id();

    $table->unsignedBigInteger('account_id')->nullable();

        $table->string('name');
        $table->string('company')->nullable();
        $table->string('lead_owner')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->text('notes')->nullable();
        $table->string('title')->nullable();
        $table->string('first_name');
        $table->string('second_name')->nullable();
        $table->decimal('annual_revenue', 15, 2)->nullable();
        $table->string('website')->nullable();
        $table->integer('employees')->nullable();
        $table->string('rating')->nullable();
        $table->string('secondary_email')->nullable();
        $table->string('street')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->string('zip_code')->nullable();
        $table->string('lead_image')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
{
    Schema::dropIfExists('leads');
}

};
