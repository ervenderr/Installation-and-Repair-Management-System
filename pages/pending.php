<?php
include_once('../admin_includes/header.php');
include_once('../homeincludes/dbconfig.php');

?>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include_once('../admin_includes/navbar.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('../admin_includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon text-white me-2">
                  <i class="mdi mdi-clipboard-text"></i>
                </span> Repair Transaction
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">List of Repair Transaction</h4>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Transaction Code </th>
                            <th> Customer </th>
                            <th> Status </th>
                            <th> Date </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Perform the query
                        $query = "SELECT rprq.transaction_code, customer.fname, customer.lname, rprq.status, rprq.date_req
                                  FROM rprq
                                  JOIN customer ON rprq.Cust_id = customer.Cust_id AND rprq.status = 'Pending'";
                        $result = mysqli_query($conn, $query);
                        $id = 1;
                        // Loop over the rows and output the data for each row
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td>" . $id . "</td>";
                          echo "<td>" . $row['transaction_code'] . "</td>";
                          echo "<td>" . $row['fname'] .", ". $row['lname'] . "</td>";
                          echo "<td>";
                          $statusClass = '';
                          if ($row['status'] == 'Pending') {
                            $statusClass = 'badge-gradient-warning';
                          } else if ($row['status'] == 'In-progress') {
                            $statusClass = 'badge-gradient-info';
                          } else if ($row['status'] == 'Done') {
                            $statusClass = 'badge-gradient-success';
                          } else {
                            $statusClass = 'badge-gradient-secondary';
                          }
                          echo "<label class='badge " . $statusClass . "'>" . $row['status'] . "</label>";

                          echo "<td>" . $row['date_req'] . "</td>";
                          echo "<td>
                          <a href='view-transaction.php?transaction_code=" . $row['transaction_code'] . "&rowid=" . $id . "'><i class='fas fa-eye text-primary view-account' data-rowid='" . $id . "'></i></a>
                          <i class='fas fa-edit text-success'></i> 
                          <i class='fas fa-trash-alt text-danger'></i>
                          </td>";
                          echo "</tr>";
                          $id++;
                        }
                        
                        ?>
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © protontech.com 2023</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a href="https://www.proton-tech.online/" target="_blank">ProtonTech</a></span>
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
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
    <script>
  // Add an event listener to the eye icon to show the modal window
  const viewAccountIcons = document.querySelectorAll('.view-account');
  viewAccountIcons.forEach(icon => {
    icon.addEventListener('click', () => {
      const rowid = icon.getAttribute('data-rowid');
      const modal = new bootstrap.Modal(document.getElementById('accountModal'));
      modal.show();
      // TODO: Populate the account form with data from the rowid
    });
  });
</script>
  </body>
</html>