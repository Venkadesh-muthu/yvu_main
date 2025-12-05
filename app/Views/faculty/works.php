<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Publications / Books / Editorial Activities</h4>

                <!-- ✅ Add Work Button -->
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-work') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Work
                        </a>
                    </div>
                </div>

                <!-- ✅ Work Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Role</th>
                                <th>Journal / Publisher</th>
                                <th>Type (Intl./National/Local)</th>
                                <th>Month / Year</th>
                                <th>ISBN/ISSN</th>
                                <th>URL</th>
                                <th>PDF</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($works)): ?>
                                <?php $i = 1;
                                foreach ($works as $work): ?>
                                    <tr id="work-row-<?= $work['id'] ?>">

                                        <td><?= $i++; ?></td>
                                        <td><?= esc($work['category']) ?></td>
                                        <td><?= esc($work['title']) ?></td>
                                        <td><?= esc($work['role']) ?></td>
                                        <td><?= esc($work['journal']) ?></td>
                                        <td><?= esc($work['type']) ?></td>
                                        <td><?= esc($work['month_year']) ?></td>
                                        <td><?= esc($work['isbn_issn']) ?></td>

                                        <!-- ✅ URL Column -->
                                        <td>
                                            <?php if ($work['url']): ?>
                                                <a href="<?= esc($work['url']) ?>" target="_blank">Visit</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <!-- ✅ PDF Column -->
                                        <td>
                                            <?php if ($work['pdf_path']): ?>
                                                <a href="<?= base_url($work['pdf_path']) ?>" target="_blank">View PDF</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <!-- ✅ Visibility -->
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-sm btn-info"
                                                id="eye-btn-<?= $work['id'] ?>"
                                                onclick="toggleWorkVisibility(<?= $work['id'] ?>)">
                                                <?php if ($work['visibility'] == 'view'): ?>
                                                    <i class="fas fa-eye"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-eye-slash"></i>
                                                <?php endif; ?>
                                            </button>
                                        </td>

                                        <!-- ✅ Actions -->
                                        <td>
                                            <a href="<?= base_url('faculty/edit-work/' . $work['id']) ?>" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="<?= base_url('faculty/delete-work/' . $work['id']) ?>"
                                               onclick="return confirm('Delete this work?');"
                                               class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="12" class="text-center text-muted">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
   
