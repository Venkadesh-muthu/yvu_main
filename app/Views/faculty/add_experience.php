<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Experience</h4>
                        <p class="card-description">Fill all required experience details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-experience') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple experience rows -->
                            <div id="experience-container">

                                <div class="experience-row row g-3 mb-3">
                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select" name="section[]" required>
                                            <option value="">Select Section</option>
                                            <option value="teaching">Teaching</option>
                                            <option value="research">Research</option>
                                            <option value="academic">Academic</option>
                                            <option value="service">Service</option>
                                            <option value="administrative">Administrative</option>
                                            <option value="collaborative">Collaborative</option>
                                        </select>
                                    </div>

                                    <!-- Title Type -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title Type</label>
                                        <select class="form-select" name="title_type[]" required>
                                            <option value="">Select Title Type</option>
                                            <option value="appointment">Appointment</option>
                                            <option value="position">Position</option>
                                            <option value="category_type">Category Type</option>
                                        </select>
                                    </div>

                                    <!-- Title Value -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title / Value</label>
                                        <input type="text" class="form-control" name="title_value[]" placeholder="Title / Value" required>
                                    </div>

                                    <!-- Workplace -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Workplace</label>
                                        <input type="text" class="form-control" name="workplace[]" placeholder="Workplace" required>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control" name="from_date[]" required>
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control" name="to_date[]">
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
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
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
        
        // Clear input values
        newRow.querySelectorAll('input, select').forEach(input => input.value = '');
        
        container.appendChild(newRow);
    });

    // Remove row functionality
    container.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('remove-experience')) {
            const rows = container.querySelectorAll('.experience-row');
            if(rows.length > 1) { // Keep at least one row
                e.target.closest('.experience-row').remove();
            } else {
                alert('At least one experience entry is required.');
            }
        }
    });
});
</script>
