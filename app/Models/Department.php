<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function users(){
        return $this->hasMany(User::class, "departmentId", "id");
    }

}
