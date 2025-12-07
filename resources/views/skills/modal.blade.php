<!-- ADD / EDIT MODAL -->
<div class="modal fade" id="skillModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="skillForm" method="POST" action="{{ route('skills.store') }}">
                @csrf
                <input type="hidden" id="skillId" name="skill_id">

                <div class="modal-header">
                    <h5 id="skillModalTitle"></h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Name *</label>
                    <input type="text" id="name" name="name" class="form-control">
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
<div class="modal fade" id="showSkillModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Skill Details</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <p><strong>Name:</strong> <span id="showSkillName"></span></p>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
