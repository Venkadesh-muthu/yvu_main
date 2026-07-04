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
                                            <option value="Publication" <?= ($work['category'] ?? '') == 'Publication' ? 'selected' : '' ?>>Publication</option>
                                            <option value="Book" <?= ($work['category'] ?? '') == 'Book' ? 'selected' : '' ?>>Book</option>
                                            <option value="Book Chapter" <?= ($work['category'] ?? '') == 'Book Chapter' ? 'selected' : '' ?>>Book Chapter</option>
                                            <option value="Editorial" <?= ($work['category'] ?? '') == 'Editorial' ? 'selected' : '' ?>>Editorial</option>
                                            <option value="Others" <?= ($work['category'] ?? '') == 'Others' ? 'selected' : '' ?>>Others</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-4 work-title">
                                        <label class="form-label">Title</label>
                                        <input type="text"
                                            class="form-control"
                                            name="title[]"
                                            placeholder="Enter Title"
                                            value="<?= esc($work['title'] ?? '') ?>">
                                    </div>

                                    <!-- Role -->
                                    <div class="col-12 col-md-4 work-role">
                                        <label class="form-label">Role (for Book / Chapter)</label>
                                        <input type="text"
                                            class="form-control"
                                            name="role[]"
                                            placeholder="Enter Role if applicable"
                                            value="<?= esc($work['role'] ?? '') ?>">
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
                                            <option value="Regional" <?= ($work['type'] ?? '') == 'Regional' ? 'selected' : '' ?>>Regional</option>
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
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Authors</label>
                                        <input type="text" class="form-control" name="authers[]" placeholder="Enter Authors"
                                            value="<?= esc($work['authers'] ?? '') ?>">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Volume</label>
                                        <input type="text" class="form-control" name="volume[]" placeholder="Enter Volume"
                                            value="<?= esc($work['volume'] ?? '') ?>">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Page Numbers</label>
                                        <input type="text" class="form-control" name="page_numbers[]" placeholder="Enter Page Numbers"
                                            value="<?= esc($work['page_numbers'] ?? '') ?>">
                                    </div>
                                    <!-- DOI -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">DOI</label>
                                        <input type="text" class="form-control" name="doi[]" placeholder="Enter DOI (e.g. 10.1000/xyz123)"
                                            value="<?= esc($work['doi'] ?? '') ?>">
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

    // ✅ FUNCTION TO TOGGLE TITLE / ROLE
    function toggleFields(categorySelect) {

        const row = categorySelect.closest('.works-row');
        const titleInput = row.querySelector('input[name="title[]"]');
        const roleInput  = row.querySelector('input[name="role[]"]');
        const titleDiv   = row.querySelector('.work-title');
        const roleDiv    = row.querySelector('.work-role');

        const value = categorySelect.value;

        if (value === 'Book' || value === 'Book Chapter') {

            // Hide Title
            titleInput.value = '';
            titleInput.readOnly = true;
            titleInput.required = false;
            titleDiv.style.display = 'none';

            // Show Role
            roleInput.readOnly = false;
            roleInput.required = true;
            roleDiv.style.display = 'block';

        } else {

            // Show Title
            titleInput.readOnly = false;
            titleInput.required = true;
            titleDiv.style.display = 'block';

            // Hide Role
            roleInput.value = '';
            roleInput.readOnly = true;
            roleInput.required = false;
            roleDiv.style.display = 'none';
        }
    }

    // ✅ APPLY ON PAGE LOAD (EDIT MODE FIX)
    container.querySelectorAll('select[name="category[]"]').forEach(select => {
        toggleFields(select);
    });

    // ✅ APPLY ON CATEGORY CHANGE
    container.addEventListener('change', function (e) {
        if (e.target.name === 'category[]') {
            toggleFields(e.target);
        }
    });

    // ✅ ADD NEW WORK ROW
    addBtn.addEventListener('click', function () {

        const firstRow = container.querySelector('.works-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.readOnly = false;
            input.required = false;
        });

        newRow.querySelector('.work-title').style.display = 'block';
        newRow.querySelector('.work-role').style.display = 'none';

        newRow.querySelector('input[name="role[]"]').readOnly = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
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




