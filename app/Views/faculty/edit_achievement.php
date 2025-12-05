<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Achievement</h4>
                        <p class="card-description">Update your achievement details or add new entries</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-achievement') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- ✅ Container for multiple achievement rows -->
                            <div id="achievement-container">

                                <!-- ✅ Existing Achievement Row -->
                                <div class="achievement-row row g-3 mb-3">
                                    <input type="hidden" name="id[]" value="<?= $achievement['id'] ?>">

                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select" name="section[]" required>
                                            <option value="">Select Section</option>
                                            <option value="Awards / Honors" <?= $achievement['section'] == 'Awards / Honors' ? 'selected' : '' ?>>Awards / Honors</option>
                                            <option value="Patents / Intellectual Property" <?= $achievement['section'] == 'Patents / Intellectual Property' ? 'selected' : '' ?>>Patents / Intellectual Property</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" value="<?= $achievement['title'] ?>" required>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description[]" rows="2"><?= $achievement['description'] ?></textarea>
                                    </div>

                                    <!-- Month / Year -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Month / Year</label>
                                        <input type="month" class="form-control" name="month_year[]" value="<?= $achievement['month_year'] ?>" required>
                                    </div>

                                    <!-- ✅ Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-achievement">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <!-- ✅ Add another achievement button -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-achievement" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Achievement
                                </button>
                            </div>

                            <!-- ✅ Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/achievements') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<!-- ✅ SAME JS LOGIC AS EXPERIENCE (WITH ID CLEARING) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-achievement');
    const container = document.getElementById('achievement-container');

    addBtn.addEventListener('click', function() {
        const newRow = container.querySelector('.achievement-row').cloneNode(true);

        // ✅ Clear all input + textarea values
        newRow.querySelectorAll('input, textarea').forEach(input => {
            if (input.name === 'id[]') {
                input.value = '';   // ✅ Important: New row must not carry old ID
            } else {
                input.value = '';
            }
        });

        newRow.querySelectorAll('select').forEach(select => select.value = '');

        container.appendChild(newRow);
    });

    // ✅ Remove row
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-achievement')) {
            const rows = container.querySelectorAll('.achievement-row');

            if (rows.length > 1) {
                e.target.closest('.achievement-row').remove();
            } else {
                alert('At least one achievement entry is required.');
            }
        }
    });
});
</script>
