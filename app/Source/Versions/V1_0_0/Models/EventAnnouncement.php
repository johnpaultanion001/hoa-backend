<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAnnouncement extends Model
{
  use HasFactory;


  protected $fillable = [
    "title", "description", "tags", "date", "time", "body", "visible",
    "company_id"
  ];

  protected $casts = [
    "tags" => "array"
  ];


  public function fileCover()
  {

    return $this->morphOne(File::class, 'table')->whereType('cover');
  }
}
