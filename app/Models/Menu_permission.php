<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu_permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menu_permissions';
    protected $softDelete = true;
    protected $hidden = ['deleted_at'];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
