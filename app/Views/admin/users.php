<div class="main-panel">
    <div class="content-wrapper">

        <div class="row mb-3">
            <div class="col-lg-6">
                <h4 class="card-title">Users</h4>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

       <div class="row mb-3 align-items-center">
            <!-- LEFT SIDE: Search -->
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <form method="get" id="liveSearchForm">
                    <input type="text"
                        name="q"
                        id="searchBox"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Search..."
                        class="form-control form-control-sm"
                        onkeyup="liveSearch()">
                </form>
            </div>

            <!-- RIGHT SIDE: Add User + Upload Excel -->
            <div class="col-12 col-md-8 text-md-end d-flex flex-column flex-md-row justify-content-md-end gap-2">
                <a href="<?= base_url('admin/addUser') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add User
                </a>

                <button class="btn btn-success btn-sm" onclick="document.getElementById('excelUpload').click();">
                    <i class="bi bi-upload"></i> Upload Excel
                </button>

                <form id="excelForm" method="post" enctype="multipart/form-data"
                    action="<?= base_url('admin/uploadExcel') ?>"
                    style="display:none;">
                    <input type="file" name="excel" id="excelUpload" accept=".xlsx"
                        onchange="document.getElementById('excelForm').submit();">
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
               <div class="table-scroll-wrapper position-relative">
                    <!-- Top Scroll -->
                    <div class="top-scroll" style="overflow-x:auto; height:16px; margin-bottom:8px;">
                        <div style="width:1px; height:1px;"></div>
                    </div>
                    <div class="bottom-scroll table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>User Type</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php
                                        $currentPage = $pager->getCurrentPage('default');
                                    $perPage     = $pager->getPerPage('default');
                                    $start       = ($currentPage - 1) * $perPage + 1;
                                    $i           = $start;
                                    ?>

                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($user['username']) ?></td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><?= esc($user['department']) ?></td>

                                            <td>
                                                <?php if (!empty($user['user_type'])): ?>
                                                    <span class="badge bg-info text-dark"><?= esc($user['user_type']) ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Not Specified</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= esc($user['phone'] ?? '-') ?></td>
                                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>

                                            <td>
                                                <a href="<?= base_url('admin/editUser/' . $user['id']) ?>" 
                                                class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>

                                                <a href="<?= base_url('admin/deleteUser/' . $user['id']) ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                                <a href="<?= base_url('admin/downloadUserPdf/' . $user['id']) ?>"
                                                class="btn btn-sm btn-info">
                                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            <?= $pager->links('default', 'bootstrap') ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        

