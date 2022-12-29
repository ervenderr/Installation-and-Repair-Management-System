<?php

require_once 'tools/variables.php';
$page_title = 'ProtonTech | Services';
$services = 'actives';
include_once('homeIncludes/header.php');

?>

<body>
    <?php include_once('homeIncludes/homenav.php'); ?>


<<div class="container servicecon">
    <h2 class="text-center mb-5">SERVICES</h2>
  <div class="row mt-5">
    <div class="col-md-6">
      <img src="img/cctvinstall.jpg" alt="Service 1" class="img-fluid rounded shadow-lg">
    </div>
    <div class="col-md-6 d-flex align-items-center">
      <div class="bg-light p-3 rounded shadow-lg destext">
        <h3 class="text-left font-weight-bold mb-0 servname">CCTV Installation</h3>
        <p class="text-left font-italic text-secondary mt-1 mb-3">CCTV (closed-circuit television) is a TV system in which signals are not publicly distributed but are monitored, primarily for surveillance and security purposes. Best installation relies on strategic placement of cameras, resolution and its field view. Proton Tech only uses best quality CCTV Brands like TP-Link. Our team of experienced professionals will work with you to design and install a CCTV system that meets your unique requirements. We only use the best brands, such as TP-Link, to ensure that you get the highest quality and reliability</p>
        <button class="btn btn-primary mt-3"><a href="/solar-panels" style="color: white;">Learn more</a></button>
      </div>
    </div>
  </div>

  <hr class="my-5">

  <div class="row mt-5">
    <div class="col-md-6 order-md-2">
      <img src="img/solarinstall.jpg" alt="Service 2" class="img-fluid rounded shadow-lg right">
    </div>
    <div class="col-md-6 order-md-1 d-flex align-items-center">
      <div class="bg-light p-3 rounded shadow-lg">
        <h3 class="text-right font-weight-bold mb-0 servname">Solar Installation</h3>
        <p class="text-right font-italic text-secondary mt-1 mb-3">A solar panel, also know as a PV panel or module, is a device that collect sunlight and converts it into electric current. A solar panel is actually a collection of solar (or photovoltaic) cells, which can be used to generate electricity through photovoltaic effect. At ProtonTech, we offer a range of high-quality solar panel products and services. Our team of experienced professionals can help you design and install a solar panel system that meets your specific energy needs and budget. We use only the best materials and techniques to ensure that your solar panel system is reliable, efficient, and cost-effective.</p>
        <button class="btn btn-primary mt-3"><a href="/solar-panels" style="color: white;">Learn more</a></button>
      </div>
    </div>
  </div>

<hr class="my-5">

  <div class="row mt-5">
    <div class="col-md-6">
      <img src="img/fngrprint.jpg" alt="Service 3" class="img-fluid rounded shadow-lg">
    </div>
    <div class="col-md-6 d-flex align-items-center">
      <div class="bg-light p-3 rounded shadow-lg">
        <h3 class="text-left font-weight-bold mb-0 servname">Fingerprint Scanner</h3>
        <p class="text-left font-italic text-secondary mt-1 mb-3">Our fingerprint scanners use advanced biometric technology to accurately and securely identify individuals based on their unique fingerprint patterns. Whether you need to unlock a device, access a secure building, or log into an online account, our fingerprint scanners provide a fast and convenient way to verify your identity. With their high level of security and reliability, our fingerprint scanners are the ideal choice for a wide range of applications. Contact us today to learn more about how our fingerprint scanners can help you.</p>
        <button class="btn btn-primary mt-3"><a href="/solar-panels" style="color: white;">Learn more</a></button>
      </div>
      
    </div>
  </div>

<hr class="my-5">

</div>

  <!-- Footer -->
  <?php include_once('homeIncludes/footer.php');?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>