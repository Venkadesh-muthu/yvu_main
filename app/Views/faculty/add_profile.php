<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Faculty Profile</h4>
                        <p class="card-description">Fill all required profile details</p>

                        <form class="row g-3" action="<?= base_url('faculty/save-profile') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Name -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Full Name" value="<?= set_value('name') ?>" required>
                            </div>
                            
                            <!-- About Me -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">About Me</label>
                                <textarea class="form-control" name="about_me" placeholder="Write something about yourself" rows="4"><?= set_value('about_me') ?></textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="photo">
                            </div>

                            <!-- Designation -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" name="designation" placeholder="Designation" value="<?= set_value('designation') ?>">
                            </div>

                            <!-- Department -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" name="department" placeholder="Department" value="<?= set_value('department') ?>">
                            </div>

                            <!-- Employee ID -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="employee_id" placeholder="Employee ID" value="<?= set_value('employee_id') ?>">
                            </div>

                            <!-- CFMS No -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">CFMS No</label>
                                <input type="text" class="form-control" name="cfms_no" placeholder="CFMS Number" value="<?= set_value('cfms_no') ?>">
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="<?= set_value('dob') ?>">
                            </div>

                            <!-- Gender -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select</option>
                                    <option value="Male" <?= set_select('gender', 'Male') ?>>Male</option>
                                    <option value="Female" <?= set_select('gender', 'Female') ?>>Female</option>
                                    <option value="Other" <?= set_select('gender', 'Other') ?>>Other</option>
                                </select>
                            </div>

                            <!-- Religion -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion" placeholder="Religion" value="<?= set_value('religion') ?>">
                            </div>

                            <!-- Caste -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Caste</label>
                                <input type="text" class="form-control" name="caste" placeholder="Caste" value="<?= set_value('caste') ?>">
                            </div>

                            <!-- Reservation -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Reservation</label>
                                <input type="text" class="form-control" name="reservation" placeholder="Reservation Category" value="<?= set_value('reservation') ?>">
                            </div>

                            <!-- Residential Address -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Residential Address</label>
                                <textarea class="form-control" name="address_residential" rows="2"><?= set_value('address_residential') ?></textarea>
                            </div>

                            <!-- Office Address -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Office Address</label>
                                <textarea class="form-control" name="address_office" rows="2"><?= set_value('address_office') ?></textarea>
                            </div>

                            <!-- Phone -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Phone No</label>
                                <input type="text" class="form-control" name="phone_no" placeholder="Phone" value="<?= set_value('phone_no') ?>">
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Official Email</label>
                                <input type="email" class="form-control" name="email_official" placeholder="Enter full email" value="<?= set_value('email_official') ?>">
                            </div>

                            <!-- Aadhaar -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Aadhaar No</label>
                                <input type="text" class="form-control" name="aadhaar_no" placeholder="Aadhaar No" value="<?= set_value('aadhaar_no') ?>">
                            </div>

                            <!-- Blood Group -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-control" name="blood_group" placeholder="Blood Group" value="<?= set_value('blood_group') ?>">
                            </div>

                            <!-- Place of Birth -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Place of Birth</label>
                                <input type="text" class="form-control" name="place_of_birth" placeholder="Place of Birth" value="<?= set_value('place_of_birth') ?>">
                            </div>

                            <!-- Research Links -->
                            <div class="col-12">
                                <h5 class="mt-3">Research Profile Links</h5>
                                <hr>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">VIDWAN</label>
                                <input type="url" class="form-control" name="vidwan_url" placeholder="VIDWAN Profile Link" value="<?= set_value('vidwan_url') ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">ORCID</label>
                                <input type="url" class="form-control" name="orcid_url" placeholder="ORCID Profile Link" value="<?= set_value('orcid_url') ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">SCOPUS</label>
                                <input type="url" class="form-control" name="scopus_url" placeholder="SCOPUS Profile Link" value="<?= set_value('scopus_url') ?>">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Google Scholar</label>
                                <input type="url" class="form-control" name="google_scholar_url" placeholder="Google Scholar Link" value="<?= set_value('google_scholar_url') ?>">
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="<?= base_url('faculty/profile') ?>" class="btn btn-light">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    
