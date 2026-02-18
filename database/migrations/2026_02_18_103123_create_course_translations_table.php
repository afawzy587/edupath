<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_translations', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unique(['course_id','locale']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_translations');
    }
};
