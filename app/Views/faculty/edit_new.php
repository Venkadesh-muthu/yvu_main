<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit News / Press / Pictures</h4>
                        <p class="card-description">Update news details</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-news') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="news-container">
                                <?php
                                $newsItems = isset($news) ? (array)$news : [[]];
                        foreach ($newsItems as $item):
                            ?>
                                <div class="news-row row g-3 mb-3">

                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id[]" value="<?= $item['id'] ?? '' ?>">

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]"
                                               value="<?= esc($item['title'] ?? '') ?>" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type (Intl / National / Local)</label>
                                        <select name="type[]" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="international" <?= ($item['type'] ?? '') == 'international' ? 'selected' : '' ?>>International</option>
                                            <option value="national" <?= ($item['type'] ?? '') == 'national' ? 'selected' : '' ?>>National</option>
                                            <option value="local" <?= ($item['type'] ?? '') == 'local' ? 'selected' : '' ?>>Local</option>
                                        </select>
                                    </div>

                                    <!-- Month & Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Month & Year</label>
                                        <input type="month" class="form-control" name="month_year[]"
                                               value="<?= esc($item['month_year'] ?? '') ?>">
                                    </div>

                                    <!-- Upload File -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">

                                        <?php if (!empty($item['upload_path'])): ?>
                                            <small>
                                                Current File:
                                                <a href="<?= base_url($item['upload_path']) ?>" target="_blank">View File</a>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-news">Remove</button>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Add another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-news" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another News
                                </button>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/news') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('news-container');
    const addBtn = document.getElementById('add-news');

    // ✅ ADD NEW NEWS ROW
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.news-row');
        const newRow = firstRow.cloneNode(true);

        // Clear inputs
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type === 'hidden' || input.type === 'file') {
                input.value = '';
            } else {
                input.value = '';
            }
        });

        // Reset selects
        newRow.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });

        container.appendChild(newRow);
    });

    // ✅ REMOVE NEWS ROW
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-news')) {
            const rows = container.querySelectorAll('.news-row');
            if (rows.length > 1) {
                e.target.closest('.news-row').remove();
            } else {
                alert('At least one news entry is required.');
            }
        }
    });

});
</script>
