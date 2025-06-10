<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('deals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('deal_owner')->nullable();
        $table->string('deal_name');
        $table->string('account_name')->nullable();
        $table->decimal('amount', 10, 2)->nullable();
        $table->string('lead_source')->nullable();
        $table->string('contact_name')->nullable();
        $table->text('description')->nullable();
        $table->date('closing_date')->nullable();
        $table->timestamps();
        $table->foreign('deal_owner')->references('id')->on('users')->nullOnDelete();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
