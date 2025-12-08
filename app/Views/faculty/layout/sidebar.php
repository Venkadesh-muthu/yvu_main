
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('faculty/dashboard'); ?>">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item <?= (isset($title) && $title == 'Faculty Profile') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('faculty/profile'); ?>">
              <i class="ti-id-badge menu-icon"></i>
              <span class="menu-title">Faculty Profile</span>
          </a>
      </li>
      <?php $profileExists = session()->get('profileExists'); ?>

        <!-- Educational Background -->
        <li class="nav-item <?= ($title == 'Educational Background') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>
            <a class="nav-link" href="<?= base_url('faculty/educations') ?>">
                <i class="ti-book menu-icon"></i>
                <span class="menu-title">Educational</span>
            </a>
        </li>

        <!-- Experiences -->
        <li class="nav-item <?= ($title == 'Experience') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>
            <a class="nav-link" href="<?= base_url('faculty/experiences') ?>">
                <i class="ti-briefcase menu-icon"></i>
                <span class="menu-title">Experience</span>
            </a>
        </li>

        <!-- Achievements -->
        <li class="nav-item <?= ($title == 'Achievements') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>

            <a class="nav-link" href="<?= base_url('faculty/achievements') ?>">
                <i class="ti-medall menu-icon"></i>
                <span class="menu-title">Achievements</span>
            </a>

        </li>
        <li class="nav-item <?= ($title == 'Skills') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>
            <a class="nav-link" href="<?= base_url('faculty/skills') ?>">
                <i class="ti-medall menu-icon"></i>
                <span class="menu-title">Skills</span>
            </a>
        </li>

        <li class="nav-item <?= ($title == 'Works') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>
            <a class="nav-link" href="<?= base_url('faculty/works') ?>">
                <i class="ti-book menu-icon"></i>
                <span class="menu-title">Works</span>
            </a>
        </li>

        <li class="nav-item <?= ($title == 'Activities') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>
            
            <a class="nav-link" href="<?= base_url('faculty/activities') ?>">
                <i class="ti-briefcase menu-icon"></i>
                <span class="menu-title">Activities</span>
            </a>
        </li>

        <li class="nav-item <?= ($title == 'Research Students') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>

            <a class="nav-link" href="<?= base_url('faculty/research-students') ?>">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">Research Students</span>
            </a>
        </li>
        <li class="nav-item <?= ($title == 'Projects') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>

            <a class="nav-link" href="<?= base_url('faculty/projects') ?>">
                <i class="ti-briefcase menu-icon"></i>
                <span class="menu-title">Projects</span>
            </a>

        </li>
        <li class="nav-item <?= ($title == 'Information') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>

            <a class="nav-link" href="<?= base_url('faculty/information') ?>">
                <i class="ti-layout-list-post menu-icon"></i>
                <span class="menu-title">Information</span>
            </a>

        </li>
        <li class="nav-item <?= ($title == 'News / Press / Pictures') ? 'active' : '' ?>"
            <?= (!$profileExists) ? 'style="display:none"' : '' ?>>

            <a class="nav-link" href="<?= base_url('faculty/news') ?>">
                <i class="ti-announcement  menu-icon"></i>
                <span class="menu-title">News / Press / Pictures</span>
            </a>

        </li>



      <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">UI Elements</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Form elements</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Charts</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="charts">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
          <i class="icon-grid-2 menu-icon"></i>
          <span class="menu-title">Tables</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="tables">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <i class="icon-contract menu-icon"></i>
          <span class="menu-title">Icons</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">User Pages</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
          <i class="icon-ban menu-icon"></i>
          <span class="menu-title">Error pages</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="error">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../../docs/documentation.html">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Documentation</span>
        </a>
      </li> -->
    </ul>
  </nav>