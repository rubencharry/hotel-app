<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_types';

    protected $fillable = [
        'type', 
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }

    public function accommodations()
    {
        return $this->belongsToMany(
            Accommodation::class,
            'room_type_accommodations',
            'room_type_id',
            'accommodation_id'
        );
    }
}
