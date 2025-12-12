<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Information</h4>
                        <p class="card-description">Update information details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-information') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="information-container">
                                <?php
                                $information = isset($information) ? (array)$information : [[]];
                        foreach ($information as $info):
                            ?>
                                <div class="information-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= $info['id'] ?? '' ?>">

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]"
                                            value="<?= esc($info['title'] ?? '') ?>" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Agency -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Agency</label>
                                        <input type="text" class="form-control" name="agency[]"
                                            value="<?= esc($info['agency'] ?? '') ?>" placeholder="Enter Agency" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Information Type</label>
                                        <select name="type[]" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="extra_curricular" <?= ($info['type'] ?? '') == 'extra_curricular' ? 'selected' : '' ?>>Extra Curricular</option>
                                            <option value="extension_community" <?= ($info['type'] ?? '') == 'extension_community' ? 'selected' : '' ?>>Extension & Community</option>
                                            <option value="relevant_information" <?= ($info['type'] ?? '') == 'relevant_information' ? 'selected' : '' ?>>Relevant Information</option>
                                        </select>
                                    </div>

                                    <!-- From Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">From Year</label>
                                        <input type="number" class="form-control" name="from_year[]"
                                            value="<?= esc($info['from_year'] ?? '') ?>" placeholder="YYYY">
                                    </div>

                                    <!-- To Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">To Year</label>
                                        <input type="number" class="form-control" name="to_year[]"
                                            value="<?= esc($info['to_year'] ?? '') ?>" placeholder="YYYY">
                                    </div>

                                    <!-- Upload File -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">

                                        <?php if (!empty($info['upload_path'])): ?>
                                            <small>
                                                Current File:
                                                <a href="<?= base_url($info['upload_path']) ?>" target="_blank">View File</a>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-information">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-information" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Information
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/information') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('information-container');
    const addBtn = document.getElementById('add-information');

    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.information-row');
        const newRow = firstRow.cloneNode(true);

        // Clear values for cloned inputs and reset select
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type === 'hidden' || input.type === 'file') {
                input.value = '';
            } else {
                input.value = ''; // Clear text/number input
            }
        });

        // Reset selects
        newRow.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0; // reset to placeholder
        });

        container.appendChild(newRow);
    });

    container.addEventListener('click', function (e) {
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
