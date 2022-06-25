<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use HasFactory;

    public function children(){
        return $this->hasMany(Permission::class,'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Permission::class,'parent_id');
    }
}
