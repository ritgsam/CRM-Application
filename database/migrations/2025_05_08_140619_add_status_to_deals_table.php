<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('deals', function (Blueprint $table) {
        $table->string('status')->default('Open');
    });
}

public function down()
{
    Schema::table('deals', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
