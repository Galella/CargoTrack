<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_number',
        'size',
        'type',
        'status',
        'previous_status',
        'current_location',
        'train_shipment_id',
        'depo_id',
        'condition',
        'is_borrowed',
        'borrowed_to',
        'borrowed_at',
        'purpose'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'is_borrowed' => 'boolean',
    ];

    public function trainShipment()
    {
        return $this->belongsTo(TrainShipment::class);
    }

    public function depo()
    {
        return $this->belongsTo(Depot::class, 'depo_id');
    }

    public function movements()
    {
        return $this->hasMany(ContainerMovement::class);
    }
}
