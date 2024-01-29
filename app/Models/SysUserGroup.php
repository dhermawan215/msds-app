<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserGroup extends Model
{
    use HasFactory;

    protected $table = 'sys_user_groups';

    protected $fillable = ['name', 'created_by'];

    public function groupUsers()
    {
        return $this->hasMany(User::class, 'sys_group_id', 'id');
    }
}
