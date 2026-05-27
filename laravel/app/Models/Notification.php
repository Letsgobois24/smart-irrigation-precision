<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    public static function getDate(string $order_by = 'asc')
    {
        return self::select('created_at')->limit(1)->orderBy('created_at', $order_by)->first();
    }
}
