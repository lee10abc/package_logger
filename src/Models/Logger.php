<?php

declare(strict_types=1);

namespace Jean\Logger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Logger extends Model
{
    protected $table;
    protected $fillable = ['category', 'level', 'user_id', 'message', 'context', 'ip'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('logger.logs_table');
    }

    protected function casts(): array
    {
        return [
            'context' => AsArrayObject::class,
        ];
    }
}
