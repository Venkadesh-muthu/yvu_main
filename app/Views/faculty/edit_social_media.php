<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Social Media Links</h4>
                        <p class="card-description">Update one or more social media links</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-social-media') ?>" method="post">
                            <?= csrf_field() ?>

                            <div id="social-container">

                                <?php if (!empty($socialMedia)): ?>
                                    <?php foreach ($socialMedia as $row): ?>
                                    <div class="social-row row g-3 mb-3">

                                        <input type="hidden" name="id[]" value="<?= $row['id'] ?>">

                                        <!-- Instagram -->
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Instagram</label>
                                            <input type="url"
                                                   class="form-control"
                                                   name="instagram_link[]"
                                                   value="<?= esc($row['instagram_link']) ?>"
                                                   placeholder="https://instagram.com/username">
                                        </div>

                                        <!-- WhatsApp -->
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="url"
                                                   class="form-control"
                                                   name="whatsapp_link[]"
                                                   value="<?= esc($row['whatsapp_link']) ?>"
                                                   placeholder="https://wa.me/91XXXXXXXXXX">
                                        </div>

                                        <!-- Facebook -->
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Facebook</label>
                                            <input type="url"
                                                   class="form-control"
                                                   name="facebook_link[]"
                                                   value="<?= esc($row['facebook_link']) ?>"
                                                   placeholder="https://facebook.com/username">
                                        </div>

                                        <!-- Twitter -->
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Twitter / X</label>
                                            <input type="url"
                                                   class="form-control"
                                                   name="twitter_link[]"
                                                   value="<?= esc($row['twitter_link']) ?>"
                                                   placeholder="https://twitter.com/username">
                                        </div>

                                        <!-- Remove -->
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-social">
                                                Remove
                                            </button>
                                        </div>

                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>

                                    <!-- If no records -->
                                    <div class="social-row row g-3 mb-3">

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Instagram</label>
                                            <input type="url" class="form-control" name="instagram_link[]">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="url" class="form-control" name="whatsapp_link[]">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Facebook</label>
                                            <input type="url" class="form-control" name="facebook_link[]">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Twitter / X</label>
                                            <input type="url" class="form-control" name="twitter_link[]">
                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-social">
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                <?php endif; ?>

                            </div>

                            <!-- Add another -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-social" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/social-media') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('social-container');
    const addBtn = document.getElementById('add-social');

    // ✅ ADD ROW
    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.social-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            if (input.type !== 'hidden') input.value = '';
        });

        newRow.querySelectorAll('input[type="hidden"]').forEach(h => h.remove());

        container.appendChild(newRow);
    });

    // ✅ REMOVE ROW
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-social')) {
            const rows = container.querySelectorAll('.social-row');
            if (rows.length > 1) {
                e.target.closest('.social-row').remove();
            } else {
                alert('At least one social media row is required.');
            }
        }
    });

});
</script>
