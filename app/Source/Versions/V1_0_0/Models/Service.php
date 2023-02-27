<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "availability",
        "metadata",
        "type",
        "company_id"
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function fileCover()
    {

        return $this->morphOne(File::class, 'table')->whereType('cover');
    }

    public function bookings()
    {

        return $this->hasMany(Booking::class);
    }

    public function bookingDetails()
    {
        return $this->hasManyThrough(BookingDetail::class, Booking::class);
    }

    public function company()
    {
        return $this->belongsTo(User::class, "company_id", "id");
    }
}
