<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Skills / Specialisation / Research Areas</h4>

                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('faculty/add-skill') ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Skill
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Visibility</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($skills)): ?>
                                <?php $i = 1;
                                foreach ($skills as $skill): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($skill['skill_value']) ?></td>

                                    <!-- Visibility Toggle -->
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            id="eye-btn-skill-<?= $skill['id'] ?>"
                                            onclick="toggleSkillVisibility(<?= $skill['id'] ?>)">
                                            <?php if ($skill['visibility'] == 'view'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash"></i>
                                            <?php endif; ?>
                                        </button>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= base_url('faculty/edit-skill/'.$skill['id']) ?>" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <a href="<?= base_url('faculty/delete-skill/'.$skill['id']) ?>"
                                           onclick="return confirm('Delete this skill?')" class="btn btn-danger btn-sm">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Records Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

   