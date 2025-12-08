<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Activities</h4>
                        <p class="card-description">Update activity details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-activity') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="activities-container">
                                <?php
                                $activities = isset($activities) ? (array)$activities : [[]];

                        foreach ($activities as $activity):
                            ?>
                                <div class="activities-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= $activity['id'] ?? '' ?>">

                                    <!-- Category -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="form-select category-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="workshop"   <?= ($activity['category'] ?? '') == 'workshop' ? 'selected' : '' ?>>Workshop / Conference / Seminar</option>
                                            <option value="talk"       <?= ($activity['category'] ?? '') == 'talk' ? 'selected' : '' ?>>Talk Delivered</option>
                                            <option value="membership" <?= ($activity['category'] ?? '') == 'membership' ? 'selected' : '' ?>>Membership</option>
                                            <option value="training"   <?= ($activity['category'] ?? '') == 'training' ? 'selected' : '' ?>>Training Course</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title"
                                            value="<?= esc($activity['title'] ?? '') ?>" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type (Intl./ National / Local)</label>
                                        <select class="form-select" name="type[]">
                                            <option value="">Select Type</option>
                                            <option value="International" <?= ($activity['type'] ?? '') == 'International' ? 'selected' : '' ?>>International</option>
                                            <option value="National"      <?= ($activity['type'] ?? '') == 'National' ? 'selected' : '' ?>>National</option>
                                            <option value="Local"         <?= ($activity['type'] ?? '') == 'Local' ? 'selected' : '' ?>>Local</option>
                                        </select>
                                    </div>

                                    <!-- Month / Year -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Month / Year</label>
                                        <input type="month" class="form-control" name="month_year[]"
                                            value="<?= esc($activity['month_year'] ?? '') ?>">
                                    </div>

                                    <!-- Attended / Organised / Completed -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Attended / Organised / Completed</label>
                                        <select class="form-select" name="attended_or_role[]">
                                            <option value="">Select</option>
                                            <option value="Attended"   <?= ($activity['attended_or_role'] ?? '') == 'Attended' ? 'selected' : '' ?>>Attended</option>
                                            <option value="Organised"  <?= ($activity['attended_or_role'] ?? '') == 'Organised' ? 'selected' : '' ?>>Organised</option>
                                            <option value="Completed" <?= ($activity['attended_or_role'] ?? '') == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                        </select>
                                    </div>

                                    <!-- Location -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location[]" placeholder="Enter Location"
                                            value="<?= esc($activity['location'] ?? '') ?>">
                                    </div>

                                    <!-- Upload Certificate -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload Certificate</label>
                                        <input type="file" class="form-control" name="certificate[]">

                                        <?php if (!empty($activity['certificate_path'])): ?>
                                            <small>
                                                Current File:
                                                <a href="<?= base_url($activity['certificate_path']) ?>" target="_blank">
                                                    View Certificate
                                                </a>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-activity">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add another activity -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-activity" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Activity
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/activities') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('activities-container');
    const addBtn = document.getElementById('add-activity');

    // ✅ ADD NEW ACTIVITY ROW
    addBtn.addEventListener('click', function () {

        const firstRow = container.querySelector('.activities-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {

            if (input.type === 'hidden') {
                input.value = '';
            } 
            else if (input.type === 'file') {
                input.value = '';
            } 
            else {
                input.value = '';
            }

            input.readOnly  = false;
            input.disabled  = false;
            input.required  = (input.name === 'title[]');
        });

        container.appendChild(newRow);
    });

    // ✅ REMOVE ACTIVITY ROW
    container.addEventListener('click', function (e) {
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
