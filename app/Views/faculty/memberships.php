<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Memberships</h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-membership') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Membership
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
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($memberships)): ?>
                            <?php $i = 1;
                            foreach ($memberships as $row): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['category']) ?></td>
                                    <td><?= esc($row['title']) ?></td>

                                    <!-- Visibility -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-membership-<?= $row['id'] ?>"
                                            onclick="toggleMembershipVisibility(<?= $row['id'] ?>)">
                                            <?php if ($row['visibility'] === 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-membership/'.$row['id']) ?>"
                                           class="btn btn-warning btn-sm">Edit</a>

                                        <a href="<?= base_url('faculty/delete-membership/'.$row['id']) ?>"
                                           onclick="return confirm('Delete this membership?')"
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No Records Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
