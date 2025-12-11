<div class="main-panel">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit User</h4>
                        <p class="card-description">Update required fields</p>

                        <form class="row g-3" action="<?= base_url('admin/editUser/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Name -->
                            <div class="col-12 col-md-6">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" 
                                       class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>"
                                       id="username"
                                       name="username"
                                       value="<?= set_value('username', $user['username']) ?>">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>"
                                       id="email"
                                       name="email"
                                       value="<?= set_value('email', $user['email']) ?>">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Password (Optional) -->
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label">Password (Leave blank to keep old)</label>
                                <input type="password"
                                       class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                       id="password"
                                       name="password">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- User Type -->
                            <div class="col-12 col-md-6">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-select <?= isset($validation) && $validation->hasError('user_type') ? 'is-invalid' : '' ?>"
                                        id="user_type"
                                        name="user_type">

                                    <option value="">Select Type</option>

                                    <option value="student" 
                                        <?= set_select('user_type', 'student', $user['user_type'] == 'student') ?>>
                                        Student
                                    </option>

                                    <option value="faculty" 
                                        <?= set_select('user_type', 'faculty', $user['user_type'] == 'faculty') ?>>
                                        Faculty
                                    </option>

                                    <option value="admin" 
                                        <?= set_select('user_type', 'admin', $user['user_type'] == 'admin') ?>>
                                        Admin
                                    </option>

                                </select>
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('user_type') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Department -->
                            <div class="col-12 col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" 
                                       class="form-control"
                                       id="department"
                                       name="department"
                                       value="<?= set_value('department', $user['department']) ?>">
                            </div>

                            <!-- Phone -->
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text"
                                       class="form-control"
                                       id="phone"
                                       name="phone"
                                       value="<?= set_value('phone', $user['phone']) ?>">
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

