<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserModulRole extends Model
{
    use HasFactory;

    protected $table = 'sys_user_modul_roles';

    protected $fillable = ['sys_modul_id', 'sys_user_group_id', 'is_akses', 'fungsi'];
}
