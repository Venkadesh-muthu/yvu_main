<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Achievement</h4>
                        <p class="card-description">Fill all required achievement details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-achievement') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- ✅ Container for multiple achievement rows -->
                            <div id="achievement-container">

                                <div class="achievement-row row g-3 mb-3">

                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select" name="section[]" required>
                                            <option value="">Select Section</option>
                                            <option value="Awards / Honors">Awards / Honors</option>
                                            <option value="Patents / Intellectual Property">Patents / Intellectual Property</option>
                                        </select>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description[]" rows="2" placeholder="Enter Description"></textarea>
                                    </div>

                                    <!-- Month / Year -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Month / Year</label>
                                        <input type="month" class="form-control" name="month_year[]" required>
                                    </div>

                                    <!-- ✅ Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-achievement">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <!-- ✅ Add another achievement -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-achievement" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Achievement
                                </button>
                            </div>

                            <!-- ✅ Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/achievements') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<!-- ✅ SAME JS STYLE AS YOUR EXPERIENCE FORM -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-achievement');
    const container = document.getElementById('achievement-container');

    addBtn.addEventListener('click', function() {
        const newRow = container.querySelector('.achievement-row').cloneNode(true);

        // Clear input values
        newRow.querySelectorAll('input, select, textarea').forEach(input => input.value = '');

        container.appendChild(newRow);
    });

    // ✅ Remove row functionality
    container.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-achievement')) {
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
