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
                    <a class="btn btn-link" href="{{route('departments')}}">Departments</a>
                </div>
                <div class="card">
                    <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>Users</div>
                                <div><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#store_user_modal"><i class="bi bi-plus"></i></button></div>
                            </div>
                    </div>
                    <div class="card-body text-center">
                        <table class='table table-bordered border-default table-striped caption-top text-center w-100 mx-auto yajra-datatable' id="users_table">
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>DNI</th>
                                <th>Birthday</th>
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
@include('/modals/store_user_modal')
<script>


$(function(){
    load_users_table();
})


// Function to load data in datatable
function load_users_table()
{
    $("#users_table tbody").empty();
    var table_remesas = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('list_users') }}",
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user_name', name: 'user_name'},
                {data: 'user_email', name: 'user_email'},
                {data: 'user_document', name: 'user_document'},
                {data: 'user_birthday', name: 'user_birthday'},
                {
                    data: 'options', 
                    render: function(data,type,row){
                        return edit_user_button(row)+delete_user_button(row)+manage_departments_button(row);
                    }
                },
            ]
        });
}


// Button and modal to update user information
function edit_user_button(row)
{
    let editRoute= "{{ route('update_user', ['id' => ':id']) }}";
    editRoute= editRoute.replace(':id',row.encid);

    return ''+
        '<button class="btn btn-info btn-sm" title="Update" data-toggle="modal" data-target="#edit_user'+row.encid+'"><i class="bi bi-pencil-fill"></i></button> '+
        '<div class="modal fade" tabindex="-1" id="edit_user'+row.encid+'">'+
            '<div class="modal-dialog">'+
                '<div class="modal-content">'+
                    '<div class="row h-100 bg-white col-xxl-12">'+
                        '<div class="modal-header ">'+
                            '<h3 class="text-primary">Update User</h3>'+
                            '<button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                        '</div>'+

                        '<form method="POST"  action="'+editRoute+'">'+
                            '@csrf '+
                            '<div class="modal-body">'+
                                '<div class="col-xxl-12 mx-auto text-center">'+
                                    '<div class="col container-sm">'+

                                        '<div class="form-group row ">'+
                                            '<label class="col-md-3 col-form-label" for="nombre">Name</label>'+
                                                '<div class="col-md-9">'+
                                                    '<input type="text" class="form-control" name="user_name" required  value="' +row.user_name +'" >'+
                                                '</div>'+
                                        '</div>'+

                                        '<div class="form-group row mt-3">'+
                                            '<label class="col-md-3 col-form-label" for="nombre">Email</label>'+
                                            '<div class="col-md-9">'+
                                                '<input type="email" class="form-control" name="user_email" required value="'+row.user_email+'" >'+
                                            '</div>'+
                                        '</div>'+

                                        '<div class="form-group row mt-3">'+
                                            '<label class="col-md-3 col-form-label" for="nombre">Document</label>'+
                                            '<div class="col-md-9">'+
                                                '<input type="text" class="form-control" name="user_document" value="'+row.user_document+'" >'+
                                            '</div>'+
                                        '</div>'+

                                        '<div class="form-group row mt-3">'+
                                            '<label class="col-md-3 col-form-label" for="nombre">Birthday</label>'+
                                            '<div class="col-md-9">'+

                                                '<input type="date" class="form-control" name="user_birthday" value="'+row.user_birthday+'" >'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<div class="form-group col-sm-4 text-center mx-auto mt-10">'+
                                    '<input class="btn btn-primary" type="submit" value="Edit">'+
                                '</div>'+
                            '</div>'+
                        '</form>'+
                        
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
}


// Button and modal to delete user
function delete_user_button(row)
{

    let deleteRoute= "{{ route('delete_department', ['id' => ':id']) }}";
    deleteRoute= deleteRoute.replace(':id',row.encid);

    return '<button class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#delete_user'+row.encid+'"><i class="bi bi-trash-fill"></i></button> '+
    '<div class="modal fade" tabindex="-1" id="delete_user'+row.encid+'">'+
            '<div class="modal-dialog">'+
                '<div class="modal-content">'+
                    '<div class="row h-100 bg-white col-xxl-12">'+
                        '<div class="modal-header ">'+
                            '<h3 class="text-danger">Delete User</h3>'+
                            '<button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">'+
                                '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                        '</div>'+
                        '<div class="modal-body">'+
                            '<div class="col-xxl-12 mx-auto text-center">'+
                                '<div class="col container-sm">'+
                                    '<p>Are you sure you want to delete user: ' +row.user_name + '?</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="modal-footer">'+
                            '<div class="form-group col-sm-4 text-center mx-auto mt-10">'+
                                '<a href="'+deleteRoute+'" class="btn btn-danger">Delete</a>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
}


//Button and link to manage departments of a user
function manage_departments_button(row)
{
    let manageDepartmentsRoute= "{{ route('manage_departments', ['id' => ':id']) }}";
    manageDepartmentsRoute= manageDepartmentsRoute.replace(':id',row.encid);
    return "<a href='"+manageDepartmentsRoute+"' class='btn btn-secondary btn-sm'><i class='bi bi-gear-wide'></i></a>";
}




</script>