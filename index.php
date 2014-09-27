<?php
$meta = array(
	'title' => 'Get a Bus | Omnibus #hackjsy 2014',
	'description' => '',
	'keywords' => ''
);
$heading = 'GET A BUS TO...';

require 'app/views/header.php' ;
?>
 <!-- CONTENT SECTION -->
            <div id="content-home">
                <div class="btn-home-options">
                    <a href="/bus-map.php">
                    <div class="home-icon">
                        <img src="app/views/img/bus_stop_icon.png" alt="bus stop icon" />
                    <p>Find nearest Bus Stop</p>
                    </div>
                    </a>
                </div>

                <div class="btn-home-options">
                    <a href="pick-destination.php">
                    <div class="home-icon">
                         <img src="app/views/img/destination_icon.png" alt="destination icon" />
                    <p>Choose a Destination</p>
                    </div>
                    </a>
                </div>

            </div>
 <!-- END OF CONTENT SECTION -->

<?php 
require 'app/views/footer.php';
