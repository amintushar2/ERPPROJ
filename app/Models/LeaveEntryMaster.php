<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEntryMaster extends Model
{
    use HasFactory;

    protected $table='LEAVE_ENTRY_MASTER';
    public $timestamps = false;
    public $incrementing = false;


    protected $fileable=[
        'lv_cat_id',
        'year',
        'empno',
       'company_id',
       'new_empno',

    ];
}
