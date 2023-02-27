<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "status_id",
        "type",
        "user_id",
        "contact_details",
        "address_details",
        "notes",
        "personal_details",
        "service_id",
        "company_id"
    ];

    protected $casts = [
        'contact_details'   => 'json',
        'address_details' => 'json',
        'personal_details' => 'json',
    ];

    public function status()
    {

        return $this->belongsTo(Status::class);
    }

    public function service()
    {

        return $this->belongsTo(Service::class);
    }
    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function bookingDetails()
    {

        return $this->hasMany(BookingDetail::class);
    }

    protected static function boot()
    {
        parent::boot();
    }



    public function delete()
    {
        parent::delete();
        $this->bookingDetails()->delete();
    }
}
