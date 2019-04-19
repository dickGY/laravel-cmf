<?php

namespace App\AdminModel;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'role';

    public $timestamps = false;

    protected $guarded = ['_token'];

    protected $fillable=['name','remark','state'];
}
