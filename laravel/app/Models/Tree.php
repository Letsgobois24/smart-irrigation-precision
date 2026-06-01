<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tree extends Model
{
    public $timestamps = false;

    protected function scopeIsActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'tree_id', 'tree_id');
    }

    public static function getTreeId()
    {
        return self::select('tree_id')->isActive()->orderBy('tree_id')->pluck('tree_id');
    }
}
