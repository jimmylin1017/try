<?php

	$tableName = "web_banner";
	$myPDO = MyPDO::getInstance();
	$result = $myPDO->searchAll($tableName);
?>

<div class="container">
    <div id="carouselBanner" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
      	<li data-target="#carouselBanner" data-slide-to="0" class="active"></li>
        <?php
		  for($i=1; $i<=count($result); $i++) {
		  	if($i == 1) echo '<li data-target="#carouselBanner" data-slide-to="' . $i . '" class="active"></li>';
			else '<li data-target="#carouselBanner" data-slide-to="' . $i . '"></li>';
		  }
		?>
      </ol>
      <div class="carousel-inner" role="listbox">
      	<?php
		  for($i=1; $i<=count($result); $i++) {
		  	if($i == 1) {
				echo '<div class="carousel-item active">';
				echo '<img class="img-responsive center-block" src="img/banner/' . $result[$i - 1]['picture'] . '" alt="slide ' . $i . '">';
				echo '</div>';
			}
			else {
				echo '<div class="carousel-item">';
				echo '<img class="d-block img-fluid" src="img/banner/' . $result[$i - 1]['picture'] . '" alt="slide ' . $i . '">';
				echo '</div>';
			}
		  }
		?>
        <!--
        <div class="carousel-item active">
          <img class="img-responsive center-block" src="img/banner/60085916_p0_master1200.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid" src="img/banner/60085916_p1_master1200.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid" src="img/banner/60397890_p0.jpg" alt="Third slide">
        </div>
        -->
      </div>
      <a class="carousel-control-prev" href="#carouselBanner" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselBanner" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>

<style type="text/css">
.carousel img {
	/*weight: 100%;*/
}
</style>