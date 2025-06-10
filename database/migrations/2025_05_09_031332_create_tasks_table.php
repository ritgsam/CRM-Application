<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject');
            $table->date('due_date');

            $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();

            // $table->enum('status', ['In Process', 'Completed', 'Not Started'])->default('Not Started');
            $table->string('status')->nullable();
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
            $table->unsignedBigInteger('deal_id')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
