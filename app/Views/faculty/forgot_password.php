<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Forgot Password</h4>
                        <p class="card-description">Update your password</p>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-3" action="<?= base_url('faculty/forgot-password') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Email -->
                            <div class="col-12">
                                <label class="form-label">Faculty Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="Enter your registered email"
                                       required>
                            </div>

                            <!-- New Password -->
                            <div class="col-12">
                                <label class="form-label">New Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Enter new password"
                                       required>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    Update Password
                                </button>
                                <a href="<?= base_url('/') ?>" class="btn btn-light">
                                    Cancel
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
