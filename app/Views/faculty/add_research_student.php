<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Research Students</h4>
                        <p class="card-description">Fill all required research student details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-research-student') ?>" method="post">
                            <?= csrf_field() ?>

                            <div id="research-container">
                                <div class="research-row row g-3 mb-3">

                                    <!-- Student Name -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Student Name</label>
                                        <input type="text" class="form-control" name="student_name[]" placeholder="Enter Student Name" required>
                                    </div>

                                    <!-- Topic / Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Topic / Title</label>
                                        <input type="text" class="form-control" name="topic_title[]" placeholder="Enter Topic / Title" required>
                                    </div>

                                    <!-- Type (PhD / MPhil / Project) -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type</label>
                                        <select class="form-select" name="type[]">
                                            <option value="">Select Type</option>
                                            <option value="PhD">PhD</option>
                                            <option value="MPhil">MPhil</option>
                                            <option value="Project">Project</option>
                                        </select>
                                    </div>

                                    <!-- From -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">From</label>
                                        <input type="number" class="form-control" name="from_year[]" placeholder="Start Year">
                                    </div>

                                    <!-- To -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">To</label>
                                        <input type="number" class="form-control" name="to_year[]" placeholder="End Year">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status[]">
                                            <option value="">Select Status</option>
                                            <option value="completed">Completed</option>
                                            <option value="ongoing">Ongoing</option>
                                        </select>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-research">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another research student -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-research" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Student
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/research-students') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('research-container');
    const addBtn = document.getElementById('add-research');

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.research-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.required = false;
        });

        // Student Name always required
        newRow.querySelector('input[name="student_name[]"]').required = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-research')) {
            const rows = container.querySelectorAll('.research-row');

            if (rows.length > 1) {
                e.target.closest('.research-row').remove();
            } else {
                alert('At least one research student is required.');
            }
        }
    });
});
</script>
