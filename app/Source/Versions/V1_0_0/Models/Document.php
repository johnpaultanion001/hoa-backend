<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "title", "description",
        "company_id"
    ];


    public function fileDocument()
    {

        return $this->morphOne(File::class, 'table')->whereType('document');
    }
}
