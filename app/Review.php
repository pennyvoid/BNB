<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['rating', 'content', 'id'];
    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
