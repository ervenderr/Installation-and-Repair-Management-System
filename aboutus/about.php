<?php
session_start();
require_once '../tools/variables.php';
include_once('../homeIncludes/header.php');
require_once '../homeIncludes/dbconfig.php';
$page_title = 'ProtonTech | About Us';
$about = 'actives';
?>

<body>
    <?php include_once('../homeIncludes/homenav.php');?>

    <div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="../img/repairs.jpg" alt="About Us Image" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2>About Us</h2>
                    <p>Welcome to Proton Tech Electronics and Services!</p>
                    <p> Proton Tech Electronics and Services is a reliable electronic repair shop that provides
                        top-quality services and repairs for your electronics. Our
                        team of highly skilled technicians is dedicated to providing personalized and attentive customer
                        care, ensuring customer satisfaction with every repair. We strive to minimize downtime by
                        offering quick turnaround times and a satisfaction guarantee for all our services.</p>
                    <p>Our goal is to become a leading electronic repair shop that provides top-quality services
                        worldwide. We use only the best quality parts and tools to ensure that our repairs last, and we
                        are affiliated with some of the most reputable suppliers in the industry. We are proud of the
                        recognition and awards we have received for our excellent service and commitment to customer
                        satisfaction. Thank you for choosing Proton Tech Electronics and Services for your electronic
                        repair needs.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../homeIncludes/footer.php');?>

</body>

</html>