<?php

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->string('slug', 500);
            $table->text('description')->nullable();
            $table->string('file_url', 1000);
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('visibility', 20)->default(DocumentVisibility::PUBLIC->value);
            $table->string('status', 20)->default(DocumentStatus::ACTIVE->value);
            $table->integer('view_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('category_id');
            $table->index('visibility');
            $table->index('status');
            $table->index('uploaded_by');
            $table->index('created_at');
        });

        DB::statement('CREATE INDEX documents_search_idx ON documents USING GIN(to_tsvector(\'english\', title || \' \' || COALESCE(description, \'\')))');
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
