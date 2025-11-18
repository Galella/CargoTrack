<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_number',
        'train_name',
        'origin_station',
        'destination_station',
        'departure_time',
        'estimated_arrival',
        'actual_arrival',
        'wagon_count',
        'status'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'estimated_arrival' => 'datetime',
        'actual_arrival' => 'datetime',
    ];

    public function containers()
    {
        return $this->hasMany(Container::class, 'train_shipment_id');
    }
}
