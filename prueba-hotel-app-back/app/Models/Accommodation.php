<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $table = 'accommodations';

    protected $fillable = [
        'type', 
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'accommodation_id');
    }

    public function roomTypes()
    {
        return $this->belongsToMany(
            RoomType::class,
            'room_type_accommodations', 
            'accommodation_id',
            'room_type_id'
        );
    }
}
