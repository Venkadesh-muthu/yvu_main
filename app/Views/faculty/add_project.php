<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Projects</h4>
                        <p class="card-description">Fill all required project details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-project') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="projects-container">
                                <div class="projects-row row g-3 mb-3">

                                    <!-- Project Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Project Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Project Title" required>
                                    </div>

                                    <!-- Agency -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Agency</label>
                                        <input type="text" class="form-control" name="agency[]" placeholder="Enter Agency" required>
                                    </div>

                                    <!-- From Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">From Year</label>
                                        <input type="number" class="form-control" name="from_year[]" placeholder="YYYY">
                                    </div>

                                    <!-- To Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">To Year</label>
                                        <input type="number" class="form-control" name="to_year[]" placeholder="YYYY">
                                    </div>

                                    <!-- Upload Project File -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-project">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another project -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-project" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Project
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/projects') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('projects-container');
    const addBtn = document.getElementById('add-project');

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.projects-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.required = false;
        });

        // Project Title & Agency must always be required
        newRow.querySelector('input[name="title[]"]').required = true;
        newRow.querySelector('input[name="agency[]"]').required = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
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
