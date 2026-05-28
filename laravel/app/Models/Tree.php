<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tree extends Model
{
    public $timestamps = false;

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
