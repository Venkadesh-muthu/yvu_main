<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Workshops / Talks / Memberships / Training</h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-activity') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Activity
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Month & Year</th>
                                <th>Role</th>
                                <th>Location</th>
                                <th>Certificate</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($activities)): ?>
                                <?php $i = 1;
                                foreach ($activities as $activity): ?>
                                <tr>
                                    <td><?= $i++ ?></td>

                                    <td><?= esc(ucfirst($activity['category'])) ?></td>

                                    <td><?= esc($activity['title']) ?></td>

                                    <td><?= esc($activity['type']) ?></td>

                                    <td><?= esc($activity['month_year']) ?></td>

                                    <td><?= esc($activity['attended_or_role']) ?></td>

                                    <td><?= esc($activity['location']) ?></td>

                                    <td class="text-center">
                                        <?php if (!empty($activity['certificate_path'])): ?>
                                            <a href="<?= base_url($activity['certificate_path']) ?>" target="_blank" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ✅ Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-activity-<?= $activity['id'] ?>"
                                            onclick="toggleActivityVisibility(<?= $activity['id'] ?>)">
                                            <?php if ($activity['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- ✅ Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-activity/'.$activity['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-activity/'.$activity['id']) ?>"
                                           onclick="return confirm('Delete this activity?')"
                                           class="btn btn-danger btn-sm">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
