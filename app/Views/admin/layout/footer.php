<!-- partial:partials/_footer.html -->
<!-- <footer class="footer">
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
</footer> -->
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



</body>
</html>
