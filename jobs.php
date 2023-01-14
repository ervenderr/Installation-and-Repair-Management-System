<?php
require_once 'homeIncludes/dbconfig.php';

require_once 'tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives';
include_once('homeIncludes/header.php');


?>

<body>

    <?php include_once('homeIncludes/homenav.php'); ?>
    <div class="container servicecon ctr">

        <div class="cal-container">
        <h4>Simple Calculator</h3>
            <div class="inner-cal">
                <div class="dis" id="display"></div>
                <div class="bbtn-row">
                    <button class="bttn">(</button>
                    <button class="bttn">)</button>
                    <button class="bttn">C</button>
                    <button class="bttn">&larr;</button>
                </div>
                <div class="bbtn-row">
                    <button class="bttn">7</button>
                    <button class="bttn">8</button>
                    <button class="bttn">9</button>
                    <button class="bttn">/</button>
                </div>
                <div class="bbtn-row">
                    <button class="bttn">4</button>
                    <button class="bttn">5</button>
                    <button class="bttn">6</button>
                    <button class="bttn">*</button>
                </div>
                <div class="bbtn-row">
                    <button class="bttn">1</button>
                    <button class="bttn">2</button>
                    <button class="bttn">3</button>
                    <button class="bttn">-</button>
                </div>
                <div class="bbtn-row">
                    <button class="bttn">0</button>
                    <button class="bttn">.</button>
                    <button class="bttn">+</button>
                    <button id="equal" class="bttn">=</button>
                </div>
            </div>


        </div>




    </div>
<script src="practice.js"></script>
</body>

</html>