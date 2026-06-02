<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

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

    public static function getTreeId(int | null $node_id = null)
    {
        $key = "trees" . ($node_id ? "_$node_id" : '');

        return Cache::remember($key, 3600, function () use ($node_id) {
            /** @var Builder $builder */
            $builder = self::select('tree_id')->isActive();
            $builder->when($node_id, function ($builder) use ($node_id) {
                $builder->where('node_id', $node_id);
            });

            return $builder->orderBy('tree_id')->pluck('tree_id')->toArray();
        });
    }

    public static function getOptions(int | null $node_id = null): array
    {
        $key = "tree_options" . ($node_id ? "_$node_id" : '');

        return Cache::remember($key, 3600, function () {
            $options = ['' => 'All'];

            foreach (static::getTreeId(node_id: 1) as $tree) {
                $options[$tree] = "Tree {$tree}";
            }

            return $options;
        });
    }
}
