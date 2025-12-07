@extends('layouts.hrm')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Employees</h4>
            <button class="btn btn-primary btn-sm" id="btnAddEmployee">Add Employee</button>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <select id="filterDepartment" class="form-control">
                        <option value="">-- Filter by Department --</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table class="table table-bordered table-striped" id="employeesTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Dept</th>
                        <th>Skills</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $e)
                        <tr>
                            <td>{{ $e->first_name }} {{ $e->last_name }}</td>
                            <td>{{ $e->email }}</td>
                            <td>{{ $e->department->name }}</td>
                            <td>
                                @foreach ($e->employeeSkills as $skill)
                                    <span class="badge badge-info">{{ $skill->skill->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm viewEmployee" data-id="{{ $e->id }}">View</button>
                                <button class="btn btn-warning btn-sm editEmployee"
                                    data-id="{{ $e->id }}">Edit</button>

                                <form method="POST" action="{{ route('employees.destroy', $e->id) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete employee?')">Del</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('employees.modal')
@endsection

@section('scripts')
    <script>
        /* ---------------------------------------
                                                               OPEN CREATE MODAL
                                                            ----------------------------------------*/
        $("#btnAddEmployee").click(function() {
            $("#employeeForm")[0].reset();
            $("#employeeId").val("");
            $("#employeeModalTitle").text("Add Employee");
            $("#employeeForm").attr("action", "{{ route('employees.store') }}");
            $("#employeeModal").modal("show");
        });

        /* ---------------------------------------
           OPEN EDIT MODAL (AJAX)
        ----------------------------------------*/
        $(".editEmployee").click(function() {
            let id = $(this).data("id");

            $.get("/employees/" + id + "/edit", function(res) {

                $("#employeeModalTitle").text("Edit Employee");
                $("#employeeForm").attr("action", "/employees/" + id);

                $("#employeeId").val(res.employee.id);
                $("#first_name").val(res.employee.first_name);
                $("#last_name").val(res.employee.last_name);
                $("#email").val(res.employee.email);
                $("#department_id").val(res.employee.department_id);

                $("select[name='skills[]']").val(res.skill_ids);

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'PUT'
                }).appendTo('#employeeForm');

                $("#employeeModal").modal("show");
            });
        });

        /* ---------------------------------------
           OPEN SHOW MODAL (AJAX)
        ----------------------------------------*/
        $(".viewEmployee").click(function() {
            let id = $(this).data("id");

            $.get("/employees/" + id, function(res) {

                $("#showName").text(res.employee.first_name + " " + res.employee.last_name);
                $("#showEmail").text(res.employee.email);
                $("#showDepartment").text(res.employee.department.name);

                let skills = "";
                res.employee.employee_skills.forEach(es => {
                    skills += `<span class="badge badge-info mr-1">${es.skill.name}</span>`;
                });
                $("#showSkills").html(skills);


                $("#viewModal").modal("show");
            });
        });

        /* ---------------------------------------
           FILTER BY DEPARTMENT
        ----------------------------------------*/
        $("#filterDepartment").change(function() {
            let deptId = $(this).val();


            $.get("{{ route('employees.index') }}", {
                department_id: deptId
            }, function(res) {
                let tbody = $("#employeesTable tbody");
                tbody.empty();

                res.data.forEach(emp => {
                    let deptName = emp.department ? emp.department.name : 'N/A';

                    let skillsHTML = '';
                    if (emp.employee_skills) {
                        emp.employee_skills.forEach(es => {
                            let skillName = es.skill ? es.skill.name : 'N/A';
                            skillsHTML +=
                                `<span class='badge badge-info'>${skillName}</span> `;
                        });
                    }

                    tbody.append(`
                        <tr>
                            <td>${emp.first_name} ${emp.last_name}</td>
                            <td>${emp.email}</td>
                            <td>${deptName}</td>
                            <td>${skillsHTML}</td>
                            <td>
                                <button class="btn btn-info btn-sm viewEmployee" data-id="${emp.id}">View</button>
                                <button class="btn btn-warning btn-sm editEmployee" data-id="${emp.id}">Edit</button>
                            </td>
                        </tr>
                    `);
                });
            });
        });


        $(document).ready(function() {
            // Skills multi-select
            $('#skills').select2({
                placeholder: "Select skills",
                allowClear: true,
                width: '100%'
            });

            // Department single-select
            $('#department_id').select2({
                placeholder: "Select Department",
                allowClear: true,
                width: '100%'
            });

            // Function to set skills (for edit)
            function setSkills(selectedIds = []) {
                $('#skills').val(selectedIds).trigger('change');
            }

            // Function to set department (for edit)
            function setDepartment(deptId) {
                $('#department_id').val(deptId).trigger('change');
            }

            // Example: inside your edit AJAX
            $(".editEmployee").click(function() {
                let id = $(this).data("id");
                $.get("/employees/" + id + "/edit", function(res) {
                    $("#employeeModalTitle").text("Edit Employee");
                    $("#employeeForm").attr("action", "/employees/" + id);
                    $("#employeeId").val(res.employee.id);
                    $("#first_name").val(res.employee.first_name);
                    $("#last_name").val(res.employee.last_name);
                    $("#email").val(res.employee.email);

                    setDepartment(res.employee.department_id); // set selected department
                    setSkills(res.skill_ids); // set selected skills

                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'PUT'
                    }).appendTo('#employeeForm');

                    $("#employeeModal").modal("show");
                });
            });
        });



        // Initialize Select2 for filter
        $('#filterDepartment').select2({
            placeholder: "Filter by Department",
            allowClear: true,
            width: '100%'
        });

        // Reset filter
        $('#resetFilter').click(function() {
            $('#filterDepartment').val(null).trigger('change'); // clear select2
            fetchEmployees(); // reload table with all employees
        });

        // Function to fetch employees based on filter
        function fetchEmployees(deptId = '') {
            $.get("{{ route('employees.index') }}", {
                department_id: deptId
            }, function(res) {
                let tbody = $("#employeesTable tbody");
                tbody.empty();

                res.data.forEach(emp => {
                    let deptName = emp.department ? emp.department.name : 'N/A';

                    let skillsHTML = '';
                    if (emp.employee_skills) {
                        emp.employee_skills.forEach(es => {
                            let skillName = es.skill ? es.skill.name : 'N/A';
                            skillsHTML += `<span class='badge badge-info'>${skillName}</span> `;
                        });
                    }

                    tbody.append(`
                        <tr>
                            <td>${emp.first_name} ${emp.last_name}</td>
                            <td>${emp.email}</td>
                            <td>${deptName}</td>
                            <td>${skillsHTML}</td>
                            <td>
                                <button class="btn btn-info btn-sm viewEmployee" data-id="${emp.id}">View</button>
                                <button class="btn btn-warning btn-sm editEmployee" data-id="${emp.id}">Edit</button>
                                <form method="POST" action="/employees/${emp.id}" class="d-inline" onsubmit="return confirm('Delete employee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });
            });
        }

        // Trigger filter on change
        $('#filterDepartment').change(function() {
            let deptId = $(this).val();
            fetchEmployees(deptId);
        });
    </script>
@endsection
