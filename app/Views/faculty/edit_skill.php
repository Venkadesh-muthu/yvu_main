<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Skill / Specialisation / Research Area</h4>
                        <p class="card-description">Update your skill details or add new entries</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-skill') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple skill rows -->
                            <div id="skill-container">

                                <!-- Existing skill row -->
                                <div class="skill-row row g-3 mb-3">
                                    <input type="hidden" name="id[]" value="<?= esc($skill['id']) ?>">

                                    <!-- Category Dropdown -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select name="category[]" class="form-control" required>
                                            <option value="skill" 
                                                <?= ($skill['category'] === 'skill') ? 'selected' : '' ?>>
                                                Skill
                                            </option>
                                            <option value="specialisation" 
                                                <?= ($skill['category'] === 'specialisation') ? 'selected' : '' ?>>
                                                Specialisation
                                            </option>
                                            <option value="research" 
                                                <?= ($skill['category'] === 'research') ? 'selected' : '' ?>>
                                                Research Area
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Skill Value -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Skill / Specialisation / Research Area</label>
                                        <input type="text" name="skill_value[]" class="form-control"
                                               value="<?= esc($skill['skill_value']) ?>" required>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="col-12 col-md-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-skill">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <!-- Add another skill button -->
                            <div class="col-12 text-end mb-3">
                                <button type="button" id="add-skill" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Add Another Skill
                                </button>
                            </div>

                            <!-- Submit buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/skills') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-skill');
    const container = document.getElementById('skill-container');

    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.skill-row');
        const newRow = firstRow.cloneNode(true);

        // Clear values for cloned row
        newRow.querySelector('input[name="id[]"]').value = ''; 
        newRow.querySelector('input[name="skill_value[]"]').value = '';
        newRow.querySelector('select[name="category[]"]').selectedIndex = 0;

        container.appendChild(newRow);
    });

    // Remove row
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill')) {
            const rows = container.querySelectorAll('.skill-row');
            if (rows.length > 1) {
                e.target.closest('.skill-row').remove();
            } else {
                alert('At least one skill entry is required.');
            }
        }
    });
});
</script>
