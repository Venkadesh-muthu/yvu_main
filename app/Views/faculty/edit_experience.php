<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Experience</h4>
                        <p class="card-description">Update your experience details or add new entries</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-experience') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple experience rows -->
                            <div id="experience-container">

                                <!-- Existing Experience Row -->
                                <div class="experience-row row g-3 mb-3">
                                    <input type="hidden" name="id[]" value="<?= $experience['id'] ?>">

                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select" name="section[]" required>
                                            <option value="">Select Section</option>
                                            <option value="teaching" <?= $experience['section'] == 'teaching' ? 'selected' : '' ?>>Teaching</option>
                                            <option value="research" <?= $experience['section'] == 'research' ? 'selected' : '' ?>>Research</option>
                                            <option value="academic" <?= $experience['section'] == 'academic' ? 'selected' : '' ?>>Academic</option>
                                            <option value="service" <?= $experience['section'] == 'service' ? 'selected' : '' ?>>Service</option>
                                            <option value="administrative" <?= $experience['section'] == 'administrative' ? 'selected' : '' ?>>Administrative</option>
                                            <option value="collaborative" <?= $experience['section'] == 'collaborative' ? 'selected' : '' ?>>Collaborative</option>
                                            <option value="industry" <?= $experience['section'] == 'industry' ? 'selected' : '' ?>>Industry</option>
                                            <option value="others" <?= $experience['section'] == 'others' ? 'selected' : '' ?>>Others</option>
                                        </select>
                                    </div>

                                    <!-- Title Type -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title Type</label>
                                        <select class="form-select" name="title_type[]" required>
                                            <option value="">Select Title Type</option>
                                            <option value="appointment" <?= $experience['title_type'] == 'appointment' ? 'selected' : '' ?>>Appointment</option>
                                            <option value="position" <?= $experience['title_type'] == 'position' ? 'selected' : '' ?>>Position</option>
                                            <option value="category_type" <?= $experience['title_type'] == 'category_type' ? 'selected' : '' ?>>Category Type</option>
                                        </select>
                                    </div>

                                    <!-- Title Value -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title / Value</label>
                                        <input type="text" class="form-control" name="title_value[]" value="<?= $experience['title_value'] ?>" required>
                                    </div>

                                    <!-- Workplace -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Workplace</label>
                                        <input type="text" class="form-control" name="workplace[]" value="<?= $experience['workplace'] ?>" required>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control" name="from_date[]" value="<?= $experience['from_date'] ?>" required>
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control" name="to_date[]" value="<?= $experience['to_date'] ?>">
                                    </div>

                                    <!-- Remove button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-experience">Remove</button>
                                    </div>
                                </div>

                            </div>

                            <!-- Add another experience button -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-experience" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Experience
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/experiences') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-experience');
    const container = document.getElementById('experience-container');

    addBtn.addEventListener('click', function() {
        const newRow = container.querySelector('.experience-row').cloneNode(true);

        // ✅ CLEAR ALL INPUT VALUES
        newRow.querySelectorAll('input').forEach(input => {
            if (input.name === 'id[]') {
                input.value = '';   // Very important for new row
            } else {
                input.value = '';
            }
        });

        newRow.querySelectorAll('select').forEach(select => select.value = '');

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-experience')) {
            const rows = container.querySelectorAll('.experience-row');
            if(rows.length > 1) {
                e.target.closest('.experience-row').remove();
            } else {
                alert('At least one experience entry is required.');
            }
        }
    });
});
</script>
