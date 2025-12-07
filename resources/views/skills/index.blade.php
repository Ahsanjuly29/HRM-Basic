@extends('layouts.hrm')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <h4>Skills</h4>
            <button class="btn btn-primary btn-sm" id="btnAddSkill">Add Skill</button>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($skills as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>

                                <button class="btn btn-info btn-sm viewSkill" data-id="{{ $s->id }}">
                                    View
                                </button>

                                <button class="btn btn-warning btn-sm editSkill" data-id="{{ $s->id }}">
                                    Edit
                                </button>

                                <form class="d-inline" method="POST" action="{{ route('skills.destroy', $s->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete skill?')">
                                        Del
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

    @include('skills.modal')
@endsection


@section('scripts')
    <script>
        /* -----------------------------
       CREATE MODAL
    ------------------------------ */
        $("#btnAddSkill").click(function() {
            $("#skillForm")[0].reset();
            $("#skillId").val("");

            $("#skillForm").attr("action", "{{ route('skills.store') }}");

            $("#skillModalTitle").text("Add Skill");
            $("#skillModal").modal("show");
        });


        /* -----------------------------
           EDIT MODAL (AJAX)
        ------------------------------ */
        $(".editSkill").click(function() {
            let id = $(this).data('id');

            $.get("/skills/" + id + "/edit", function(res) {

                $("#skillForm").attr("action", "/skills/" + id);
                $("#skillModalTitle").text("Edit Skill");

                $("#skillId").val(res.skill.id);
                $("#name").val(res.skill.name);

                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'PUT'
                }).appendTo('#skillForm');

                $("#skillModal").modal("show");
            });
        });


        /* -----------------------------
           VIEW MODAL (AJAX)
        ------------------------------ */
        $(".viewSkill").click(function() {
            let id = $(this).data("id");

            $.get("/skills/" + id, function(res) {
                $("#showSkillName").text(res.skill.name);

                $("#showSkillModal").modal("show");
            });
        });
    </script>
@endsection
