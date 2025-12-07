@extends('layouts.hrm')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <h4>Departments</h4>
            <button class="btn btn-primary btn-sm" id="btnAddDepartment">Add Department</button>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($departments as $d)
                        <tr>
                            <td>{{ $d->name }}</td>
                            <td>
                                <button class="btn btn-info btn-sm viewDepartment" data-id="{{ $d->id }}">View</button>
                                <button class="btn btn-warning btn-sm editDepartment"
                                    data-id="{{ $d->id }}">Edit</button>

                                <form class="d-inline" method="POST" action="{{ route('departments.destroy', $d->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete department?')">Del</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $departments->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('departments.modal')
@endsection

@section('scripts')
    <script>
        /* --------------------------
                    ADD MODAL
                -------------------------- */
        $("#btnAddDepartment").click(function() {
            $("#departmentForm")[0].reset();
            $("#departmentId").val("");
            $("#departmentModalTitle").text("Add Department");
            $("#departmentModal").modal("show");
        });

        /* --------------------------
            EDIT MODAL AJAX
        -------------------------- */
        $(".editDepartment").click(function() {
            const id = $(this).data("id");

            $.get("/departments/" + id + "/edit", function(res) {
                $("#departmentModalTitle").text("Edit Department");
                $("#departmentId").val(res.department.id);
                $("#name").val(res.department.name);

                $("#departmentModal").modal("show");
            });
        });

        /* --------------------------
            SHOW MODAL AJAX
        -------------------------- */
        $(".viewDepartment").click(function() {
            const id = $(this).data("id");

            $.get("/departments/" + id, function(res) {
                $("#showDeptName").text(res.department.name);
                $("#departmentShowModal").modal("show");
            });
        });
    </script>
@endsection
