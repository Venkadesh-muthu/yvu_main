<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Activities (Workshop / Talk / Membership / Training)</h4>
                        <p class="card-description">Fill all required activity details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-activity') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="activities-container">
                                <div class="activities-row row g-3 mb-3">

                                    <!-- Category -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="workshop">Workshop / Conference / Seminar</option>
                                            <option value="talk">Talk Delivered</option>
                                            <option value="membership">Membership</option>
                                            <option value="training">Training Course</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Type (Intl / National / Local) -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type (Intl./ National / Local)</label>
                                        <select class="form-select" name="type[]">
                                            <option value="">Select Type</option>
                                            <option value="International">International</option>
                                            <option value="National">National</option>
                                            <option value="Local">Local</option>
                                        </select>
                                    </div>

                                    <!-- Month / Year -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Month / Year</label>
                                        <input type="month" class="form-control" name="month_year[]">
                                    </div>

                                    <!-- Attended / Organised / Completed -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Attended / Organised / Completed</label>
                                        <select class="form-select" name="attended_or_role[]">
                                            <option value="">Select</option>
                                            <option value="Attended">Attended</option>
                                            <option value="Organised">Organised</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>

                                    <!-- Location -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location[]" placeholder="Enter Location">
                                    </div>

                                    <!-- Upload Certificate -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload Certificate</label>
                                        <input type="file" class="form-control" name="certificate[]">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-activity">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another activity -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-activity" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Activity
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/activities') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('activities-container');
    const addBtn = document.getElementById('add-activity');

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.activities-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.required = false;
        });

        // Title must always be required
        newRow.querySelector('input[name="title[]"]').required = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-activity')) {
            const rows = container.querySelectorAll('.activities-row');

            if (rows.length > 1) {
                e.target.closest('.activities-row').remove();
            } else {
                alert('At least one activity is required.');
            }
        }
    });
});
</script>
