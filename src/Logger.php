<?php

declare(strict_types=1);

namespace Jean\Logger;

use Exception;
use Illuminate\Support\Facades\Log as LaravelLog;
use Illuminate\Support\Facades\Request;
use Jean\Logger\Models\Logger as LoggerModel;
use Jean\Logger\Models\ErrorLogger as ErrorLoggerModel;

class Logger
{
    public static function log(string $level, string $message, ?int $userId = null, ?string $category = null, array $context = [], bool $ip = false, bool $log = false): void
    {
        $data = array_merge(
            [
                'category' => $category,
                'level' => $level,
                'user_id' => $userId,
                'message' => $message,
                'context' => $context,
            ],
            $ip ? ['ip' => Request::ip()] : [],
        );

        LoggerModel::create($data);

        if ($log) {
            LaravelLog::log($level, json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
            ));
        }
    }

    public static function info(string $message, ?int $userId = null, ?string $category = null, array $context = [], bool $ip = false, bool $log = false): void
    {
        self::log('info', $message, $userId, $category, $context, $ip, $log);
    }

    public static function warning(string $message, ?int $userId = null, ?string $category = null, array $context = [], bool $ip = false, bool $log = false): void
    {
        self::log('warning', $message, $userId, $category, $context, $ip, $log);
    }

    public static function error(string $message, ?int $userId = null, ?string $category = null, array $context = [], bool $ip = false, bool $log = false): void
    {
        self::log('error', $message, $userId, $category, $context, $ip, $log);
    }

    public static function exception(Exception $e, string $category = null, array $context = []): string
    {
        $log = ErrorLoggerModel::create([
            'category' => $category,
            'message' => $e->getMessage(),
            'context' => array_merge([
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], $context),
            'trace' => collect($e->getTrace())->take(5)->toArray(), // limit trace size
        ]);

        return $log->id;
    }
}
