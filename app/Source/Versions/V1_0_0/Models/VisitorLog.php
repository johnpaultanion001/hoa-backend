<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "table_type",
        "table_id",
        "name",
        "contact_number",
        "person_to_visit",
        "date",
        "time",
        "status_id",
        "place_to_visit",
        "email",
        "company_id"
    ];


    public function table()
    {
        return $this->morphTo();
    }
    public function fileIdentification()
    {

        return $this->morphOne(File::class, 'table')->whereType('identification');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
