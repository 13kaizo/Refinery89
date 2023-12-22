<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $primaryKey='department_id';

    public $appends=['parent'];

    protected $fillable=[
        'department_name',
        'department_parent_id',
    ];

    public static function tree()
    {
        $list='';
        $i=0;
        $allDepartments=Department::get();

        $rootDepartments=$allDepartments->where('department_parent_id',null);

        self::format_tree($rootDepartments,$allDepartments);

        return $rootDepartments;
    }

    private static function format_tree($departments,$allDepartments)
    {
        foreach($departments as $department)
        {
            $department->children=$allDepartments->where('department_parent_id',$department->department_id)->values();

            if($department->children->isNotEmpty())
            self::format_tree($department->children,$allDepartments);

        }
    }

    public function getParentAttribute()
    {
        if($this->department_parent_id) return Department::find($this->department_parent_id)['department_name'];

        return "";
    }
}
