<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('account_name');
            $table->string('account_site')->nullable();
            $table->string('account_number')->nullable();
            $table->enum('account_type', ['Customer', 'Distributor', 'Partner', 'Vendor', 'Other'])->nullable();
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->enum('ownership', ['Other', 'Private', 'Public', 'Partnership', 'Government'])->nullable();
            $table->integer('employees')->nullable();

            $table->string('billing_street')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_code')->nullable();
            $table->string('billing_country')->nullable();

            $table->string('shipping_street')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_code')->nullable();
            $table->string('shipping_country')->nullable();

            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
