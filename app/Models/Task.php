<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'status',
        'owner_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'proof'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}