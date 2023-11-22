<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'permissions';
    protected $softDelete = true;
    protected $hidden = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
