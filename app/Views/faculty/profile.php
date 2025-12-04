<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Faculty Profile</h4>
                    <?php $facultyname = session()->get('faculty_name'); ?>
                    <h3 ><?= $facultyname; ?></h3>

                <!-- Last Updated -->
                <?php if (!empty($profile['updated_at'])): ?>
                    <p class="card-description">Last updated: <?= date('d M Y', strtotime($profile['updated_at'])) ?></p>
                <?php endif; ?>

                <!-- Add Profile Button -->
                <?php if (empty($profile)): ?>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <a href="<?= base_url('faculty/add-profile') ?>" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> Add Profile Details
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

                <!-- Profile Table (same design as list page) -->
                <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($profile)): ?>
                        <tr>
                            <td>1</td>

                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile['name']) ?></span>
                                    <input class="form-check-input ms-2" type="checkbox"
                                        id="name_checkbox"
                                        <?= (!empty($visibility['name']) && $visibility['name'] === 'view') ? 'checked' : '' ?>
                                        onchange="toggleVisibility('name', this.checked)">
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile['designation'] ?: '-') ?></span>
                                    <input class="form-check-input ms-2" type="checkbox"
                                        id="designation_checkbox"
                                        <?= (!empty($visibility['designation']) && $visibility['designation'] === 'view') ? 'checked' : '' ?>
                                        onchange="toggleVisibility('designation', this.checked)">
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile['department'] ?: '-') ?></span>
                                    <input class="form-check-input ms-2" type="checkbox"
                                        id="department_checkbox"
                                        <?= (!empty($visibility['department']) && $visibility['department'] === 'view') ? 'checked' : '' ?>
                                        onchange="toggleVisibility('department', this.checked)">
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile['phone_no'] ?: '-') ?></span>
                                    <input class="form-check-input ms-2" type="checkbox"
                                        id="phone_no_checkbox"
                                        <?= (!empty($visibility['phone_no']) && $visibility['phone_no'] === 'view') ? 'checked' : '' ?>
                                        onchange="toggleVisibility('phone_no', this.checked)">
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile['email_official'] ?: '-') ?></span>
                                    <input class="form-check-input ms-2" type="checkbox"
                                        id="email_official_checkbox"
                                        <?= (!empty($visibility['email_official']) && $visibility['email_official'] === 'view') ? 'checked' : '' ?>
                                        onchange="toggleVisibility('email_official', this.checked)">
                                </div>
                            </td>

                            <td>
                                <a href="<?= base_url('faculty/edit-profile/' . $profile['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= base_url('faculty/delete-profile/' . $profile['id']) ?>"
                                onclick="return confirm('Delete this profile?');"
                                class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>

                    <?php endif; ?>
                    </tbody>
                </table>

                </div>

                <!-- Show personal details only if profile exists -->
                <?php if (!empty($profile)): ?>

                    <h5 class="mt-4">Personal Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Photo</th>
                            <td>
                                <?php if (!empty($profile['photo'])): ?>
                                    <img src="<?= base_url('uploads/faculty/' . $profile['photo']) ?>" width="100">
                                <?php else: ?> - <?php endif; ?>
                            </td>
                        </tr>

                        <?php
                        $fields = [
                            'employee_id' => 'Employee ID',
                            'cfms_no' => 'CFMS No',
                            'dob' => 'DoB',
                            'gender' => 'Gender',
                            'religion' => 'Religion',
                            'caste' => 'Caste',
                            'reservation' => 'Reservation',
                            'address_residential' => 'Residential Address',
                            'address_office' => 'Office Address',
                            'phone_no' => 'Phone',
                            'email_official' => 'Email',
                            'aadhaar_no' => 'Aadhaar No',
                            'blood_group' => 'Blood Group',
                            'place_of_birth' => 'Place of Birth'
                        ];

                    foreach ($fields as $field_key => $field_label): ?>
                            <tr>
                                <th><?= $field_label ?></th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span><?= esc($profile[$field_key] ?: '-') ?></span>

                                    <div class="form-check mb-0 ms-3">
                                        <input class="form-check-input" type="checkbox" 
                                            id="<?= $field_key ?>_checkbox"
                                            <?= (!empty($visibility[$field_key]) && $visibility[$field_key] === 'view') ? 'checked' : '' ?>
                                            onchange="toggleVisibility('<?= $field_key ?>', this.checked)">
                                        <label class="form-check-label" for="<?= $field_key ?>_checkbox">
                                            Show
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <h5 class="mt-4">Research Profile Links</h5>
                    <?php
                    $researchLinks = [
                        'vidwan_url'          => 'VIDWAN',
                        'orcid_url'           => 'ORCID',
                        'scopus_url'          => 'SCOPUS',
                        'google_scholar_url'  => 'Google Scholar'
                    ];
                    ?>

                    <table class="table table-bordered">
                        <?php foreach ($researchLinks as $field_key => $field_label): ?>
                            <tr>
                                <th><?= $field_label ?></th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <?php if (!empty($profile[$field_key])): ?>
                                        <a href="<?= esc($profile[$field_key]) ?>" target="_blank" class="btn btn-sm btn-primary me-3">View</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>

                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" 
                                            id="<?= $field_key ?>_checkbox"
                                            <?= (!empty($visibility[$field_key]) && $visibility[$field_key] === 'view') ? 'checked' : '' ?>
                                            onchange="toggleVisibility('<?= $field_key ?>', this.checked)">
                                        <label class="form-check-label" for="<?= $field_key ?>_checkbox">
                                            Show
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php endif; ?>
            </div>
        </div>

