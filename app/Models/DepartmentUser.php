<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;

    protected $table="departments_user";
    protected $primaryKey="department_user_id";

    public $timestamps=false;

    protected $fillable=[
        'department_id',
        'user_id',
    ];
}
