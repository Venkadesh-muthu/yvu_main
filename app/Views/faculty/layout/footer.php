<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
      Copyright © 2023. Premium 
      <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> 
      from BootstrapDash. All rights reserved.
    </span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
      Hand-crafted & made with <i class="ti-heart text-danger ms-1"></i>
    </span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="<?= base_url('admin-template/assets/vendors/js/vendor.bundle.base.js') ?>"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="<?= base_url('admin-template/assets/vendors/chart.js/chart.umd.js') ?>"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="<?= base_url('admin-template/assets/js/off-canvas.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/template.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/settings.js') ?>"></script>
<script src="<?= base_url('admin-template/assets/js/todolist.js') ?>"></script>
<!-- endinject -->

<!-- Custom js for this page-->
<script src="<?= base_url('admin-template/assets/js/jquery.cookie.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('admin-template/assets/js/dashboard.js') ?>"></script>
<!-- End custom js for this page-->
<script>
let searchTimer = null;

function liveSearch() {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
        let query = document.getElementById("searchBox").value;

        fetch("<?= base_url('admin/users') ?>?q=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");

                // Only replace tbody
                let newTbody = doc.querySelector("table tbody").innerHTML;
                document.querySelector(".bottom-scroll table tbody").innerHTML = newTbody;

                // Update pagination if needed
                let newPager = doc.querySelector(".mt-3");
                if(newPager){
                    document.querySelector(".mt-3").innerHTML = newPager.innerHTML;
                }

                // Recalculate top scrollbar width
                const wrapper = document.querySelector('.table-scroll-wrapper');
                const topScroll = wrapper.querySelector('.top-scroll');
                const bottomScroll = wrapper.querySelector('.bottom-scroll');
                const table = bottomScroll.querySelector('table');
                topScroll.firstElementChild.style.width = table.scrollWidth + 'px';
            });
    }, 300);
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const wrapper = document.querySelector('.table-scroll-wrapper');
  const topScroll = wrapper.querySelector('.top-scroll');
  const bottomScroll = wrapper.querySelector('.bottom-scroll');
  const table = bottomScroll.querySelector('table');

  // Set top scroll width dynamically based on table width
  function updateTopScroll() {
    topScroll.firstElementChild.style.width = table.scrollWidth + 'px';
  }
  updateTopScroll();

  // Sync scroll positions
  topScroll.addEventListener('scroll', () => {
    bottomScroll.scrollLeft = topScroll.scrollLeft;
  });
  bottomScroll.addEventListener('scroll', () => {
    topScroll.scrollLeft = bottomScroll.scrollLeft;
  });

  // Update top scroll width on window resize
  window.addEventListener('resize', updateTopScroll);
});
</script>
<?php if (!empty($profile)): ?>
<script>
function toggleVisibility(field) {
    let btn = document.getElementById(field + '_eye');
    let currentStatus = btn.getAttribute('data-status'); // 'view' or 'hide'
    let newStatus = currentStatus === 'view' ? 'hide' : 'view';
    let faculty_profiles_id = "<?= $profile['id'] ?>";

    let csrfName = "<?= csrf_token() ?>";
    let csrfValue = "<?= csrf_hash() ?>";

    let formData = new URLSearchParams();
    formData.append('faculty_profiles_id', faculty_profiles_id);
    formData.append('field', field);
    formData.append('status', newStatus);
    formData.append(csrfName, csrfValue);

    fetch("<?= base_url('faculty/update-profile-visibility') ?>", {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success') {
            // Update the button icon, title, and data-status
            if(newStatus === 'view') {
                btn.innerHTML = '<i class="fas fa-eye"></i>';
                btn.setAttribute('title', 'Hide');
                btn.setAttribute('data-status', 'view');
            } else {
                btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                btn.setAttribute('title', 'Show');
                btn.setAttribute('data-status', 'hide');
            }
        } else {
            console.error('Failed to update visibility');
        }
    })
    .catch(err => console.error(err));
}
</script>
<?php endif; ?>

