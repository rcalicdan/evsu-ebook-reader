<?php

use App\Enums\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('course', Course::values())->nullable()->after('role');
            $table->boolean('is_approved')->default(false)->after('course');
            $table->boolean('is_suspended')->default(false)->after('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['course', 'is_approved', 'is_suspended']);
        });
    }
};