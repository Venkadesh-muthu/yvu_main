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
                                <select class="form-select <?= isset($validation) && $validation->hasError('user_type') ? 'is-invalid' : '' ?>" 
                                        id="user_type" 
                                        name="user_type">

                                    <option value="">Select Type</option>

                                    <option value="student" <?= set_select('user_type', 'student') ?>>Student</option>

                                    <option value="faculty" <?= set_select('user_type', 'faculty') ?>>Faculty</option>

                                    <option value="admin" <?= set_select('user_type', 'admin') ?>>Admin</option>

                                </select>

                                <?php if (isset($validation)): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('user_type') ?></div>
                                <?php endif; ?>
                            </div>


                            <!-- Department -->
                           <div class="col-12 col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-control" id="department" name="department">
                                    <option value="">Select Department</option>
                                    <option value="Applied Mathematics" <?= set_select('department', 'Applied Mathematics') ?>>Applied Mathematics</option>
                                    <option value="Biochemistry" <?= set_select('department', 'Biochemistry') ?>>Biochemistry</option>
                                    <option value="Biotechnology" <?= set_select('department', 'Biotechnology') ?>>Biotechnology</option>
                                    <option value="Biotechnology & Bioinformatics" <?= set_select('department', 'Biotechnology & Bioinformatics') ?>>Biotechnology & Bioinformatics</option>
                                    <option value="Botany" <?= set_select('department', 'Botany') ?>>Botany</option>
                                    <option value="Business Management" <?= set_select('department', 'Business Management') ?>>Business Management</option>
                                    <option value="Chemistry" <?= set_select('department', 'Chemistry') ?>>Chemistry</option>
                                    <option value="Commerce" <?= set_select('department', 'Commerce') ?>>Commerce</option>
                                    <option value="Computer Science & Technology" <?= set_select('department', 'Computer Science & Technology') ?>>Computer Science & Technology</option>
                                    <option value="Earth Sciences" <?= set_select('department', 'Earth Sciences') ?>>Earth Sciences</option>
                                    <option value="Economics" <?= set_select('department', 'Economics') ?>>Economics</option>
                                    <option value="English" <?= set_select('department', 'English') ?>>English</option>
                                    <option value="Environmental Sciences" <?= set_select('department', 'Environmental Sciences') ?>>Environmental Sciences</option>
                                    <option value="Fine Arts" <?= set_select('department', 'Fine Arts') ?>>Fine Arts</option>
                                    <option value="Food Technology" <?= set_select('department', 'Food Technology') ?>>Food Technology</option>
                                    <option value="Genetics & Genomics" <?= set_select('department', 'Genetics & Genomics') ?>>Genetics & Genomics</option>
                                    <option value="Geology" <?= set_select('department', 'Geology') ?>>Geology</option>
                                    <option value="History & Archaeology" <?= set_select('department', 'History & Archaeology') ?>>History & Archaeology</option>
                                    <option value="Journalism & Communication" <?= set_select('department', 'Journalism & Communication') ?>>Journalism & Communication</option>
                                    <option value="Material Science & Nanotechnology" <?= set_select('department', 'Material Science & Nanotechnology') ?>>Material Science & Nanotechnology</option>
                                    <option value="Microbiology" <?= set_select('department', 'Microbiology') ?>>Microbiology</option>
                                    <option value="Physics" <?= set_select('department', 'Physics') ?>>Physics</option>
                                    <option value="Physical Education and Sports Sciences" <?= set_select('department', 'Physical Education and Sports Sciences') ?>>Physical Education and Sports Sciences</option>
                                    <option value="Political Science & Public Administration" <?= set_select('department', 'Political Science & Public Administration') ?>>Political Science & Public Administration</option>
                                    <option value="Psychology" <?= set_select('department', 'Psychology') ?>>Psychology</option>
                                    <option value="Telugu" <?= set_select('department', 'Telugu') ?>>Telugu</option>
                                    <option value="Urdu" <?= set_select('department', 'Urdu') ?>>Urdu</option>
                                    <option value="Zoology" <?= set_select('department', 'Zoology') ?>>Zoology</option>
                                    <option value="Computational Data Science" <?= set_select('department', 'Computational Data Science') ?>>Computational Data Science</option>
                                </select>
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
