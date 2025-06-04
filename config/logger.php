<?php

declare(strict_types=1);

return [
    'logs_table' => env('LOGGER_LOGS_DB_TABLE', 'logs'),
    'error_logs_table' => env('LOGGER_ERROR_LOGS_DB_TABLE', 'error_logs'),
];
