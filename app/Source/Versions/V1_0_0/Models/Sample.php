<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sample extends Model {

	use HasFactory;
	use SoftDeletes;
	

	protected $fillable = ['first_name', 'last_name'];

}
