<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
$servpkgnav = 'servactives';
include_once('../homeIncludes/header.php');

if (isset($_GET['rowid'])) {
    $rowid = $_GET['rowid'];
$_SESSION['rowid'] = $rowid;
} else {
    header('location: ../service/servpkg.php');
    exit; // add this to stop the script execution after redirection
}
  
// Perform the query to retrieve the data for the selected row
$query = "SELECT *, package.price AS package_price, services.price AS service_price, package.status AS package_status
FROM package
INNER JOIN services ON package.service_id = services.service_id
WHERE package.PKG_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
  $rows = mysqli_fetch_assoc($result);

}
$currentStatus = $rows['package_status'];
$service = $rows['service_name'];


if (isset($_SESSION['logged_id'])){
    $user_id = $_SESSION['logged_id'];
    $sql2 = "SELECT *
FROM accounts 
INNER JOIN customer ON accounts.account_id = customer.account_id
WHERE accounts.account_id = $user_id";

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$_SESSION['cust_id'] = $row2['cust_id'];
$_SESSION['logged_id'] = $row2['account_id'];
}



?>

<body class="view-body">
    <?php
    include_once('../homeIncludes/homenav.php');
    ?>

    <div class="jobcon">
        <ul class="nav justify-content-center">
            
        </ul>
        <div id='msgs' class='msg'>
            <p id='msgs'>Request Submitted!</p>
            <div class="msgbtn">
                <a class="msgb" href="../service/pending-transaction.php" role="button">Get Information
                    ID</a>

            </div>
        </div>
        <div class="container mb-5">
            <div class="card">
                <div class="row g-0 p-3 notflexwrap">
                    <div class="col-md-6 border-end">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="main_image">
                                <?php
        $imageData = base64_encode($rows['image']);
        $src = 'data:image/jpeg;base64,'.$imageData;
        echo '<img src="'.$src.'" id="main_product_image" width="350">';
    ?>
                            </div>

                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-6">
                            <a href="servpkg.php"><i
                                    class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                </i></a>
                            <div class="p-3 right-side justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center package_name">
                                    <h4><?php echo $rows['name'] ?></h4>
                                </div>
                                <h4 class="package_price">₱<?php echo $rows['package_price'] ?></h4>
                                <div class="mt-3 pr-3 content">
                                    <?php
                                    $text = $rows['descriptions'];
                                    $formatted_text = nl2br($text);
                                    echo "<p class='package-description'>" . $formatted_text . "</p>";
                                ?>
                                </div>
                                <?php
                                $btn="";
                                $href="";
                                if(isset($_SESSION['logged_id'])){
                                    $btn="btn-submit";
                                    $href="view-packge.php";
                                }else{
                                    $btn="btn-submits";
                                    $href="shipping-address.php";
                                }

                                ?>
                                <form action="<?php echo $href; ?>" class="form" method="POST" id="repair-form"
                                    enctype="multipart/form-data">
                                    <div class="buttons d-flex flex-row mt-5 gap-3">
                                        <input type="hidden" id="pkg_id" name="pkg_id"
                                            value="<?php echo $rows['pkg_id'] ?>">
                                        <input type="submit" name="submit" class="btn btn-dark" value="Avail Now" id="<?php echo $btn; ?>">
                                    </div>
                                    <?php
                                    $_SESSION['pkg_id'] = $rows['pkg_id'];
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

    </div>



    <script type="text/javascript">
    $(document).ready(function() {
        $('#btn-submit').click(function(e) {
            e.preventDefault();

            var valid = true;

            if (valid) {
                $.ajax({
                    method: "POST",
                    url: "serviceProcess.php",
                    data: $('#repair-form').serialize(),
                    dataType: "text",
                    success: function(response) {
                        $('#msgs').css('display', 'block').fadeIn(300);
                        $('#adis').css('pointer-events', 'none');
                        $('#btn-submit').css('pointer-events', 'none');
                        $('#eimg').css('pointer-events', 'none');
                        $('#shipping').css('pointer-events', 'none');
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