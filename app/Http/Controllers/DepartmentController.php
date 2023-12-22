<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments=Department::get();
        $data['departments']=$departments;
        return view('departments',$data);
    }

    public function list_departments(Request $request)
    {
        if ($request->ajax()) {
            
            $records =Department::orderBy('department_id','asc');

            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length");
            if ($request->get('search') !== null) {
                $searchValue = $request->get('search')['value'];
                if (strlen($searchValue) > 2) $records = $records->where('department_name', $searchValue);
            }

            $totalRecords = $records->count();
            $totalRecordswithFilter = $records->count();

            $users = $records->skip($start)->take($rowperpage)->get();

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $users,
            );

            return response()->json($response);
        }
    }

    private function department_children($parent_id)
    {
        $departments = Department::where('department_parent_id', $parent_id)->get();
        $d = [];

        foreach ($departments as $department) 
        {
            $a['id'] = $department['department_id'];
            $a['text'] = $department['department_name'];
            $a['state']['selected']=true;

            $a['state']['opened'] = true;
            
            $a['children'] = $this->department_children($department->department_id);

            array_push($d, $a);
        }

        return $d;
    }

    public function store_department(DepartmentRequest $request)
    {
        Department::create($_POST);
        return redirect(route('departments'));
    }

    public function update_department(DepartmentRequest $request,$id)
    {
        Department::find($id)->update($_POST);
        return redirect(route('departments'));

    }

    public function delete_department($id)
    {
        $this->delete($id);

        return redirect(route('departments'));
    }


    private function delete($id)
    {
        $departments= Department::where('department_parent_id',$id)->get();

       foreach($departments as $department)
       {
        $this->delete($department->department_id);
        $department->delete();
       }

       Department::find($id)->delete();
    }
}
