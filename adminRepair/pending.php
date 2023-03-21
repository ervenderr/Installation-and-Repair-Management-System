<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$search = "pending.php";

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
  header('location: ../login/login.php');
}

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
                                <i class="fas fa-tools menu-icon"></i>
                            </span> Repair Transaction
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Overview <i
                                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                        <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex">
                                    <h4 class="card-title">List of Repair Transaction</h4>

                                </div>
                                <div class="col-sm-12 col-md-6 flex flexm">
                                    <div id="example_filter" class="dataTables_filter"><label>Search:<input type="text"
                                                placeholder="search" id="myInput" class="form-control"></label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Transaction Code </th>
                                                    <th> Customer </th>
                                                    <th> Status </th>
                                                    <th> Date </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    
                                                    if(isset($_GET['page_no']) && $_GET['page_no'] !=''){
                                                        $page_no = $_GET['page_no'];
                                                    }else{
                                                        $page_no = 1;
                                                    }

                                                    $total_record_per_page = 10;
                                                    $offset = ($page_no-1) * $total_record_per_page;
                                                    $previous_page = $page_no -1;
                                                    $next_page = $page_no +1;
                                                    $adjacent = "2";

                                                    $result_count = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM rprq WHERE rprq.status = 'Pending'");
                                                    $total_records = mysqli_fetch_array($result_count);
                                                    $total_records = $total_records['total_records'];
                                                    $total_no_of_page = ceil($total_records / $total_record_per_page);
                                                    $second_last = $total_no_of_page - 1;
                                                
                                                    // Perform the query
                                                    $query = "SELECT *
                                                        FROM rprq
                                                        JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                        WHERE rprq.status = 'Pending'";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $modalId = 'editTransactionModal-' . $id;
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['transaction_code'] . '</td>';
                                                        echo '<td>' . $row['fname'] . '  ' . $row['lname'] . '</td>';
                                                    
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
                                                    
                                                        echo '<td><label class="badge ' . $statusClass . '">' . $row['status'] . '</label></td>';
                                                        echo '<td>' . $row['date_req'] . '</td>';
                                                        echo '<td class="btn-group-sm">';
                                                        echo '<a class="icns btn btn-info" href="view-transaction.php?transaction_code=' . $row['transaction_code'] . '&rowid=' . $row['id'] . '">';
                                                        echo '<i class="fas fa-eye view-account" Prod_id="' .  $row['id'] . '"></i> View';
                                                        echo '</a>';
                                                        echo '<button class="icns btn btn-danger edit" id="' .  $row['id'] . '">';
                                                        echo '<i class="fas fa-calendar-check view-account" id="' .  $row['id'] . '"> </i> Accept';
                                                        echo '</button>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;
                                                    }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 flex">

                                </div>
                                <div class="col-sm-12 col-md-6 flex flexm flexmm">
                                    <nav aria-label="...">
                                        <ul class="pagination pagination-sm">
                                            <li class="page-item disabled oneofone"><?php echo $page_no. "of". $total_no_of_page; ?>
                                            </li>
                                            <li class="page-item" <?php if($page_no <= 1) {echo "class='page-item disabled'";} ?>>
                                            <a class="page-link" <?php if($page_no > 1) {echo "href='?page_no=$previous_page'";} ?>>Previous</a>
                                            </li>

                                            <?php
                                                if($total_no_of_page <= 10){
                                                    for($counter = 1; $counter <= $total_no_of_page; $counter++){
                                                        if($counter == $page_no){
                                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                        }else{
                                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                                        }
                                                    }

                                                }elseif($total_no_of_page > 10){
                                                    if($page_no <=4){

                                                        for($counter = 1; $counter < 8; $counter++){
                                                            if($counter == $page_no){
                                                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                            }else{
                                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                                            }
                                                        }
                                                        echo '<li class="page-item"><a class="page-link">...</a></li>';
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_page'>$total_no_of_page</a></li>";
                                                    }elseif($page_no > 4 && $page_no < $total_no_of_page - 4){
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                                                        echo '<li class="page-item"><a class="page-link">...</a></li>';

                                                        for($counter = $page_no - $adjacent; $counter <= $page_no + $adjacent; $counter++){
                                                            if($counter == $page_no){
                                                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                            }else{
                                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                                            }
                                                        }
                                                        echo '<li class="page-item"><a class="page-link">...</a></li>';
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_page'>$total_no_of_page</a></li>";
                                                    }else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                                                        echo '<li class="page-item"><a class="page-link">...</a></li>';
                                                        for($counter = $total_no_of_page - 6; $counter <= $total_no_of_page; $counter++){
                                                            if($counter == $page_no){
                                                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                                            }else{
                                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            <li class="page-item" <?php if($page_no >= $total_no_of_page) {echo "class='page-item disabled'";} ?>>
                                            <a class="page-link" <?php if($page_no < $total_no_of_page) {echo "href='?page_no=$next_page'";} ?>>Next</a>
                                            </li>
                                            <?php
                                                if($page_no < $total_no_of_page) {echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_page'>Last &rsaqou; &rsaqou;</a></li>";}
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid d-flex justify-content-between">
                        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
                            protontech.com 2023</span>
                        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a
                                href="https://www.proton-tech.online/" target="_blank">ProtonTech</a></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- Accept modal -->
    <div class="modal fade" id="editSuppModal" tabindex="-1" aria-labelledby="editSuppModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSuppModalLabel">Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body suppbody">
        
      </div>
    </div>
  </div>
</div>

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

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>

<script>
  $(document).ready(function(){
    $('.edit').click(function(){

        id =  $(this).attr('id');
        $.ajax({
        url: 'accept-pending.php',
        method: 'post',
        data: {id:id},
        success: function(result) {
            // Handle successful response
            $('.suppbody').html(result);
        }
        });


      $('#editSuppModal').modal('show');
    })
  })
</script>
</body>

</html>