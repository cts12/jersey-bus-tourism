<?php
$meta = array(
	'title' => 'Get a Bus | Omnibus #hackjsy 2014',
	'description' => '',
	'keywords' => ''
);
$heading = 'FIND A BUS';

require 'app/views/header.php' ;
?>
 <!-- CONTENT SECTION -->
            <div id="content-home">
                <div class="btn-home-options">
                    <a href="/bus-map.php" tabindex="1">
                    <div class="home-icon">
                       <i class="fa fa-street-view fa-3x"></i>
                    <p>Find nearest Bus Stop</p>
                    </div>
                    </a>
                </div>

                <div class="btn-home-options">
                    <a href="pick-destination.php">
                    <div class="home-icon">
                         <i class="fa fa-map-marker fa-3x"></i>
                    <p>Choose a Destination</p>
                    </div>
                    </a>
                </div>

            </div>
 <!-- END OF CONTENT SECTION -->

<?php
require 'app/views/footer.php';
