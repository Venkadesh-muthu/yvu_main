<?php helper('captcha'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YVU Main Login</title>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/vendors/feather/feather.css') ?>">
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/vendors/ti-icons/css/themify-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/vendors/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/vendors/mdi/css/materialdesignicons.min.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('admin-template/assets/css/style.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('admin-template/assets/images/favicon.ico') ?>">

    <style>
        body{
            background:#f5f7fb;
        }

        .login-wrapper{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-card{
            width:100%;
            max-width:360px;
        }

        .login-card .card{
            border:none;
            border-radius:10px;
        }

        .login-card .card-body{
            padding:20px !important;
        }

        .login-card img{
            width:65px;
        }

        .login-card h4{
            font-size:22px;
            margin-top:10px;
            margin-bottom:2px;
            font-weight:600;
        }

        .login-card small{
            font-size:13px;
        }

        .form-group{
            margin-bottom:12px !important;
        }

        .form-group label{
            font-size:13px;
            font-weight:600;
            margin-bottom:4px;
        }

        .form-control{
            height:38px !important;
            min-height:38px !important;
            padding:6px 10px !important;
            font-size:14px !important;
            border-radius:6px;
        }

        .btn{
            height:38px !important;
            font-size:14px !important;
            border-radius:6px;
        }

        .alert{
            padding:8px 12px;
            font-size:13px;
        }
    </style>

</head>

<body>

<div class="container login-wrapper">

    <div class="login-card">

        <div class="card shadow">

            <div class="card-body">

                <div class="text-center mb-3">

                    <img
                        src="<?= base_url('admin-template/assets/images/yvu150-150.png') ?>"
                        alt="YVU Logo">

                    <h4>YVU Login</h4>

                    <small class="text-muted">
                        Sign in to continue
                    </small>

                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger text-center">
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

                <form action="<?= base_url('login') ?>" method="post">

                    <div class="form-group">
                        <label>User ID</label>

                        <input
                            type="text"
                            name="email"
                            class="form-control"
                            placeholder="Enter User ID"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter Password"
                            required>
                    </div>

                    <div class="form-group">
                        <?= captcha_field(); ?>
                    </div>

                    <button class="btn btn-primary btn-block mt-2">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="<?= base_url('admin-template/assets/vendors/js/vendor.bundle.base.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/off-canvas.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/template.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/settings.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/todolist.js') ?>"></script>

</body>
</html>