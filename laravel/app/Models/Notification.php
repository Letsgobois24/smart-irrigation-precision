<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    protected function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['severity'], function ($query, $severity) {
            $query->where('severity', $severity);
        });

        $query->when($filters['is_active'] != '', function ($query) use ($filters) {
            $query->where('is_active', $filters['is_active']);
        });

        $query->when($filters['date']['from'], function ($query, $from) {
            $query->whereDate('created_at', '>=', $from);
        });

        $query->when($filters['date']['to'], function ($query, $to) {
            $query->whereDate('created_at', '<=', $to);
        });

        $query->when($filters['location'], function ($query, $location) use ($filters) {
            if ($filters['location'] == 'global') {
                $query->where('source_type', 'global');
            } else {
                $query->where('tree_id', $location);
            }
        });
    }

    protected function scopeIsActive(Builder $query)
    {
        $query->where('is_active', 1);
    }

    protected function scopeIsTree(Builder $query): void
    {
        $query->where('source_type', 'tree');
    }

    protected function scopeActiveOrder(Builder $query, string $is_active)
    {
        $query->when($is_active == '', function ($query) {
            $query->orderBy('is_active', 'desc');
        });
    }

    public function tree(): BelongsTo
    {
        return $this->belongsTo(Tree::class, 'notifications_tree_id_foreign');
    }
}
