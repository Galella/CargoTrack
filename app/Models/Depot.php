<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'address',
        'contact_person',
        'contact_phone',
        'description',
        'type',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function containers()
    {
        return $this->hasMany(Container::class, 'depo_id');
    }
}
