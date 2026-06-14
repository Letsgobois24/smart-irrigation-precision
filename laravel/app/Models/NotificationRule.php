<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRule extends Model
{
    protected $primaryKey = 'feature_name';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $casts = [
        'problem' => 'array',
        'recommendation' => 'array',
    ];

    protected $fillable = [
        'feature_name',
        'title',
        'description',
        'problem',
        'recommendation'
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'dominant_feature', 'feature_name');
    }
}
