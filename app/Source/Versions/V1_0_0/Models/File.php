<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model {
    use HasFactory;

    protected $fillable = [
        "path",
        "file_name",
        "type",
        "table_id",
        "table_type",
        "full_url",
    ];

    public function table()
    {
        return $this->morphTo();
    }

}
