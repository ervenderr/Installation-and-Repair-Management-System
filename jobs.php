<div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">
    <div class="col-12 col-sm-6 col-lg-3">
        <img class="w-100" src="/image-1.jpg" data-target="#carouselExample" data-slide-to="0">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <img class="w-100" src="/image-2.jpg" data-target="#carouselExample" data-slide-to="1">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <img class="w-100" src="/image-3.jpg" data-target="#carouselExample" data-slide-to="2">
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <img class="w-100" src="/image-4.jpg" data-target="#carouselExample" data-slide-to="3">
    </div>
</div>

<!-- Modal markup: https://getbootstrap.com/docs/4.4/components/modal/ -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        
      <!-- Carousel markup: https://getbootstrap.com/docs/4.4/components/carousel/ -->
      <div id="carouselExample" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="/image-1.jpg">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="/image-2.jpg">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="/image-3.jpg">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="/image-4.jpg">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>