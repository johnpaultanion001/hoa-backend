<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "link",
    ];



    public function fileCover(){

        return $this->morphOne(File::class, 'table')->whereType('cover');

    }
}
