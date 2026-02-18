<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('school')->nullable()->after('email');
            $table->enum('gender',['male','female'])->default('male')->after('school');
            $table->enum('age',['nine','eleven'])->default('nine')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('school');
            $table->dropColumn('gender');
             $table->dropColumn('age');
        });
    }
};
