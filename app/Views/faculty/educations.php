<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Educational Background</h4>

                <!-- Add Education Button -->
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-education') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Education
                        </a>
                    </div>

                </div>

                <!-- Education Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Year/Class</th>
                                <th>Institute</th>
                                <th>Town</th>
                                <th>District</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($education)): ?>
                            <?php $i = 1;
                            foreach ($education as $edu): ?>
                                <tr>
                                    <td><?= $i++; ?></td>

                                    <!-- CATEGORY -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= ucfirst(str_replace('_', ' ', $edu['category'])) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['category']) && $visibility[$edu['id']]['category'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'category', this.checked)">
                                        </div>
                                    </td>

                                    <!-- YEAR/CLASS -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($edu['year_of_class']) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['year_of_class']) && $visibility[$edu['id']]['year_of_class'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'year_of_class', this.checked)">
                                        </div>
                                    </td>

                                    <!-- INSTITUTE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($edu['institute']) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['institute']) && $visibility[$edu['id']]['institute'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'institute', this.checked)">
                                        </div>
                                    </td>

                                    <!-- TOWN -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($edu['town']) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['town']) && $visibility[$edu['id']]['town'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'town', this.checked)">
                                        </div>
                                    </td>

                                    <!-- DISTRICT -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($edu['district']) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['district']) && $visibility[$edu['id']]['district'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'district', this.checked)">
                                        </div>
                                    </td>

                                    <!-- STATE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($edu['state']) ?></span>

                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$edu['id']]['state']) && $visibility[$edu['id']]['state'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleEducationVisibility(<?= $edu['id'] ?>, 'state', this.checked)">
                                        </div>
                                    </td>

                                    <!-- ACTIONS -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-education/' . $edu['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-education/' . $edu['id']) ?>"
                                        onclick="return confirm('Delete this education?');"
                                        class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

