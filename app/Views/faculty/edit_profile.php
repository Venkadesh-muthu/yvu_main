<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Faculty Profile</h4>
                        <p class="card-description">Update your profile details</p>

                        <form class="row g-3" 
                              action="<?= base_url('faculty/update-profile/' . $profile['id']) ?>" 
                              method="post" 
                              enctype="multipart/form-data">

                            <?= csrf_field() ?>

                            <!-- Name -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name"
                                       value="<?= esc($profile['name']) ?>" required>
                            </div>
                            
                            <!-- About Me -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">About Me</label>
                                <textarea class="form-control" name="about_me" rows="8" placeholder="Write something about yourself"><?= esc($profile['about_me']) ?></textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="photo">

                                <?php if (!empty($profile['photo'])): ?>
                                    <img src="<?= base_url('uploads/faculty/' . $profile['photo']) ?>"
                                         width="80" class="mt-2 rounded">
                                <?php endif; ?>
                            </div>

                            <!-- Designation -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">
                                    Designation <span class="text-danger">*</span>
                                </label>
                                <select name="designation" class="form-control" required>
                                    <option value="">-- Select Designation --</option>

                                    <option value="Professor"
                                        <?= ($profile['designation'] === 'Professor') ? 'selected' : '' ?>>
                                        Professor
                                    </option>

                                    <option value="Associate Professor"
                                        <?= ($profile['designation'] === 'Associate Professor') ? 'selected' : '' ?>>
                                        Associate Professor
                                    </option>

                                    <option value="Assistant Professor"
                                        <?= ($profile['designation'] === 'Assistant Professor') ? 'selected' : '' ?>>
                                        Assistant Professor
                                    </option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">
                                    Effective Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control"
                                    name="effective_date"
                                    value="<?= esc($profile['effective_date'] ?? '') ?>"
                                    required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">
                                    Join Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                    class="form-control"
                                    name="join_date"
                                    value="<?= esc($profile['join_date'] ?? '') ?>"
                                    required>
                            </div>


                            <!-- Department -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" name="department"
                                       value="<?= esc($profile['department']) ?>">
                            </div>

                            <!-- Employee ID -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="employee_id"
                                       value="<?= esc($profile['employee_id']) ?>">
                            </div>

                            <!-- CFMS No -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">CFMS No</label>
                                <input type="text" class="form-control" name="cfms_no"
                                       value="<?= esc($profile['cfms_no']) ?>">
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob"
                                       value="<?= esc($profile['dob']) ?>">
                            </div>

                            <!-- Gender -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select</option>
                                    <option value="Male" <?= ($profile['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= ($profile['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= ($profile['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <!-- Religion -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion"
                                       value="<?= esc($profile['religion']) ?>">
                            </div>

                            <!-- Caste -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Caste</label>
                                <input type="text" class="form-control" name="caste"
                                       value="<?= esc($profile['caste']) ?>">
                            </div>

                            <!-- Reservation -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Reservation</label>
                                <input type="text" class="form-control" name="reservation"
                                       value="<?= esc($profile['reservation']) ?>">
                            </div>

                            <!-- Residential Address -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Residential Address</label>
                                <textarea class="form-control" name="address_residential" rows="2"><?= esc($profile['address_residential']) ?></textarea>
                            </div>

                            <!-- Office Address -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Office Address</label>
                                <textarea class="form-control" name="address_office" rows="2"><?= esc($profile['address_office']) ?></textarea>
                            </div>

                            <!-- Phone -->
                            <?php
                            $phones = (!empty($phones)) ? $phones : [''];
                              ?>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Phone No</label>

                                <div id="phone-wrapper">
                                    <?php foreach ($phones as $index => $phone): ?>
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                class="form-control"
                                                name="phone_no[]"
                                                value="<?= esc($phone) ?>"
                                                placeholder="Phone Number">

                                            <?php if ($index === 0): ?>
                                                <button type="button" class="btn btn-success" onclick="addPhone()">+</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-danger" onclick="removeField(this)">−</button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>



                            <!-- Email -->
                            <?php
                            $emails = (!empty($emails)) ? $emails : [''];
                              ?>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Email</label>

                                <div id="email-wrapper">
                                    <?php foreach ($emails as $index => $email): ?>
                                        <div class="input-group mb-2">
                                            <input type="email"
                                                class="form-control"
                                                name="email_official[]"
                                                value="<?= esc($email) ?>"
                                                placeholder="Email">

                                            <?php if ($index === 0): ?>
                                                <button type="button" class="btn btn-success" onclick="addEmail()">+</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-danger" onclick="removeField(this)">−</button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>



                            <!-- Aadhaar -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Aadhaar No</label>
                                <input type="text" class="form-control" name="aadhaar_no"
                                       value="<?= esc($profile['aadhaar_no']) ?>">
                            </div>

                            <!-- Blood Group -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-control" name="blood_group"
                                       value="<?= esc($profile['blood_group']) ?>">
                            </div>

                            <!-- Place of Birth -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Place of Birth</label>
                                <input type="text" class="form-control" name="place_of_birth"
                                       value="<?= esc($profile['place_of_birth']) ?>">
                            </div>

                            <!-- Research Links -->
                            <div class="col-12">
                                <h5 class="mt-3">Research Profile Links</h5>
                                <hr>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">VIDWAN</label>
                                <input type="url" class="form-control" name="vidwan_url"
                                       value="<?= esc($profile['vidwan_url']) ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">ORCID</label>
                                <input type="url" class="form-control" name="orcid_url"
                                       value="<?= esc($profile['orcid_url']) ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">SCOPUS</label>
                                <input type="url" class="form-control" name="scopus_url"
                                       value="<?= esc($profile['scopus_url']) ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Google Scholar</label>
                                <input type="url" class="form-control" name="google_scholar_url"
                                       value="<?= esc($profile['google_scholar_url']) ?>">
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="<?= base_url('faculty/profile') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<script>
function addPhone() {
    document.getElementById('phone-wrapper').insertAdjacentHTML(
        'beforeend',
        `<div class="input-group mb-2">
            <input type="text" class="form-control" name="phone_no[]" placeholder="Phone Number">
            <button type="button" class="btn btn-danger" onclick="removeField(this)">−</button>
        </div>`
    );
}

function addEmail() {
    document.getElementById('email-wrapper').insertAdjacentHTML(
        'beforeend',
        `<div class="input-group mb-2">
            <input type="email" class="form-control" name="email_official[]" placeholder="Email">
            <button type="button" class="btn btn-danger" onclick="removeField(this)">−</button>
        </div>`
    );
}

function removeField(btn) {
    btn.closest('.input-group').remove();
}
</script>
