<!-- ADD/EDIT DEPARTMENT MODAL -->
<div class="modal fade" id="departmentModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="departmentForm" method="POST" action="{{ route('departments.store') }}">
                @csrf
                <input type="hidden" name="department_id" id="departmentId">

                <div class="modal-header">
                    <h5 id="departmentModalTitle"></h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <label>Name *</label>
                    <input type="text" name="name" id="name" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- SHOW MODAL -->
<div class="modal fade" id="departmentShowModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Department Details</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p><strong>Name:</strong> <span id="showDeptName"></span></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
