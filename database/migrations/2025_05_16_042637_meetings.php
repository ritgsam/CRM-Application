<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
   public function up()
{
    Schema::create('meetings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->enum('venue', ['In Office', 'Online', 'Client Office']);
        $table->string('location')->nullable();
        $table->boolean('all_day')->default(false);
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->dateTime('scheduled_at');
        $table->unsignedBigInteger('host_id');
        $table->enum('related_to_type', ['None', 'Lead', 'Contact', 'Others'])->default('None');
        $table->unsignedBigInteger('contact_id')->nullable();
        $table->text('description')->nullable();
        // $table->timestamps();
        $table->timestamp('scheduled_at')->nullable();

        $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
    });
}

    public function down(): void
    {
        //
    }
};
