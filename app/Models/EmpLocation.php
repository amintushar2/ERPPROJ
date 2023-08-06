<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpLocation extends Model
{
    use HasFactory;
    
    protected $table='EMP_LOCATION';
    public $timestamps = false;
    public $incrementing = false;
}
