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
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($experience)): ?>
                            <?php $i = 1;
                            foreach ($experience as $exp): ?>
                                <tr id="exp-row-<?= $exp['id'] ?>">
                                    <td><?= $i++; ?></td>
                                    <td><?= ucfirst($exp['section']) ?></td>
                                    <td><?= ucfirst($exp['title_type']) ?></td>
                                    <td><?= esc($exp['title_value']) ?></td>
                                    <td><?= esc($exp['workplace']) ?></td>
                                    <td><?= esc($exp['from_date']) ?></td>
                                    <td><?= esc($exp['to_date']) ?></td>

                                    <!-- ✅ Visibility Eye Button -->
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-info"
                                                id="eye-btn-exp-<?= $exp['id'] ?>"
                                                onclick="toggleExperienceVisibility(<?= $exp['id'] ?>)">
                                            <?php if ($exp['visibility'] === 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
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
    

