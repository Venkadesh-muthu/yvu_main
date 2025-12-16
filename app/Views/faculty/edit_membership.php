<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Memberships</h4>
                        <p class="card-description">Update membership details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-membership') ?>" method="post">
                            <?= csrf_field() ?>

                            <div id="memberships-container">

                                <?php if (!empty($memberships)): ?>
                                    <?php foreach ($memberships as $row): ?>
                                        <div class="membership-row row g-3 mb-3">

                                            <!-- Hidden ID -->
                                            <input type="hidden" name="id[]" value="<?= esc($row['id']) ?>">

                                            <!-- Category -->
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Category</label>
                                                <select class="form-select" name="category[]" required>
                                                    <option value="">Select Category</option>
                                                    <option value="Journal Editorial Board"
                                                        <?= ($row['category'] == 'Journal Editorial Board') ? 'selected' : '' ?>>
                                                        Journal Editorial Board
                                                    </option>
                                                    <option value="Professional Membership"
                                                        <?= ($row['category'] == 'Professional Membership') ? 'selected' : '' ?>>
                                                        Professional Membership
                                                    </option>
                                                    <option value="Society Fellowship"
                                                        <?= ($row['category'] == 'Society Fellowship') ? 'selected' : '' ?>>
                                                        Society Fellowship
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- Title -->
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Title</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="title[]"
                                                       value="<?= esc($row['title']) ?>"
                                                       placeholder="e.g. Editorial Board Member"
                                                       required>
                                            </div>

                                            <!-- Remove -->
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-membership">
                                                    Remove
                                                </button>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>

                            <!-- Add Another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-membership" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Membership
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/memberships') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('memberships-container');
    const addBtn = document.getElementById('add-membership');

    // ADD ROW
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.membership-row');
        const newRow = firstRow.cloneNode(true);

        // Clear values
        newRow.querySelectorAll('input, select').forEach(el => {
            if (el.type !== 'hidden') {
                el.value = '';
            }
        });

        // Remove hidden ID for new rows
        const hiddenId = newRow.querySelector('input[type="hidden"]');
        if (hiddenId) hiddenId.remove();

        container.appendChild(newRow);
    });

    // REMOVE ROW
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-membership')) {
            const rows = container.querySelectorAll('.membership-row');

            if (rows.length > 1) {
                e.target.closest('.membership-row').remove();
            } else {
                alert('At least one membership is required.');
            }
        }
    });
});
</script>
