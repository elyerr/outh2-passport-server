<?php

namespace App\Models\Assets;
 
use App\Assets\Timestamps;
use App\Models\Booking\Rent;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\Asset\RoomTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes, Timestamps;

    public $table = "rooms";

    public $view = "room";

    public $transformer = RoomTransformer::class;

    protected $fillable = [
        'number',
        'description',
        'category_id'
    ];

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = strtoupper($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtolower($value);
    }    

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

}
