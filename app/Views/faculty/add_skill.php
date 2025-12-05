<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Skills / Specialisation / Research Areas</h4>
                        <p class="card-description">Fill all required skill details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-skill') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple skill rows -->
                            <div id="skill-container">

                                <div class="skill-row row g-3 mb-3">

                                    <!-- Skill Value -->
                                    <div class="col-12 col-md-10">
                                        <label class="form-label">Skill / Specialisation / Research Area</label>
                                        <input type="text" class="form-control" name="skill_value[]" placeholder="Enter Skill" required>
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

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
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
        const newRow = container.querySelector('.skill-row').cloneNode(true);

        // Clear input value
        newRow.querySelectorAll('input').forEach(input => input.value = '');

        container.appendChild(newRow);
    });

    // Remove row functionality
    container.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-skill')) {
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
