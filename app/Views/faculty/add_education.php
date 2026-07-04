<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Education Background</h4>
                        <p class="card-description">Fill all required education details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-education') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple education rows -->
                            <div id="education-container">
                                <div class="education-row row g-3 mb-3">

                                    <!-- Category -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Category</label>
                                        <select class="form-select category-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="schooling">Schooling (I - X)</option>
                                            <option value="intermediate">Intermediate (+2)</option>
                                            <option value="graduation">Graduation</option>
                                            <option value="post_graduation">Post Graduation</option>
                                            <option value="mphil">M.Phil</option>
                                            <option value="Ph.D.">Ph.D.</option>
                                            <option value="post_doc">Postdoc</option>
                                            <option value="diploma">Diploma</option>
                                            <option value="others">Others</option>
                                        </select>

                                        <input type="text" name="category_other[]"
                                            class="form-control mt-2 other-category d-none"
                                            placeholder="Enter category">

                                    </div>

                                    <!-- Course / Subject -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Course / Subject</label>
                                        <input type="text" class="form-control" name="course_subject[]">
                                    </div>

                                    <!-- Marks / Division (NEXT TO Course) -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Marks / Division</label>
                                        <input type="text" class="form-control" name="marks_division[]">
                                    </div>

                                    <!-- Year -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Year</label>
                                        <input type="text" class="form-control" name="year[]" placeholder="e.g. 2020">
                                    </div>

                                    <!-- Class -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Class</label>
                                        <input type="text" class="form-control" name="class[]" placeholder="First / Distinction">
                                    </div>

                                    <!-- University -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">University / Board</label>
                                        <input type="text" class="form-control" name="university[]">
                                    </div>

                                    <!-- Institute -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Institute / College / School</label>
                                        <input type="text" class="form-control" name="institute[]">
                                    </div>

                                    <!-- Country -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control" name="country[]" value="India">
                                    </div>

                                    <!-- Town -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Town / Village</label>
                                        <input type="text" class="form-control" name="town[]">
                                    </div>

                                    <!-- District -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">District</label>
                                        <input type="text" class="form-control" name="district[]">
                                    </div>

                                    <!-- State -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control" name="state[]">
                                    </div>

                                    <!-- Highlights / Comments / Merits -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Highlights / Comments / Merits</label>
                                        <input type="text" class="form-control" name="highlights_comments_merits[]">
                                    </div>
                                    <!-- Remove -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-education">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another education button -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-education" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Education
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/educations') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

   

<!-- JS to clone education row -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-education');
    const container = document.getElementById('education-container');
    const form = document.querySelector('form');

    // Add new row
    addBtn.addEventListener('click', function () {
        const newRow = container.querySelector('.education-row').cloneNode(true);

        // Clear input values
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            if (input.classList.contains('other-category')) {
                input.classList.add('d-none');
                input.required = false;
            }
        });

        newRow.querySelectorAll('select').forEach(select => select.value = '');
        container.appendChild(newRow);
    });

    // Handle category change for "Other"
    container.addEventListener('change', function (e) {
        if (!e.target.classList.contains('category-select')) return;

        const row = e.target.closest('.education-row');
        const otherInput = row.querySelector('.other-category');

        if (e.target.value === 'others') {
            otherInput.classList.remove('d-none');
            otherInput.required = true;
        } else {
            otherInput.classList.add('d-none');
            otherInput.value = '';
            otherInput.required = false;
        }
    });

    // Remove row
    container.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-education')) return;

        const rows = container.querySelectorAll('.education-row');
        if (rows.length > 1) {
            e.target.closest('.education-row').remove();
        } else {
            alert('At least one education entry is required.');
        }
    });

});
</script>


