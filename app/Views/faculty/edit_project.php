<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Projects</h4>
                        <p class="card-description">Update project details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-project') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="projects-container">
                                <?php
                                $projects = isset($projects) ? (array)$projects : [[]];
                        foreach ($projects as $project):
                            ?>
                                <div class="projects-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= $project['id'] ?? '' ?>">

                                    <!-- Project Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Project Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Project Title"
                                            value="<?= esc($project['title'] ?? '') ?>" required>
                                    </div>

                                    <!-- Agency -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Agency</label>
                                        <input type="text" class="form-control" name="agency[]" placeholder="Enter Agency"
                                            value="<?= esc($project['agency'] ?? '') ?>" required>
                                    </div>

                                    <!-- From Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">From Year</label>
                                        <input type="number" class="form-control" name="from_year[]"
                                            value="<?= esc($project['from_year'] ?? '') ?>" placeholder="YYYY">
                                    </div>

                                    <!-- To Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">To Year</label>
                                        <input type="number" class="form-control" name="to_year[]"
                                            value="<?= esc($project['to_year'] ?? '') ?>" placeholder="YYYY">
                                    </div>

                                    <!-- Upload File -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">

                                        <?php if (!empty($project['file_path'])): ?>
                                            <small>
                                                Current File:
                                                <a href="<?= base_url($project['file_path']) ?>" target="_blank">View File</a>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-project">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add another project -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-project" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Project
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/projects') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('projects-container');
    const addBtn = document.getElementById('add-project');

    // ✅ ADD NEW PROJECT ROW
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.projects-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            if (input.type === 'hidden') {
                input.value = '';
            } else if (input.type === 'file') {
                input.value = '';
            } else {
                input.value = '';
            }
            input.readOnly  = false;
            input.disabled  = false;
            input.required  = (input.name === 'title[]' || input.name === 'agency[]');
        });

        container.appendChild(newRow);
    });

    // ✅ REMOVE PROJECT ROW
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-project')) {
            const rows = container.querySelectorAll('.projects-row');

            if (rows.length > 1) {
                e.target.closest('.projects-row').remove();
            } else {
                alert('At least one project is required.');
            }
        }
    });

});
</script>
