<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Awards / Honors & Patents / Intellectual Property</h4>

                <!-- ✅ Add Achievement Button -->
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-achievement') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Achievement
                        </a>
                    </div>
                </div>

                <!-- ✅ Achievement Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Section</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Month / Year</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($achievements)): ?>
                                <?php $i = 1;
                                foreach ($achievements as $ach): ?>
                                    <tr id="ach-row-<?= $ach['id'] ?>">

                                        <td><?= $i++; ?></td>

                                        <td class="ach-content"><?= esc($ach['section']) ?></td>
                                        <td class="ach-content"><?= esc($ach['title']) ?></td>
                                        <td class="ach-content"><?= esc($ach['description']) ?></td>
                                        <td class="ach-content"><?= esc($ach['month_year']) ?></td>

                                        <!-- ✅ ONE COMMON EYE ICON -->
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-sm btn-info"
                                                id="eye-btn-<?= $ach['id'] ?>"
                                                onclick="toggleAchievementVisibility(<?= $ach['id'] ?>)">

                                                <?php if ($ach['visibility'] == 1): ?>
                                                    <i class="fas fa-eye"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-eye-slash"></i>
                                                <?php endif; ?>

                                            </button>
                                        </td>

                                        <!-- ✅ ACTIONS -->
                                        <td>
                                            <a href="<?= base_url('faculty/edit-achievement/' . $ach['id']) ?>" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="<?= base_url('faculty/delete-achievement/' . $ach['id']) ?>"
                                               onclick="return confirm('Delete this achievement?');"
                                               class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

