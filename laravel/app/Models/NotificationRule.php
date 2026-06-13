<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRule extends Model
{
    protected $primaryKey = 'feature_name';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'feature_name',
        'title',
        'description',
        'problem',
        'recommendation'
    ];
}
