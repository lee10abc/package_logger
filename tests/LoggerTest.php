<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Jean\Logger\Logger as L;

uses(DatabaseTransactions::class);
pest()->extend(Tests\TestCase::class);

test('[PACKAGE][LOGGER] - saves to database', function (): void {
    DB::table(config('logger.logs_table'))->delete();

    L::info(message: "message", category: "test", ip: false, log: false);
    $this->assertEquals(1, DB::table(config('logger.logs_table'))->where('level', 'info')->count());

    L::warning(message: "message", category: "test", ip: false, log: false);
    $this->assertEquals(1, DB::table(config('logger.logs_table'))->where('level', 'warning')->count());

    L::error(message: "message", category: "test", ip: false, log: false);
    $this->assertEquals(1, DB::table(config('logger.logs_table'))->where('level', 'error')->count());
});
