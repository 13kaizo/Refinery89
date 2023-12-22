<div class="modal fade" id="store_department_modal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('store_department')}}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Store User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="user_name">Name:</label>
              <input class="form-control" type="text" name="department_name" required>
            </div>
            <div class="form-group">
              <label for="user_email">Parent Department:</label>
             <select class="form-select" name="department_parent_id" id="">
                <option value="0">None</option>
                @foreach($departments as $department)
                    <option value="{{$department->department_id}}">{{$department->department_name}}</option>
                @endforeach
             </select>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>