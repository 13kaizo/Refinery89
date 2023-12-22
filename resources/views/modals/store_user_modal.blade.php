<div class="modal fade" id="store_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('store_user')}}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Store User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="user_name">Name:</label>
              <input class="form-control" type="text" name="user_name" required>
            </div>
            <div class="form-group">
              <label for="user_email">Email:</label>
              <input class="form-control" type="text" name="user_email" required>
            </div>
            <div class="form-group">
              <label for="user_document">Document:</label>
              <input class="form-control" type="text" name="user_document">
            </div>
            <div class="form-group">
              <label for="user_birthday">Birthday:</label>
              <input class="form-control" type="date" name="user_birthday">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>