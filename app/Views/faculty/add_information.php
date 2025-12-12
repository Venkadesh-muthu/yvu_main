<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Information</h4>
                        <p class="card-description">Fill all required activity details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-information') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="information-container">
                                <div class="information-row row g-3 mb-3">

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Agency -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Agency</label>
                                        <input type="text" class="form-control" name="agency[]" placeholder="Enter Agency" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Information Type</label>
                                        <select name="type[]" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="extra_curricular">Extra Curricular</option>
                                            <option value="extension_community">Extension & Community</option>
                                            <option value="relevant_information">Relevant Information</option>
                                        </select>
                                    </div>

                                    <!-- From Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">From Year</label>
                                        <input type="number" class="form-control" name="from_year[]" placeholder="YYYY">
                                    </div>

                                    <!-- To Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">To Year</label>
                                        <input type="number" class="form-control" name="to_year[]" placeholder="YYYY">
                                    </div>

                                    <!-- Upload -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">
                                    </div>

                                    <!-- Remove -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-information">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-information" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Information
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/information') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('information-container');
    const addBtn = document.getElementById('add-information');

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.information-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.required = false;
        });

        // Required fields
        newRow.querySelector('input[name="title[]"]').required = true;
        newRow.querySelector('input[name="agency[]"]').required = true;
        newRow.querySelector('select[name="type[]"]').required = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-information')) {
            const rows = container.querySelectorAll('.information-row');

            if (rows.length > 1) {
                e.target.closest('.information-row').remove();
            } else {
                alert('At least one information entry is required.');
            }
        }
    });
});
</script>
