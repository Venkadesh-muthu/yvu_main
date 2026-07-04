<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Education Background</h4>
                        <p class="card-description">Update your education details or add new entries</p>
                        <form class="row g-3" action="<?= base_url('faculty/update-education') ?>" method="post">
                            <?= csrf_field() ?>

                            <div id="education-container">

                                <div class="education-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= esc($education['id']) ?>">
                                    <?php
                                        $categories = [
                                            'schooling'        => 'Schooling (I - X)',
                                            'intermediate'     => 'Intermediate (+2)',
                                            'graduation'       => 'Graduation',
                                            'post_graduation'  => 'Post Graduation',
                                            'mphil'            => 'M.Phil',
                                            'Ph.D.'            => 'Ph.D.',
                                            'post_doc'         => 'Postdoc',
                                            'diploma'          => 'Diploma',
                                        ];

                        $dbCategory = $education['category'] ?? '';
                        $isOther = !array_key_exists($dbCategory, $categories);
                        ?>

                                    <!-- Category -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Category</label>

                                        <select class="form-select category-select" name="category[]" required>
                                            <option value="">Select Category</option>

                                            <?php foreach ($categories as $key => $label): ?>
                                                <option value="<?= $key ?>"
                                                    <?= (!$isOther && $dbCategory === $key) ? 'selected' : '' ?>>
                                                    <?= $label ?>
                                                </option>
                                            <?php endforeach; ?>

                                            <option value="others" <?= $isOther ? 'selected' : '' ?>>Others</option>
                                        </select>

                                        <!-- Other category input -->
                                        <input type="text"
                                            name="category_other[]"
                                            class="form-control mt-2 other-category <?= $isOther ? '' : 'd-none' ?>"
                                            value="<?= $isOther ? esc($dbCategory) : '' ?>"
                                            placeholder="Enter category">
                                    </div>


                                    <!-- Course / Subject -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Course / Subject</label>
                                        <input type="text" class="form-control"
                                            name="course_subject[]"
                                            value="<?= esc($education['course_subject']) ?>">
                                    </div>

                                    <!-- Marks / Division -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Marks / Division</label>
                                        <input type="text" class="form-control"
                                            name="marks_division[]"
                                            value="<?= esc($education['marks_division']) ?>">
                                    </div>

                                    <!-- Year -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Year</label>
                                        <input type="text" class="form-control"
                                            name="year[]"
                                            value="<?= esc($education['year']) ?>">
                                    </div>

                                    <!-- Class -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Class</label>
                                        <input type="text" class="form-control"
                                            name="class[]"
                                            value="<?= esc($education['class']) ?>">
                                    </div>

                                    <!-- University -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">University / Board</label>
                                        <input type="text" class="form-control"
                                            name="university[]"
                                            value="<?= esc($education['university']) ?>">
                                    </div>

                                    <!-- Institute -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Institute / College / School</label>
                                        <input type="text" class="form-control"
                                            name="institute[]"
                                            value="<?= esc($education['institute']) ?>">
                                    </div>

                                    <!-- Country -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control"
                                            name="country[]"
                                            value="<?= esc($education['country'] ?? 'India') ?>">
                                    </div>

                                    <!-- Town -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Town / Village</label>
                                        <input type="text" class="form-control"
                                            name="town[]"
                                            value="<?= esc($education['town']) ?>">
                                    </div>

                                    <!-- District -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">District</label>
                                        <input type="text" class="form-control"
                                            name="district[]"
                                            value="<?= esc($education['district']) ?>">
                                    </div>

                                    <!-- State -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control"
                                            name="state[]"
                                            value="<?= esc($education['state']) ?>">
                                    </div>

                                     <!-- Highlights -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Highlights / Comments / Merits</label>
                                        <input type="text" class="form-control"
                                            name="highlights_comments_merits[]"
                                            value="<?= esc($education['highlights_comments_merits']) ?>">
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
                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/educations') ?>" class="btn btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

   

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-education');
    const container = document.getElementById('education-container');
    const form = document.querySelector('form');

    // Add new row
    addBtn.addEventListener('click', function () {
        const newRow = container.querySelector('.education-row').cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            if (input.name === 'id[]') input.value = '';
            if (input.classList.contains('other-category')) {
                input.classList.add('d-none');
                input.required = false;
            }
        });

        newRow.querySelectorAll('select').forEach(select => select.value = '');
        container.appendChild(newRow);
    });

    // Handle category change
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

