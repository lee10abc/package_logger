<?php

declare(strict_types=1);

namespace Jean\Logger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ErrorLogger extends Model
{
    use HasUuids;

    protected $table;
    protected $fillable = ['category', 'message', 'context', 'trace'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('logger.error_logs_table');
    }

    protected function casts(): array
    {
        return [
            'context' => AsArrayObject::class,
            'trace' => AsArrayObject::class,
        ];
    }
}
