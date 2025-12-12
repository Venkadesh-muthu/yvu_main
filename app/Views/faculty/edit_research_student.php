<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Students</h4>
                        <p class="card-description">Update student details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-research-student') ?>" method="post">
                            <?= csrf_field() ?>

                            <div id="research-container">
                                <?php
                                $research = isset($research) ? (array)$research : [[]];
                        foreach ($research as $row):
                            ?>
                                <div class="research-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= $row['id'] ?? '' ?>">

                                    <!-- Student Name -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Student Name</label>
                                        <input type="text" class="form-control" name="student_name[]"
                                               placeholder="Enter Student Name"
                                               value="<?= esc($row['student_name'] ?? '') ?>" required>
                                    </div>

                                    <!-- Topic / Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Topic / Title</label>
                                        <input type="text" class="form-control" name="topic_title[]"
                                               placeholder="Enter Topic / Title"
                                               value="<?= esc($row['topic_title'] ?? '') ?>" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type</label>
                                        <select class="form-select" name="type[]">
                                            <option value="">Select Type</option>
                                            <option value="PhD" <?= ($row['type'] ?? '') == 'PhD' ? 'selected' : '' ?>>PhD</option>
                                            <option value="MPhil" <?= ($row['type'] ?? '') == 'MPhil' ? 'selected' : '' ?>>MPhil</option>
                                            <option value="Project" <?= ($row['type'] ?? '') == 'Project' ? 'selected' : '' ?>>Project</option>
                                        </select>
                                    </div>

                                    <!-- From Year -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">From</label>
                                        <input type="number" class="form-control" name="from_year[]"
                                               placeholder="Start Year"
                                               value="<?= esc($row['from_year'] ?? '') ?>">
                                    </div>

                                    <!-- To Year -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">To</label>
                                        <input type="number" class="form-control" name="to_year[]"
                                               placeholder="End Year"
                                               value="<?= esc($row['to_year'] ?? '') ?>">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status[]">
                                            <option value="">Select Status</option>
                                            <option value="completed" <?= ($row['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Completed</option>
                                            <option value="ongoing" <?= ($row['status'] ?? '') == 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                        </select>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-research">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add Another Student -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-research" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Student
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/students') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('research-container');
    const addBtn = document.getElementById('add-research');

    // ADD NEW RESEARCH ROW
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.research-row');
        const newRow = firstRow.cloneNode(true);

        // Reset hidden ID for new row
        const hiddenId = newRow.querySelector('input[type="hidden"]');
        if (hiddenId) hiddenId.value = '';

        // Reset text/number inputs
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type !== 'hidden') input.value = '';
            input.required = (input.name === 'student_name[]'); // student_name required
        });

        // Reset selects
        newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

        container.appendChild(newRow);
    });

    // REMOVE RESEARCH ROW
    container.addEventListener('click', function (e) {
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
