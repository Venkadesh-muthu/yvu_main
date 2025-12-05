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
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($education)): ?>
                                <?php $i = 1;
                                foreach ($education as $edu): ?>
                                    <tr id="edu-row-<?= $edu['id'] ?>">

                                        <td><?= $i++; ?></td>

                                        <td class="edu-content"><?= ucfirst(str_replace('_', ' ', $edu['category'])) ?></td>
                                        <td class="edu-content"><?= esc($edu['year_of_class']) ?></td>
                                        <td class="edu-content"><?= esc($edu['institute']) ?></td>
                                        <td class="edu-content"><?= esc($edu['town']) ?></td>
                                        <td class="edu-content"><?= esc($edu['district']) ?></td>
                                        <td class="edu-content"><?= esc($edu['state']) ?></td>

                                        <!-- ✅ ONE COMMON EYE ICON -->
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-sm btn-info"
                                                id="eye-btn-<?= $edu['id'] ?>"
                                                onclick="toggleEducationVisibility(<?= $edu['id'] ?>)">
                                                <?php if ($edu['visibility'] === 'view'): ?>
                                                    <i class="fas fa-eye"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-eye-slash"></i>
                                                <?php endif; ?>
                                            </button>
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
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No records found</td>
                                    </tr>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