<script>
  function toggleEducationVisibility(eduId) {
      let csrfName = "<?= csrf_token() ?>";
      let csrfHash = "<?= csrf_hash() ?>";

      let formData = new URLSearchParams();
      formData.append('faculty_education_id', eduId);
      formData.append(csrfName, csrfHash);

      fetch("<?= base_url('faculty/update-education-visibility') ?>", {
          method: 'POST',
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              let btn = document.querySelector('#eye-btn-' + eduId + ' i');
              if (data.newVisibility === 'view') {
                  btn.classList.remove('fa-eye-slash');
                  btn.classList.add('fa-eye');
              } else {
                  btn.classList.remove('fa-eye');
                  btn.classList.add('fa-eye-slash');
              }
          } else {
              alert(data.message || 'Something went wrong!');
          }
      })
      .catch(err => console.error(err));
  }
</script>

<script>
  function toggleExperienceVisibility(expId) {
      let csrfName = "<?= csrf_token() ?>";
      let csrfHash = "<?= csrf_hash() ?>";

      let formData = new URLSearchParams();
      formData.append('faculty_experience_id', expId);
      formData.append(csrfName, csrfHash);

      fetch("<?= base_url('faculty/update-experience-visibility') ?>", {
          method: 'POST',
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              let btn = document.querySelector('#eye-btn-exp-' + expId + ' i');
              if (data.newVisibility === 'view') {
                  btn.classList.remove('fa-eye-slash');
                  btn.classList.add('fa-eye');
              } else {
                  btn.classList.remove('fa-eye');
                  btn.classList.add('fa-eye-slash');
              }
          } else {
              alert(data.message || 'Something went wrong!');
          }
      })
      .catch(err => console.error(err));
  }
</script>

<script>
  function toggleAchievementVisibility(achId) {
      let csrfName = "<?= csrf_token() ?>";
      let csrfHash = "<?= csrf_hash() ?>";

      let formData = new URLSearchParams();
      formData.append('achievement_id', achId);
      formData.append(csrfName, csrfHash);

      fetch("<?= base_url('faculty/update-achievement-visibility') ?>", {
          method: 'POST',
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          if (data.status === 'success') {
              let btn = document.querySelector('#eye-btn-' + achId + ' i');

              if (data.newVisibility == 1) {
                  btn.classList.remove('fa-eye-slash');
                  btn.classList.add('fa-eye');
              } else {
                  btn.classList.remove('fa-eye');
                  btn.classList.add('fa-eye-slash');
              }

          } else {
              alert(data.message || 'Something went wrong!');
          }
      })
      .catch(err => console.error(err));
  }
</script>

<script>
function toggleSkillVisibility(skillId)
{
    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    let formData = new URLSearchParams();
    formData.append('faculty_skill_id', skillId);
    formData.append(csrfName, csrfHash);

    fetch("<?= base_url('faculty/update-skill-visibility') ?>", {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            let icon = document.querySelector('#eye-btn-skill-'+skillId+' i');
            icon.className = (data.newVisibility === 'view') ? 'fas fa-eye' : 'fas fa-eye-slash';
        }
    });
}
</script>
<script>
function toggleWorkVisibility(workId)
{
    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    let formData = new URLSearchParams();
    formData.append('faculty_work_id', workId); // ✅ MUST MATCH CONTROLLER
    formData.append(csrfName, csrfHash);

    fetch("<?= base_url('faculty/update-work-visibility') ?>", {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            let icon = document.querySelector('#eye-btn-' + workId + ' i');
            icon.className = (data.newVisibility === 'view')
                ? 'fas fa-eye'
                : 'fas fa-eye-slash';
        } else {
            alert(data.message || 'Visibility update failed');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Something went wrong');
    });
}
</script>


</body>
</html>
