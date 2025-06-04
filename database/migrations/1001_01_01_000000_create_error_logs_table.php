<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create(config('logger.error_logs_table'), function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->string('category')->nullable(true);
            $table->text('message');
            $table->json('context')->nullable(true);
            $table->json('trace')->nullable(true);

            $table->timestamps();

            $table->index(['category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('logger.error_logs_table'));
    }
};
