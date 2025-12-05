<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Works (Publications / Books / Editorial)</h4>
                        <p class="card-description">Fill all required work details</p>
                        <form class="row g-3" action="<?= base_url('faculty/update-work') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="works-container">
                                <?php
                                // If editing, use existing $works array (can be a single row as array)
                                $works = isset($works) ? (array)$works : [[]]; // default one empty row
                        foreach ($works as $work):
                            ?>
                                <div class="works-row row g-3 mb-3">

                                    <!-- Hidden ID for update -->
                                    <input type="hidden" name="id[]" value="<?= $work['id'] ?? '' ?>">

                                    <!-- Category -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="form-select category-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="publication" <?= ($work['category'] ?? '') == 'publication' ? 'selected' : '' ?>>Publication</option>
                                            <option value="book" <?= ($work['category'] ?? '') == 'book' ? 'selected' : '' ?>>Book / Book Chapter</option>
                                            <option value="editorial" <?= ($work['category'] ?? '') == 'editorial' ? 'selected' : '' ?>>Editorial</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-4 work-title" <?= ($work['category'] ?? '') == 'book' ? 'style="display:none;"' : '' ?>>
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title"
                                            value="<?= esc($work['title'] ?? '') ?>" <?= ($work['category'] ?? '') == 'book' ? 'disabled' : 'required' ?>>
                                    </div>

                                    <!-- Role (for books) -->
                                    <div class="col-12 col-md-4 work-role" <?= ($work['category'] ?? '') == 'book' ? '' : 'style="display:none;"' ?>>
                                        <label class="form-label">Role (for Book / Chapter)</label>
                                        <input type="text" class="form-control" name="role[]" placeholder="Enter Role if applicable"
                                            value="<?= esc($work['role'] ?? '') ?>" <?= ($work['category'] ?? '') == 'book' ? 'required' : 'readonly' ?>>
                                    </div>

                                    <!-- Journal / Publisher -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Journal / Publisher</label>
                                        <input type="text" class="form-control" name="journal[]" placeholder="Enter Journal / Publisher"
                                            value="<?= esc($work['journal'] ?? '') ?>">
                                    </div>

                                    <!-- Type (Intl / National / Local) -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type (Intl./ National / Local)</label>
                                        <select class="form-select" name="type[]">
                                            <option value="">Select Type</option>
                                            <option value="International" <?= ($work['type'] ?? '') == 'International' ? 'selected' : '' ?>>International</option>
                                            <option value="National" <?= ($work['type'] ?? '') == 'National' ? 'selected' : '' ?>>National</option>
                                            <option value="Local" <?= ($work['type'] ?? '') == 'Local' ? 'selected' : '' ?>>Local</option>
                                        </select>
                                    </div>

                                    <!-- Month / Year -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Month / Year</label>
                                        <input type="month" class="form-control" name="month_year[]" value="<?= esc($work['month_year'] ?? '') ?>">
                                    </div>

                                    <!-- ISBN / ISSN -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">ISBN / ISSN</label>
                                        <input type="text" class="form-control" name="isbn_issn[]" placeholder="Enter ISBN / ISSN"
                                            value="<?= esc($work['isbn_issn'] ?? '') ?>">
                                    </div>

                                    <!-- URL -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">URL</label>
                                        <input type="text" class="form-control" name="url[]" placeholder="Enter URL if any"
                                            value="<?= esc($work['url'] ?? '') ?>">
                                    </div>

                                    <!-- Upload PDF -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload PDF</label>
                                        <input type="file" class="form-control" name="pdf_file[]">
                                        <?php if (!empty($work['pdf_path'])): ?>
                                            <small>Current File: <a href="<?= base_url($work['pdf_path']) ?>" target="_blank">View PDF</a></small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-work">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add another work -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-work" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Work
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/works') ?>" class="btn btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   

<!-- JS to Add / Remove Work Rows + Toggle Title / Role -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('works-container');
    const addBtn = document.getElementById('add-work');

    // ✅ CATEGORY CHANGE TOGGLE (FIXED)
    container.addEventListener('change', function (e) {
        if (e.target.name === 'category[]') {

            const row = e.target.closest('.works-row');
            const titleInput = row.querySelector('input[name="title[]"]');
            const roleInput  = row.querySelector('input[name="role[]"]');
            const titleDiv = titleInput.closest('.work-title');
            const roleDiv  = roleInput.closest('.work-role');

            // ✅ USE "book" EXACTLY AS YOUR OPTION VALUE
            if (e.target.value === 'book') {

                titleInput.value = '';
                titleInput.readOnly = true;   // ✅ FIX (NOT DISABLED)
                titleInput.required = false;
                titleDiv.style.display = 'none';

                roleInput.readOnly = false;
                roleInput.required = true;
                roleDiv.style.display = 'block';

            } else {

                titleInput.readOnly = false;
                titleInput.required = true;
                titleDiv.style.display = 'block';

                roleInput.value = '';
                roleInput.readOnly = true;
                roleInput.required = false;
                roleDiv.style.display = 'none';
            }
        }
    });

    // ✅ ADD NEW WORK ROW (FIXED)
    addBtn.addEventListener('click', function () {

        const firstRow = container.querySelector('.works-row');
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

            input.readOnly = false;   // ✅ FIX
            input.disabled = false;   // ✅ ENSURE ENABLED
            input.required = (input.name === 'title[]');
        });

        // ✅ RESET VISIBILITY
        newRow.querySelector('.work-title').style.display = 'block';
        newRow.querySelector('.work-role').style.display  = 'none';

        newRow.querySelector('input[name="role[]"]').readOnly = true;
        newRow.querySelector('input[name="role[]"]').required = false;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW (SAFE)
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-work')) {

            const rows = container.querySelectorAll('.works-row');

            if (rows.length > 1) {
                e.target.closest('.works-row').remove();
            } else {
                alert('At least one work entry is required.');
            }
        }
    });

});
</script>



