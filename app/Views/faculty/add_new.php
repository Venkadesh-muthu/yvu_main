<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add News / Press / Pictures</h4>
                        <p class="card-description">Fill all required details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-news') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div id="news-container">
                                <div class="news-row row g-3 mb-3">

                                    <!-- Title -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Enter Title" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Type</label>
                                        <select name="type[]" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="international">International</option>
                                            <option value="national">National</option>
                                            <option value="local">Local</option>
                                        </select>
                                    </div>

                                    <!-- Month & Year -->
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Month & Year</label>
                                        <input type="month" class="form-control" name="month_year[]" required>
                                    </div>

                                    <!-- Upload -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file[]">
                                    </div>

                                    <!-- Remove -->
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-news">Remove</button>
                                    </div>

                                </div>
                            </div>

                            <!-- Add another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-news" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another News
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/news') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('news-container');
    const addBtn = document.getElementById('add-news');

    // ✅ ADD NEW ROW
    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.news-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
            input.required = false;
        });

        // Required fields
        newRow.querySelector('input[name="title[]"]').required = true;
        newRow.querySelector('select[name="type[]"]').required = true;
        newRow.querySelector('input[name="month_year[]"]').required = true;

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function(e) {
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
