<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="../assets/images/faces/admin1.jpg" alt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">Ronald Dale F.</span>
                  <span class="text-secondary text-small">Admin</span>
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
            <p class="text-secondary paragh">Transactions</p>
            <li class="nav-item <?php echo $rpactive; ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#uibasic" aria-expanded="false" aria-controls="uibasic">
                <span class="menu-title">Repair request</span>
                <i class="menu-arrow"></i>
                <i class="fas fa-tools menu-icon"></i>
              </a>
              <div class="collapse <?php echo $rpshow; ?>" id="uibasic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="../adminRepair/pending.php">Pending request</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../adminRepair/accepted.php">Accepted request</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../adminRepair/transaction.php">Transactions</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?php echo $seractive; ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
                <span class="menu-title">Service request</span>
                <i class="menu-arrow"></i>
                <i class="fas fa-cogs menu-icon"></i>
              </a>
              <div class="collapse <?php echo $sershow; ?>" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="../adminServices/transactions.php">Transactions</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../adminServices/pendings.php">Pending request</a></li>
                </ul>
              </div>
            </li>
            <p class="text-secondary paragh">Maintenance</p>
            <li class="nav-item <?php echo $prodactive; ?>">
              <a class="nav-link" href="../admin_products/products.php">
                <span class="menu-title">Products</span>
                <i class="fas fa-box menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php echo $invactive; ?>">
              <a class="nav-link" href="../inventory/inventory.php">
                <span class="menu-title">Inventory</span>
                <i class="fas fa-warehouse menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php echo $custactive; ?>">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
                <span class="menu-title">Customer</span>
                <i class="menu-arrow"></i>
                <i class="fas fa-users menu-icon"></i>
              </a>
              <div class="collapse <?php echo $custshow; ?>" id="ui-basic3">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="../adminCustomer/walk-in.php">Walk-in</a></li>
                  <li class="nav-item"> <a class="nav-link" href="../adminCustomer/online.php">Online</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item <?php echo $suppactive; ?>">
              <a class="nav-link" href="../supplier/supplier.php">
                <span class="menu-title">Supplier</span>
                <i class="fas fa-user-tie menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?php echo $techactive; ?>">
              <a class="nav-link" href="../technician/technicians.php">
                <span class="menu-title">Techninicians</span>
                <i class="fas fa-user-cog menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>