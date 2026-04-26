<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holland_career_suggestions', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 1)->unique();
            $table->string('title');
            $table->text('description');
            $table->text('majors');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holland_career_suggestions');
    }
};

