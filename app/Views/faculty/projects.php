<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Projects</h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-project') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Project
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
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
                            <?php if (!empty($projects)): ?>
                                <?php $i = 1;
                                foreach ($projects as $project): ?>
                                <tr>
                                    <td><?= $i++ ?></td>

                                    <td><?= esc($project['title']) ?></td>
                                    <td><?= esc($project['agency']) ?></td>
                                    <td><?= esc($project['from_year']) ?></td>
                                    <td><?= esc($project['to_year']) ?></td>

                                    <td class="text-center">
                                        <?php if (!empty($project['upload_path'])): ?>
                                            <a href="<?= base_url($project['upload_path']) ?>" target="_blank" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-project-<?= $project['id'] ?>"
                                            onclick="toggleProjectVisibility(<?= $project['id'] ?>)">
                                            <?php if ($project['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-project/'.$project['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <a href="<?= base_url('faculty/delete-project/'.$project['id']) ?>"
                                           onclick="return confirm('Delete this project?')"
                                           class="btn btn-danger btn-sm">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>