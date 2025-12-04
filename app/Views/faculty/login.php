<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>YVU Main</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php base_url()?>admin-template/assets/vendors/feather/feather.css" />
    <link
      rel="stylesheet"
      href="<?php base_url()?>admin-template/assets/vendors/ti-icons/css/themify-icons.css"
    />
    <link
      rel="stylesheet"
      href="<?php base_url()?>admin-template/assets/vendors/css/vendor.bundle.base.css"
    />
    <link
      rel="stylesheet"
      href="<?php base_url()?>admin-template/assets/vendors/font-awesome/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="<?php base_url()?>admin-template/assets/vendors/mdi/css/materialdesignicons.min.css"
    />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link
      rel="stylesheet"
      href="<?php base_url()?>admin-template/assets/css/style.css"
    />
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url('admin-template/assets/images/favicon.ico') ?>" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo text-center">
                        <img src="<?= base_url('admin-template/assets/images/yvu150a.gif')?>" alt="logo" />
                    </div>
                    <h4 class="text-center">YVU Login</h4>
                    <h6 class="font-weight-light text-center mt-3">Sign in to continue.</h6>

                    <!-- Error Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger text-center py-2">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <div><?= esc($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="POST" action="<?= base_url('login') ?>" class="pt-3">
                        <div class="form-group">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control form-control-lg" 
                                placeholder="Email" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control form-control-lg" 
                                placeholder="Password" 
                                required
                            >
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-block font-weight-medium auth-form-btn">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php base_url()?>admin-template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php base_url()?>admin-template/assets/js/off-canvas.js"></script>
    <script src="<?php base_url()?>admin-template/assets/js/template.js"></script>
    <script src="<?php base_url()?>admin-template/assets/js/settings.js"></script>
    <script src="<?php base_url()?>admin-template/assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
