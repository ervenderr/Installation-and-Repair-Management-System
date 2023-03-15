<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                <img src="../assets/images/faces/face1.jpg" alt="image">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">Alyasher A.</span>
                  <span class="text-secondary text-small">Technician</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../admin/dashboard.php">
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
                    <li class="nav-item"> <a class="nav-link" href="../tech_repair/pending.php">Pending request</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../tech_repair/transaction.php">My Transactions</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?php echo $invactive; ?>">
              <a class="nav-link" href="../tech_service/transaction.php">
                <span class="menu-title">Service Request</span>
                <i class="fas fa-cog menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>