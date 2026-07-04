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

                        <h4 class="card-title">Add Experience</h4>
                        <p class="card-description">Fill all required experience details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-experience') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Container for multiple experience rows -->
                            <div id="experience-container">

                                <div class="experience-row row g-3 mb-3">
                                    <!-- Section -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Section</label>
                                        <select class="form-select section-select" name="section[]" required>
                                            <option value="">Select Section</option>
                                            <option value="teaching">Teaching</option>
                                            <option value="research">Research</option>
                                            <option value="academic">Academic</option>
                                            <option value="service">Service</option>
                                            <option value="administrative">Administrative</option>
                                            <option value="collaborative">Collaborative</option>
                                            <option value="industry">Industry</option>
                                            <option value="others">Others</option>
                                        </select>
                                        <input type="text"
                                        name="section_other[]"
                                        class="form-control mt-2 other-section d-none"
                                        placeholder="Enter Section">
                                    </div>

                                    <!-- Title Type -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title Type</label>
                                        <select class="form-select" name="title_type[]">
                                            <option value="">Select Title Type</option>
                                            <option value="appointment">Appointment</option>
                                            <option value="position">Position</option>
                                            <option value="category_type">Category Type</option>
                                        </select>
                                    </div>

                                    <!-- Title Value -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Title / Value</label>
                                        <input type="text" class="form-control" name="title_value[]" placeholder="Title / Value">
                                    </div>

                                    <!-- Workplace -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Workplace</label>
                                        <input type="text" class="form-control" name="workplace[]" placeholder="Workplace">
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">From Date</label>
                                        <input type="text"
                                            class="form-control from-date"
                                            name="from_date[]"
                                            placeholder="DD-MMM-YYYY">
                                    </div>

                                    <!-- To Date OR Still Working -->
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">To</label>

                                        <div class="d-flex gap-1 mb-2" style="padding-left: 22px;"s>
                                            <div class="form-check">
                                                <input class="form-check-input to-type" type="radio"
                                                    name="to_type[0]" value="date" checked>
                                                <label class="form-check-label">To Date</label>
                                            </div>

                                            <div class="form-check" style="padding-left: 50px;">
                                                <input class="form-check-input to-type" type="radio"
                                                    name="to_type[0]" value="present">
                                                <label class="form-check-label">Still Working</label>
                                            </div>
                                        </div>

                                        <input type="text"
                                            class="form-control to-date"
                                            placeholder="DD-MMM-YYYY">

                                        <input type="hidden"
                                            class="to-date-hidden"
                                            name="to_date[]">

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
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
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

