<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">
                    Information
                </h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-information') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Information
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Agency</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Upload</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($information)): ?>
                                <?php $i = 1;
                                foreach ($information as $info): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?= ucfirst(str_replace('_', ' ', esc($info['type']))) ?>
                                    </td>
                                    <td><?= esc($info['title']) ?></td>
                                    <td><?= esc($info['agency']) ?></td>
                                    <td><?= esc($info['from_year']) ?></td>
                                    <td><?= esc($info['to_year']) ?></td>

                                    <!-- Upload -->
                                    <td class="text-center">
                                        <?php if (!empty($info['upload_path'])): ?>
                                            <a href="<?= base_url($info['upload_path']) ?>" target="_blank" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ✅ Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-info-<?= $info['id'] ?>"
                                            onclick="toggleInformationVisibility(<?= $info['id'] ?>)">
                                            <?php if ($info['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- ✅ Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-information/'.$info['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-information/'.$info['id']) ?>"
                                           onclick="return confirm('Delete this record?')"
                                           class="btn btn-danger btn-sm">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
