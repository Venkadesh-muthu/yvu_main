<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">
                    News / Press / Pictures
                </h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-news') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add News
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
                                <th>Month & Year</th>
                                <th>Upload</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($news)): ?>
                                <?php $i = 1;
                                foreach ($news as $item): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= ucfirst(esc($item['type'])) ?></td>
                                    <td><?= esc($item['title']) ?></td>
                                    <td><?= esc($item['month_year']) ?></td>

                                    <!-- Upload -->
                                    <td class="text-center">
                                        <?php if (!empty($item['upload_path'])): ?>
                                            <a href="<?= base_url($item['upload_path']) ?>" target="_blank" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-news-<?= $item['id'] ?>"
                                            onclick="toggleNewsVisibility(<?= $item['id'] ?>)">
                                            <?php if ($item['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-news/'.$item['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-news/'.$item['id']) ?>"
                                           onclick="return confirm('Delete this record?')"
                                           class="btn btn-danger btn-sm">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

