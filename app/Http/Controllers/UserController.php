<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Department;
use App\Models\DepartmentUser;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function list_users(Request $request)
    {
        if ($request->ajax()) {
            
            $records =User::orderBy('updated_at','desc');

            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length");
            if ($request->get('search') !== null) {
                $searchValue = $request->get('search')['value'];
                if (strlen($searchValue) > 2) $records = User::select('user_name','user_email','user_document','user_birthday')->where('user_name', $searchValue)->get();
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

    public function list_departments_user(Request $request,$id)
    {
        if ($request->ajax()) {
            
            $id_user=Crypt::decryptString($id);
            $departments_id = User::select('departments_user.department_id')->join('departments_user', 'departments_user.user_id', '=', 'users.user_id')->where('users.user_id',$id_user)->get();
            $ids=array();
            foreach($departments_id as $department_id)
            {
                array_push($ids,$department_id['department_id']);
            }

            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length");

            $records=Department::whereIn('department_id',$ids);

            $totalRecords = $records->count();
            $totalRecordswithFilter = $records->count();

            $departments_user = $records->skip($start)->take($rowperpage)->get();

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $departments_user,
            );

            return response()->json($response);
        }
    }

    public function store_user(UserRequest $request)
    {
        User::create($_POST);
        return redirect(route('index'));
    }

    public function update_user(UserRequest $request,$id)
    {   
        User::find(Crypt::decryptString($id))->update($_POST);
       return redirect(route('index'));
    }

    public function delete_user($id)
    {
        User::find(Crypt::decryptString($id))->delete();
       return redirect(route('index'));
    }

    public function manage_departments($id)
    {
        $user=User::find(Crypt::decryptString($id));
        $data['user']=$user;
        return view('departments_user',$data);
    }

    public function add_department($id_department,$id_user)
    {
        $department_user=DepartmentUser::where('department_id',$id_department)->where('user_id',Crypt::decryptString($id_user))->first();
        if(!isset($department_user)) DepartmentUser::create(['department_id'=>$id_department,'user_id'=>Crypt::decryptString($id_user)]);
        return redirect(route('manage_departments',$id_user));
    }

    public function drop_department($id_department,$id_user)
    {
       DepartmentUser::where('department_id',$id_department)->where('user_id',Crypt::decryptString($id_user))->delete();
        return redirect(route('manage_departments',$id_user));
    }
}
