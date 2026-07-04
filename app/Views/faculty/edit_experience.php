<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
.to-date {
    cursor: pointer;
}
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Experience</h4>
                        <p class="card-description">Update your experience details or add new entries</p>

                        <form class="row g-3" action="<?= base_url('faculty/update-experience') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple experience rows -->
                            <div id="experience-container">

                                <!-- Existing Experience Row -->
                                <div class="experience-row row g-3 mb-3">
                                    <input type="hidden" name="id[]" value="<?= $experience['id'] ?>">
                                    <?php
                                        $sections = [
                                            'teaching'       => 'Teaching',
                                            'research'       => 'Research',
                                            'academic'       => 'Academic',
                                            'service'        => 'Service',
                                            'administrative' => 'Administrative',
                                            'collaborative'  => 'Collaborative',
                                            'industry'       => 'Industry',
                                        ];

                        $dbSection = $experience['section'] ?? '';
                        $isOther = !array_key_exists($dbSection, $sections);
                        ?>

                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select section-select" name="section[]" required>
                                        <option value="">Select Section</option>

                                        <?php foreach ($sections as $key => $label): ?>
                                            <option value="<?= $key ?>"
                                                <?= (!$isOther && $dbSection === $key) ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>

                                        <option value="others" <?= $isOther ? 'selected' : '' ?>>Others</option>
                                    </select>

                                    <input type="text"
                                        name="section_other[]"
                                        class="form-control mt-2 other-section <?= $isOther ? '' : 'd-none' ?>"
                                        value="<?= $isOther ? esc($dbSection) : '' ?>"
                                        placeholder="Enter Section">


                                    </div>

                                    <!-- Title Type -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title Type</label>
                                        <select class="form-select" name="title_type[]">
                                            <option value="">Select Title Type</option>
                                            <option value="appointment" <?= $experience['title_type'] == 'appointment' ? 'selected' : '' ?>>Appointment</option>
                                            <option value="position" <?= $experience['title_type'] == 'position' ? 'selected' : '' ?>>Position</option>
                                            <option value="category_type" <?= $experience['title_type'] == 'category_type' ? 'selected' : '' ?>>Category Type</option>
                                        </select>
                                    </div>

                                    <!-- Title Value -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title / Value</label>
                                        <input type="text" class="form-control" name="title_value[]" value="<?= $experience['title_value'] ?>">
                                    </div>

                                    <!-- Workplace -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Workplace</label>
                                        <input type="text" class="form-control" name="workplace[]" value="<?= $experience['workplace'] ?>">
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">From Date</label>
                                        <input type="text"
                                            class="form-control from-date"
                                            name="from_date[]"
                                            value="<?= esc($experience['from_date']) ?>"
                                            placeholder="DD-MMM-YYYY"
                                            >
                                    </div>

                                    <!-- To Date / Still Working -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">To</label>

                                        <div class="d-flex gap-5 mb-2 ps-5">
                                            <div class="form-check">
                                                <input class="form-check-input to-type"
                                                    type="radio"
                                                    name="to_type[0]"
                                                    value="date"
                                                    <?= ($experience['to_date'] !== 'Present') ? 'checked' : '' ?>>
                                                <label class="form-check-label">To Date</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input to-type"
                                                    type="radio"
                                                    name="to_type[0]"
                                                    value="present"
                                                    <?= ($experience['to_date'] === 'Present') ? 'checked' : '' ?>>
                                                <label class="form-check-label">Still Working</label>
                                            </div>
                                        </div>

                                        <!-- Visible input -->
                                        <input type="text"
                                            class="form-control to-date"
                                            placeholder="DD-MMM-YYYY"
                                            value="<?= $experience['to_date'] !== 'Present' ? esc($experience['to_date']) : 'Present' ?>"
                                            <?= $experience['to_date'] === 'Present' ? 'readonly' : '' ?>>

                                        <!-- Hidden input (submitted value) -->
                                        <input type="hidden"
                                            class="to-date-hidden"
                                            name="to_date[]"
                                            value="<?= esc($experience['to_date']) ?>">
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
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/experiences') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('experience-container');
    const addBtn = document.getElementById('add-experience');

    /* ---------- DATE PICKER INIT ---------- */
    function initDatePicker(context = document) {

        context.querySelectorAll('.experience-row').forEach(row => {

            const fromInput = row.querySelector('.from-date');
            const toInput   = row.querySelector('.to-date');
            const hidden    = row.querySelector('.to-date-hidden');

            if (fromInput && !fromInput._flatpickr) {
                flatpickr(fromInput, {
                    dateFormat: "d-M-Y",
                    allowInput: false,
                    onChange: function (dates) {
                        if (toInput?._flatpickr) {
                            toInput._flatpickr.set('minDate', dates[0]);
                        }
                    }
                });
            }

            if (toInput && !toInput._flatpickr) {
                flatpickr(toInput, {
                    dateFormat: "d-M-Y",
                    allowInput: false,
                    onChange: function (_, dateStr) {
                        if (hidden) hidden.value = dateStr;
                    }
                });
            }
        });
    }

    initDatePicker();

    /* ---------- ADD EXPERIENCE ---------- */
    addBtn.addEventListener('click', function () {

        const rows = container.querySelectorAll('.experience-row');
        const index = rows.length;

        // destroy flatpickr before clone
        rows[0].querySelectorAll('.from-date, .to-date').forEach(input => {
            if (input._flatpickr) {
                input._flatpickr.destroy();
                input._flatpickr = null;
            }
        });

        const newRow = rows[0].cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(input => {

            if (input.type === 'radio') {
                input.checked = input.value === 'date';
                input.name = `to_type[${index}]`;
            } else {
                input.value = '';
            }

            if (input.classList.contains('other-section')) {
                input.classList.add('d-none');
                input.required = false;
            }
        });

        container.appendChild(newRow);
        initDatePicker(container);
    });

    /* ---------- SECTION OTHERS ---------- */
    container.addEventListener('change', function (e) {
        if (!e.target.classList.contains('section-select')) return;

        const row = e.target.closest('.experience-row');
        const other = row.querySelector('.other-section');

        if (e.target.value === 'others') {
            other.classList.remove('d-none');
            other.required = true;
        } else {
            other.classList.add('d-none');
            other.value = '';
            other.required = false;
        }
    });

    /* ---------- PRESENT / DATE ---------- */
    container.addEventListener('change', function (e) {
        if (!e.target.classList.contains('to-type')) return;

        const row = e.target.closest('.experience-row');
        const toInput = row.querySelector('.to-date');
        const hidden = row.querySelector('.to-date-hidden');
        const fp = toInput._flatpickr;

        if (e.target.value === 'present') {
            toInput.value = 'Present';
            hidden.value = 'Present';
            toInput.readOnly = true;
            toInput.style.pointerEvents = 'none';
            if (fp) fp.close();
        } else {
            toInput.value = '';
            hidden.value = '';
            toInput.readOnly = false;
            toInput.style.pointerEvents = 'auto';
            if (fp) fp.enable();
        }
    });

    /* ---------- REMOVE ---------- */
    container.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-experience')) return;

        const rows = container.querySelectorAll('.experience-row');
        if (rows.length > 1) {
            e.target.closest('.experience-row').remove();
        } else {
            alert('At least one experience entry is required.');
        }
    });

});
</script>
