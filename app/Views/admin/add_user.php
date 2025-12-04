<div class="main-panel">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-12"> <!-- full width on mobile, centered on desktop -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add User</h4>
                        <p class="card-description">Fill all required fields</p>

                        <form class="row g-3" action="<?= base_url('admin/addUser') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Username -->
                            <div class="col-12 col-md-6">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Name" value="<?= set_value('username') ?>">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Password -->
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password">
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- User Type -->
                            <div class="col-12 col-md-6">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-select <?= isset($validation) && $validation->hasError('user_type') ? 'is-invalid' : '' ?>" id="user_type" name="user_type">
                                    <option value="">Select Type</option>
                                    <option value="student" <?= set_select('user_type', 'student') ?>>Student</option>
                                    <option value="faculty" <?= set_select('user_type', 'faculty') ?>>Faculty</option>
                                </select>
                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('user_type') ?></div>
                                <?php endif; ?>
                            </div>


                            <!-- Department -->
                            <div class="col-12 col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" placeholder="Department" value="<?= set_value('department') ?>">
                            </div>

                            <!-- Phone -->
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= set_value('phone') ?>">
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-light">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
