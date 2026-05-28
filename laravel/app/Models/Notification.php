<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    public static function getDate(string $order_by = 'asc')
    {
        return self::select('created_at')->limit(1)->orderBy('created_at', $order_by)->first();
    }

    #[Scope]
    protected function filter(Builder $query, array $filters): void
    {
        $query->when($filters['severity'] ?? false, function ($query, $severity) {
            $query->where('severity', $severity);
        });

        $query->when($filters['is_active'] ?? false, function ($query, $is_active) {
            $query->where('is_active', $is_active);
        });

        $query->when($filters['date'] ?? false, function ($query, $date) {
            $query->where('created_at', '>=', $date['from']);
            $query->where('created_at', '>=', $date['to']);
        });

        $query->when($filters['location'] ?? false, function ($query, $location) {
            $query->where('tree_id', $location);
        });
    }
}
