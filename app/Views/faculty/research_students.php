<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">students</h4>
                <p class="card-description">List of all students associated with you</p>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-research-student') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Student
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student Type</th>
                                <th>Student Name</th>
                                <th>Topic / Title</th>
                                <th>Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th class="text-center">Visibility</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($researchStudents)): ?>
                                <?php $i = 1;
                                foreach ($researchStudents as $row): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['student_type']) ?></td>
                                    <td><?= esc($row['student_name']) ?></td>
                                    <td><?= esc($row['topic_title']) ?></td>
                                    <td><?= esc($row['type']) ?></td>
                                    <td><?= esc($row['from_year']) ?></td>
                                    <td><?= esc($row['to_year']) ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'completed'): ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Ongoing</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-research-<?= $row['id'] ?>"
                                            onclick="toggleResearchStudentVisibility(<?= $row['id'] ?>)">
                                            <?php if ($row['visibility'] === 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <a href="<?= base_url('faculty/edit-research-student/'.$row['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="<?= base_url('faculty/delete-research-student/'.$row['id']) ?>"
                                           onclick="return confirm('Are you sure you want to delete this research student?')"
                                           class="btn btn-danger btn-sm">
                                           <i class="bi bi-trash"></i> Delete
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