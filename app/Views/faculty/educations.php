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
                                <th>Course</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                                <th>Marks</th>
                                <th>Highlights</th>
                                <th>Year</th>
                                <th>Class</th>
                                <th>University</th>
                                <th>Institute</th>
                                <th>Country</th>
                                <th>Town</th>
                                <th>District</th>
                                <th>State</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($education)): ?>
                                <?php $i = 1;
                                foreach ($education as $edu): ?>
                                    <tr id="edu-row-<?= $edu['id'] ?>">

                                        <td><?= $i++; ?></td>

                                        <td><?= ucfirst(str_replace('_', ' ', esc($edu['category']))) ?></td>
                                        <td><?= esc($edu['course_subject']) ?></td>
                                        <!-- VISIBILITY -->
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
                                            <a href="<?= base_url('faculty/edit-education/' . $edu['id']) ?>"
                                            class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="<?= base_url('faculty/delete-education/' . $edu['id']) ?>"
                                            onclick="return confirm('Delete this education?');"
                                            class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                        <td><?= esc($edu['marks_division']) ?></td>
                                        <td><?= esc($edu['highlights_comments_merits']) ?></td>
                                        <td><?= esc($edu['year']) ?></td>
                                        <td><?= esc($edu['class']) ?></td>
                                        <td><?= esc($edu['university']) ?></td>
                                        <td><?= esc($edu['institute']) ?></td>
                                        <td><?= esc($edu['country']) ?></td>
                                        <td><?= esc($edu['town']) ?></td>
                                        <td><?= esc($edu['district']) ?></td>
                                        <td><?= esc($edu['state']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="14" class="text-center text-muted">
                                        No education records found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

