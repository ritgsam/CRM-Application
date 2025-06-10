<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('deals', function (Blueprint $table) {
        $table->dropForeign(['lead_id']);
    });

    Schema::table('deals', function (Blueprint $table) {
        $table->unsignedBigInteger('lead_id')->nullable()->change();

        $table->foreign('lead_id')->references('id')->on('leads')->onDelete('set null');
    });
}

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable(false)->change();
        });
    }
};
