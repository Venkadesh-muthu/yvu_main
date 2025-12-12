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
                                        <select class="form-select" name="category[]" required>
                                            <option value="">Select Category</option>
                                            <option value="schooling">Schooling (I - X)</option>
                                            <option value="intermediate">Intermediate (+2)</option>
                                            <option value="graduation">Graduation</option>
                                            <option value="post_graduation">Post Graduation</option>
                                            <option value="mphil_phd">M.Phil / PhD</option>
                                        </select>
                                    </div>

                                    <!-- Year / Class -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Year / Class</label>
                                        <input type="text" class="form-control" name="year_class[]" placeholder="Year / Class" required>
                                    </div>

                                    <!-- Institute -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Institute / College / School</label>
                                        <input type="text" class="form-control" name="institute[]" placeholder="Institute Name" required>
                                    </div>

                                    <!-- Town / Village -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Town / Village</label>
                                        <input type="text" class="form-control" name="town[]" placeholder="Town / Village">
                                    </div>

                                    <!-- District -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">District</label>
                                        <input type="text" class="form-control" name="district[]" placeholder="District">
                                    </div>

                                    <!-- State -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control" name="state[]" placeholder="State">
                                    </div>

                                    <!-- Remove button -->
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
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-education');
    const container = document.getElementById('education-container');

    addBtn.addEventListener('click', function() {
        const newRow = container.querySelector('.education-row').cloneNode(true);
        
        // Clear input values
        newRow.querySelectorAll('input, select').forEach(input => input.value = '');
        
        container.appendChild(newRow);
    });

    // Remove row functionality
    container.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('remove-education')) {
            const rows = container.querySelectorAll('.education-row');
            if(rows.length > 1) { // Keep at least one row
                e.target.closest('.education-row').remove();
            } else {
                alert('At least one education entry is required.');
            }
        }
    });
});
</script>
