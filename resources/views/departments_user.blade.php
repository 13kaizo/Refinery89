<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->

        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <style type="text/css">

            i{
                font-size: 15px;
            }

        </style>
    </head>
    <body>
        <div id="app">
            <main class="container">
                <div class="d-flex justify-content-between">
                    <h1> Refinery 89</h1>
                    <a class="btn btn-link" href="{{route('index')}}">Users</a>
                    <a class="btn btn-link" href="{{route('departments')}}">Departments</a>
                </div>
                <div class="card">
                    <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>Departments of user</div>
            
                            </div>
                    </div>
                    <div class="card-body text-center">
                        <input type="text" class="d-none" id="id_user" value="{{$user->encid}}">
                    <h1>{{$user->user_name}}</h1>
                        <table class='table table-bordered border-default table-striped caption-top text-center w-100 mx-auto yajra-datatable' id="departments_user_table">
                            <thead class="">
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Options</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>Departments</div>
            
                            </div>
                    </div>
                    <div class="card-body text-center">
                        <input type="text" class="d-none" id="id_user" value="{{$user->encid}}">
                    <h1>{{$user->user_name}}</h1>
                        <table class='table table-bordered border-default table-striped caption-top text-center w-100 mx-auto yajra-datatable' id="departments_table">
                            <thead class="">
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Options</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                    </div>
                </div>
            </main>
        </div>
    </body>

</html>

<script>


$(function(){
    load_departments_table();
    load_departments_user_table();
})

// Function to load all departments in datatable
function load_departments_table()
{
    $("#departments tbody").empty();
    var table_remesas = $('#departments_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('list_departments') }}",
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'department_name', name: 'department_name'},
            {data: 'parent', name: 'parent'},
            {
                data: 'options', 
                render: function(data,type,row){
                    return add_department_button(row);
                }
            },
        ]
    });
}


// Function to load only those departments asociated to the user
function load_departments_user_table()
{
    let listDepartmentUserRoute= "{{ route('list_departments_user', ['id'=>':id']) }}";
    listDepartmentUserRoute= listDepartmentUserRoute.replace(':id',$("#id_user").val());
    var table_remesas = $('#departments_user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: listDepartmentUserRoute,
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'department_name', name: 'department_name'},
            {data: 'parent', name: 'parent'},
            {
                data: 'options', 
                render: function(data,type,row){
                    return drop_department_button(row);
                }
            },
        ]
    });
}

// Button to add a department to user
function add_department_button(row)
{
    return "<button onclick='add_department(`"+row.department_id+"`)' class='btn btn-primary btn-sm' title='Add'><i class='bi bi-arrow-up-circle'></i></button>"
}

// Function to add department to user
function add_department(id)
{
    let addDepartmentRoute= "{{ route('add_department', ['id_department' => ':id_department','id_user'=>':id_user']) }}";
    addDepartmentRoute= addDepartmentRoute.replace(':id_department',id);
    addDepartmentRoute= addDepartmentRoute.replace(':id_user',$("#id_user").val());

    window.location.href=addDepartmentRoute;

}

// Button to delete a department from the user
function drop_department_button(row)
{
    return "<button onclick='drop_department(`"+row.department_id+"`)' class='btn btn-danger btn-sm' title='Delete'><i class='bi bi-arrow-down-circle'></i></button>"
}

// Button to delete a department from the user
function drop_department(id)
{
    let dropDepartmentRoute= "{{ route('drop_department', ['id_department' => ':id_department','id_user'=>':id_user']) }}";
    dropDepartmentRoute= dropDepartmentRoute.replace(':id_department',id);
    dropDepartmentRoute= dropDepartmentRoute.replace(':id_user',$("#id_user").val());

    window.location.href=dropDepartmentRoute;

}



</script>