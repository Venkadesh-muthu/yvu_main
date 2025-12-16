<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">
                    Social Media
                </h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-social-media') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Social Media
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Instagram</th>
                                <th>WhatsApp</th>
                                <th>Facebook</th>
                                <th>Twitter</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($socialMedia)): ?>
                                <?php $i = 1;
                                foreach ($socialMedia as $item): ?>
                                <tr>
                                    <td><?= $i++ ?></td>

                                    <td>
                                        <?php if (!empty($item['instagram_link'])): ?>
                                            <a href="<?= esc($item['instagram_link']) ?>" target="_blank">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($item['whatsapp_link'])): ?>
                                            <a href="<?= esc($item['whatsapp_link']) ?>" target="_blank">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($item['facebook_link'])): ?>
                                            <a href="<?= esc($item['facebook_link']) ?>" target="_blank">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($item['twitter_link'])): ?>
                                            <a href="<?= esc($item['twitter_link']) ?>" target="_blank">
                                                View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-social-<?= $item['id'] ?>"
                                            onclick="toggleSocialVisibility(<?= $item['id'] ?>)">
                                            <?php if ($item['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-social-media/'.$item['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="<?= base_url('faculty/delete-social-media/'.$item['id']) ?>"
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
