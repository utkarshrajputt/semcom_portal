<div id="carouselExampleSlidesOnly" class="carousel slide mt-2 mb-3" data-bs-ride="carousel" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../assets/images/backsc.jpg" class="d-block w-100  h-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="../assets/images/frontImg.jpg" class="d-block w-100  h-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="../assets/images/sc-staff.jpg" class="d-block w-100 h-100" alt="...">
        </div>
        
        
    </div>
</div>

<script>
    var myCarousel = document.querySelector('#carouselExampleSlidesOnly')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 1000,
        wrap: true
    })
</script>