<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('contact_owner_id')->nullable();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('account_name')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('other_phone')->nullable();
        $table->string('lead_source')->nullable();
        $table->text('description')->nullable();
        $table->date('dob')->nullable();
        $table->string('address')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->timestamps();

        $table->foreign('contact_owner_id')->references('id')->on('users')->onDelete('set null');
    });
}

    public function down(): void {
        Schema::dropIfExists('contacts');
    }
};
