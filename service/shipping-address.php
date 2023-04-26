<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
$servpkgnav = 'servactives';
include_once('../homeIncludes/header.php');

if (isset($_POST['pkg_id']) && !isset($_SESSION['logged_id'])) {
    $pkg_id = $_POST['pkg_id'];
} else {
    header('location: ../service/view-packge.php');
    exit; // add this to stop the script execution after redirection
}


$rowid = $_GET['rowid'];
$_SESSION['rowid'] = $rowid;
  
// Perform the query to retrieve the data for the selected row
$query = "SELECT *, package.price AS package_price, services.price AS service_price, package.status AS package_status
FROM package
INNER JOIN services ON package.service_id = services.service_id
WHERE package.pkg_id = '" . $pkg_id . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
  $rows = mysqli_fetch_assoc($result);

}
// $currentStatus = $rows['package_status'];
// $service = $rows['service_name'];

?>

<body class="view-body">
    <?php
    include_once('../homeIncludes/homenav.php');
    ?>

    <div class="jobcon">
        <div id='msgs' class='msg'>
            <p id='msgs'>Request Submitted!</p>
            <div class="msgbtn">
                <a class="msgb" href="../service/serviceProcess.php" role="button">Get Information
                    ID</a>
            </div>
        </div>
        <div class="container mb-5">
            <div class="card">
                <h4 class="p-3">Customer Details</h4>

                <div class="row g-0 p-3 notflexwrap">

                    <div class="col-md-8 custdetails">
                        <hr>

                        <div class="d-flex flex-column justify-content-center">

                            <form action="shipping-address.php" class="form" method="POST"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="pkg_id"
                                        value="<?php echo $rows['pkg_id'] ?>">
                                    <label for="firstName" class="form-label">First Name<span
                                            style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="firstName"
                                        placeholder="Enter your first name">
                                    <span class="val-error" id="firstName-error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name <span
                                            style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="lastName"
                                        placeholder="Enter your last name">
                                    <span class="val-error" id="lastName-error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Enter your email">
                                        <span class="input-group-text"><i class="fas fa-question-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="We'll use your email to send your order confirmation"></i></span>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone<span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control" id="phone"
                                            placeholder="Enter your phone number">
                                        <span class="input-group-text"><i class="fas fa-question-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="We'll use your phone number to contact you about your request"></i></span>
                                    </div>
                                    <span class="val-error" id="phone-error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Complete Address<span
                                            style="color:red">*</span></label>
                                    <textarea class="form-control" id="address" rows="3"
                                        placeholder="Enter your address"></textarea>
                                    <span class="val-error" id="address-error"></span>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 package-summary">
                            <div class="row">
                                <h4 class="mb-4">Package Summary</h4>
                                <hr>
                                <div class="col-md-3 view-packge-shipping mb-4">
                                    <?php
                                        $imageData = base64_encode($rows['image']);
                                        $src = 'data:image/jpeg;base64,'.$imageData;
                                        echo '<img src="'.$src.'" id="main_product_image">';
                                    ?>
                                </div>
                                <div class="col-md-5">
                                    <?php echo $rows['name'] ?>
                                </div>
                                <div class="col-md-4">
                                    ₱<?php echo $rows['package_price'] ?>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" name="submit" class="btn btn-dark" value="Confirm Request"
                                id="btn-submit">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

    </div>

    <!-- Initialize tooltips -->
    <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    </script>

    <!-- Your code to toggle tooltip content on click of the question circle icon -->
    <script>
    var questionIcons = document.querySelectorAll('.fa-question-circle');
    questionIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            var tooltip = this.parentElement.querySelector('.tooltip');
            tooltip.classList.toggle('show');
        });
    });
    </script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('#phone').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $('#btn-submit').click(function(e) {
            e.preventDefault();

            var firstName = $('#firstName').val();
            var lastName = $('#lastName').val();
            var phone = $('#phone').val();
            var address = $('#address').val();

            var isValid = true;

            if (firstName.trim() === '') {
                $('#firstName-error').text('This field is required.');
                isValid = false;
            } else {
                $('#firstName-error').text('');
            }

            if (lastName.trim() === '') {
                $('#lastName-error').text('This field is required.');
                isValid = false;
            } else {
                $('#lastName-error').text('');
            }


            if (phone.trim() === '') {
                $('#phone-error').text('This field is required.');
                isValid = false;
            } else if (!isValidPhone(phone)) {
                $('#phone-error').text('This field is required.');
                isValid = false;
            } else {
                $('#phone-error').text('');
            }

            if (address.trim() === '') {
                $('#address-error').text('This field is required.');
                isValid = false;
            } else {
                $('#address-error').text('');
            }

            function isValidPhone(phone) {
                var regex = /^\d{11}$/;
                return regex.test(phone);
            }


            if (isValid) {
                $.ajax({
                    method: "POST",
                    url: "#",
                    data: $('#repair-form').serialize(),
                    dataType: "text",
                    success: function(response) {
                        $('#msgs').css('display', 'block').fadeIn(300);
                        $('#adis').css('pointer-events', 'none');
                        $('#btn-submit').css('pointer-events', 'none');
                        $('#address').css('pointer-events', 'none');
                        $('#phone').css('pointer-events', 'none');
                        $('#firstName').css('pointer-events', 'none');
                        $('#lastName').css('pointer-events', 'none');
                    }
                })
            }
        });
    });
    </script>

    <script>
    function changeImage(element) {

        var main_prodcut_image = document.getElementById('main_product_image');
        main_prodcut_image.src = element.src;


    }
    </script>




    <script>
    var multipleCardCarousel = document.querySelector(
        "#cctvpkg"
    );
    if (window.matchMedia("(min-width: 768px)").matches) {
        var carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false,
        });
        var carouselWidth = $(".carousel-inner")[0].scrollWidth;
        var cardWidth = $(".carousel-item").width();
        var scrollPosition = 0;
        $("#cctvpkg .carousel-control-next").on("click", function() {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                scrollPosition += cardWidth;
                $("#cctvpkg .carousel-inner").animate({
                        scrollLeft: scrollPosition
                    },
                    600
                );
            }
        });
        $("#cctvpkg .carousel-control-prev").on("click", function() {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                $("#cctvpkg .carousel-inner").animate({
                        scrollLeft: scrollPosition
                    },
                    600
                );
            }
        });
    } else {
        $(multipleCardCarousel).addClass("slide");
    }
    </script>

</body>

</html>