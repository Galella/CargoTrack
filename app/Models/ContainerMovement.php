<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_id',
        'from_status',
        'to_status',
        'movement_type',
        'user_id',
        'notes'
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
