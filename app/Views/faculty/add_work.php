<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Works (Publications / Books / Editorial)</h4>
                        <p class="card-description">Fill all required work details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-work') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="works-container">
                                <div class="works-row row g-3 mb-3">

                                    <!-- Category -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="Publication">Publication</option>
                                            <option value="Book">Book / Book Chapter</option>
                                            <option value="Editorial">Editorial</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-4 work-title">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Role (for books) -->
                                    <div class="col-12 col-md-4 work-role" style="display:none;">
                                        <label class="form-label">Role (for Book / Chapter)</label>
                                        <input type="text" class="form-control" name="role[]" placeholder="Enter Role if applicable">
                                    </div>

                                    <!-- Journal / Publisher -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Journal / Publisher</label>
                                        <input type="text" class="form-control" name="journal[]" placeholder="Enter Journal / Publisher">
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

                                    <!-- ISBN / ISSN -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">ISBN / ISSN</label>
                                        <input type="text" class="form-control" name="isbn_issn[]" placeholder="Enter ISBN / ISSN">
                                    </div>

                                    <!-- URL -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">URL</label>
                                        <input type="text" class="form-control" name="url[]" placeholder="Enter URL if any">
                                    </div>

                                    <!-- Upload PDF -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload PDF</label>
                                        <input type="file" class="form-control" name="pdf_file[]">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-work">Remove</button>
                                    </div>

                                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('works-container');
    const addBtn = document.getElementById('add-work');

    // ✅ TOGGLE TITLE / ROLE BASED ON CATEGORY
    container.addEventListener('change', function(e) {
        if (e.target.name === 'category[]') {
            const row = e.target.closest('.works-row');
            const title = row.querySelector('input[name="title[]"]');
            const role  = row.querySelector('input[name="role[]"]');

            if (e.target.value === 'Book') {
                title.value = '';
                title.readOnly = true;   // ✅ FIXED (not disabled)
                title.required = false;
                title.closest('.work-title').style.display = 'none';

                role.readOnly = false;
                role.required = true;
                role.closest('.work-role').style.display = 'block';

            } else {
                title.readOnly = false;
                title.required = true;
                title.closest('.work-title').style.display = 'block';

                role.value = '';
                role.readOnly = true;
                role.required = false;
                role.closest('.work-role').style.display = 'none';
            }
        }
    });

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.works-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.readOnly = false;

            if (input.name === 'title[]') {
                input.required = true;
            } else {
                input.required = false;
            }
        });

        newRow.querySelector('.work-title').style.display = 'block';
        newRow.querySelector('.work-role').style.display = 'none';
        newRow.querySelector('input[name="role[]"]').readOnly = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-work')) {
            const rows = container.querySelectorAll('.works-row');

            if (rows.length > 1) {
                e.target.closest('.works-row').remove();
            } else {
                alert('At least one work is required.');
            }
        }
    });
});
</script>



