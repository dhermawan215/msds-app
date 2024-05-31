<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysModulMenu extends Model
{
    use HasFactory;

    protected $table = 'sys_modul_menus';

    protected $fillable = ['name', 'route_name', 'link_path', 'description', 'icon', 'order_menu', 'created_by'];
}
