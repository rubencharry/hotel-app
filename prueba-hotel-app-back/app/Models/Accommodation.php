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
}
