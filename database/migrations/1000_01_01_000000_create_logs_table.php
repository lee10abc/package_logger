<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create(config('logger.logs_table'), function (Blueprint $table): void {
            $table->id();
            $table->string('level')->default('info');
            $table->string('category')->nullable(true);
            $table->integer('user_id')->nullable(true);
            $table->text('message');
            $table->json('context')->nullable(true);
            $table->ipAddress('ip')->nullable(true);
            $table->timestamps();

            $table->index(['category', 'level']);
            $table->index('user_id');
            $table->index('ip');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('logger.logs_table'));
    }
};
