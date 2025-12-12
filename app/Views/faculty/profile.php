<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Faculty Profile</h4>
                <?php $facultyname = session()->get('faculty_name'); ?>
                <h3><?= $facultyname; ?></h3>

                <!-- Last Updated -->
                <?php if (!empty($profile['updated_at'])): ?>
                    <p class="card-description">Last updated: <?= date('d M Y', strtotime($profile['updated_at'])) ?></p>
                <?php endif; ?>

                <!-- TOP BUTTONS -->
                <div class="row mb-3">
                    <div class="col-12 text-end">

                        <!-- Add Profile (when empty) -->
                        <?php if (empty($profile)): ?>
                            <a href="<?= base_url('faculty/add-profile') ?>" class="btn btn-success btn-sm me-2">
                                <i class="bi bi-plus-circle"></i> Add Profile Details
                            </a>
                        <?php endif; ?>

                        <!-- Edit/Delete when profile exists -->
                        <?php if (!empty($profile)): ?>
                            <a href="<?= base_url('faculty/edit-profile/' . $profile['id']) ?>" 
                               class="btn btn-warning btn-sm me-2">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </a>

                            <a href="<?= base_url('faculty/delete-profile/' . $profile['id']) ?>"
                               onclick="return confirm('Delete this profile?');"
                               class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete Profile
                            </a>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- PHOTO ROW -->
                <?php if (!empty($profile['photo'])): ?>
                <div class="mb-4 text-center">
                    <img src="<?= base_url('uploads/faculty/' . $profile['photo']) ?>" width="150" class="img-thumbnail">
                    <div class="mt-2">
                        <?php $status = !empty($visibility['photo']) ? $visibility['photo'] : 'hide'; ?>
                        <button type="button" class="btn btn-sm btn-info"
                                id="photo_eye"
                                onclick="toggleVisibility('photo')"
                                data-status="<?= $status ?>"
                                title="<?= $status === 'view' ? 'Hide' : 'Show' ?>">
                            <i class="fas <?= $status === 'view' ? 'fa-eye' : 'fa-eye-slash' ?>"></i> Photo
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- MAIN PROFILE FIELDS TABLE -->
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Field</th>
                                <th>Value</th>
                                <th>Visibility</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($profile)): ?>
                                <?php
                                $fields = [
                                    'name' => 'Name',
                                    'about_me' => 'About Me',
                                    'designation' => 'Designation',
                                    'department' => 'Department',
                                    'phone_no' => 'Phone',
                                    'email_official' => 'Email',
                                    'employee_id' => 'Employee ID',
                                    'cfms_no' => 'CFMS No',
                                    'dob' => 'Date of Birth',
                                    'gender' => 'Gender',
                                    'religion' => 'Religion',
                                    'caste' => 'Caste',
                                    'reservation' => 'Reservation',
                                    'address_residential' => 'Residential Address',
                                    'address_office' => 'Office Address',
                                    'aadhaar_no' => 'Aadhaar No',
                                    'blood_group' => 'Blood Group',
                                    'place_of_birth' => 'Place of Birth'
                                ];
                                $i = 1;
                                ?>

                                <?php foreach ($fields as $key => $label): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $label ?></td>
                                        <td><?= esc($profile[$key] ?: '-') ?></td>
                                        <td>
                                            <?php $status = !empty($visibility[$key]) ? $visibility[$key] : 'hide'; ?>
                                            <button type="button" class="btn btn-sm btn-info"
                                                    id="<?= $key ?>_eye"
                                                    onclick="toggleVisibility('<?= $key ?>')"
                                                    data-status="<?= $status ?>"
                                                    title="<?= $status === 'view' ? 'Hide' : 'Show' ?>">
                                                <i class="fas <?= $status === 'view' ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- RESEARCH PROFILE LINKS TABLE -->
                <h5 class="mt-4">Research Profile Links</h5>
                <?php
                $researchLinks = [
                    'vidwan_url' => 'VIDWAN',
                    'orcid_url' => 'ORCID',
                    'scopus_url' => 'SCOPUS',
                    'google_scholar_url' => 'Google Scholar'
                ];
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Platform</th>
                                <th>Link</th>
                                <th>Visibility</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($researchLinks as $key => $label): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $label ?></td>
                                    <td>
                                        <?php if (!empty($profile[$key])): ?>
                                            <a href="<?= esc($profile[$key]) ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $status = !empty($visibility[$key]) ? $visibility[$key] : 'hide'; ?>
                                        <button type="button" class="btn btn-sm btn-info"
                                                id="<?= $key ?>_eye"
                                                onclick="toggleVisibility('<?= $key ?>')"
                                                data-status="<?= $status ?>"
                                                title="<?= $status === 'view' ? 'Hide' : 'Show' ?>">
                                            <i class="fas <?= $status === 'view' ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- END RESEARCH LINKS TABLE -->

            </div>
        </div>

    </div>
</div>
