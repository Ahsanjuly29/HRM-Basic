<!-- CREATE / EDIT MODAL -->
<div class="modal fade" id="employeeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="employeeForm" method="POST" action="{{ route('employees.store') }}">
                @csrf
                <input type="hidden" id="employeeId" name="employee_id">

                <div class="modal-header">
                    <h5 id="employeeModalTitle"></h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name *</label>
                            <input class="form-control" name="first_name" id="first_name">
                        </div>
                        <div class="col-md-6">
                            <label>Last Name *</label>
                            <input class="form-control" name="last_name" id="last_name">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="mt-3">
                        <label>Department *</label>
                        <select class="form-select" id="department_id" name="department_id">
                            @foreach (\App\Models\Department::all() as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Skills</label>
                        <select multiple name="skills[]" class="form-select" id="skills">
                            @foreach (\App\Models\Skill::all() as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

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
<div class="modal fade" id="viewModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Employee Details</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <p><strong>Name:</strong> <span id="showName"></span></p>
                <p><strong>Email:</strong> <span id="showEmail"></span></p>
                <p><strong>Department:</strong> <span id="showDepartment"></span></p>

                <p><strong>Skills:</strong></p>
                <div id="showSkills"></div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
