<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class RouteDetail extends Model
{
    protected $table      = 'F_STORE.ALL_ROUTE_DETAILS';
    protected $primaryKey = 'ROUTE_ID';
    public    $keyType    = 'string';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'ROUTE_ID','ROUTE_PATH','MENU_CHILD_ID','COMPONENT',
        'IS_ACTIVE','DESCRIPTION','INSERT_BY','INSERT_DATE',
    ];

    public function menu()
    {
        return $this->belongsTo(MenuHierarchy::class, 'MENU_CHILD_ID', 'CHILD_ID');
    }
}