<?php 
include 'header.php'; 

?>


    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

    <?php include 'sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Doanh thu</h4>
                  <canvas id="revenueChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Người dùng mới</h4>
                  <canvas id="newUsersChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- plugins:js -->

  <?php include 'footer.php'; ?>
  <script src="../js/chart_admin.js"></script>