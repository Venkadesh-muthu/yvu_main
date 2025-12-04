<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Faculty Experience</h4>

                <!-- Add Experience Button -->
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-experience') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Experience
                        </a>
                    </div>
                </div>

                <!-- Experience Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Section</th>
                                <th>Title Type</th>
                                <th>Title Value</th>
                                <th>Workplace</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($experience)): ?>
                            <?php $i = 1;
                            foreach ($experience as $exp): ?>
                                <tr>
                                    <td><?= $i++; ?></td>

                                    <!-- SECTION -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= ucfirst($exp['section']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['section']) && $visibility[$exp['id']]['section'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'section', this.checked)">
                                        </div>
                                    </td>

                                    <!-- TITLE TYPE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= ucfirst($exp['title_type']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['title_type']) && $visibility[$exp['id']]['title_type'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'title_type', this.checked)">
                                        </div>
                                    </td>

                                    <!-- TITLE VALUE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($exp['title_value']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['title_value']) && $visibility[$exp['id']]['title_value'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'title_value', this.checked)">
                                        </div>
                                    </td>

                                    <!-- WORKPLACE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($exp['workplace']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['workplace']) && $visibility[$exp['id']]['workplace'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'workplace', this.checked)">
                                        </div>
                                    </td>

                                    <!-- FROM DATE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($exp['from_date']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['from_date']) && $visibility[$exp['id']]['from_date'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'from_date', this.checked)">
                                        </div>
                                    </td>

                                    <!-- TO DATE -->
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= esc($exp['to_date']) ?></span>
                                            <input class="form-check-input ms-2" type="checkbox"
                                            <?= (!empty($visibility[$exp['id']]['to_date']) && $visibility[$exp['id']]['to_date'] == 'view') ? 'checked' : '' ?>
                                            onchange="toggleExperienceVisibility(<?= $exp['id'] ?>, 'to_date', this.checked)">
                                        </div>
                                    </td>

                                    <!-- ACTIONS -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-experience/' . $exp['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-experience/' . $exp['id']) ?>"
                                           onclick="return confirm('Delete this experience?');"
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
    

