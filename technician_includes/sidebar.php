<?php
$query = "SELECT *
FROM technician
JOIN accounts ON technician.account_id = accounts.account_id
WHERE technician.account_id = '" . $user_id . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
$techrow = mysqli_fetch_assoc($result);

}
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                <?php 
                $image1 = $techrow['tech_img'];
                $image_data1 = base64_encode($image1);
                $image_src1 = "data:image/jpeg;base64,{$image_data1}";
            ?>
                <img class="imgsz" src="<?php echo $image_src1; ?>" alt="Technician's Profile Picture">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?php echo $techrow['fname'] ?></span>
                  <span class="text-secondary text-small">Technician</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../technician_dashboard/dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="fas fa-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php echo $rpactive; ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#uibasic" aria-expanded="false" aria-controls="uibasic">
                <span class="menu-title">Repair request</span>
                <i class="menu-arrow"></i>
                <i class="fas fa-tools menu-icon"></i>
              </a>
              <div class="collapse <?php echo $rpshow; ?>" id="uibasic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link <?php echo $rppending; ?>" href="../tech_repair/pending.php">Pending request</a></li>
                  <li class="nav-item"> <a class="nav-link <?php echo $rpactives; ?>" href="../tech_repair/transaction.php">My Transactions</a></li>
                </ul>
              </div>
            </li>

          </ul>
        </nav>