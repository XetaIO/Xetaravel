<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class DatabaseNotification extends BaseDatabaseNotification
{
    use HasFactory;
}
