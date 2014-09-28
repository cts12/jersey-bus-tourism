<?php
$meta = array(
	'title' => 'Get a Bus | Omnibus #hackjsy 2014',
	'description' => '',
	'keywords' => ''
);
$heading = 'PICK A DESTINATION';

require 'app/views/header.php' ;
?>
 <!-- CONTENT SECTION -->
            <div id="content-pick-destination">

                <div class="destination-box ">
                    <a href="/bus-map.php">
                    <div class="home-icon">
                        <img src="app/views/img/destination_icon.png" alt="bus stop icon" />
                    <p>Town</p>
                    </div>
                    </a>
                </div>

                <a href="/connect.php">
                <div class="destination-box">
                    
                    <div class="home-icon">
                         <img src="app/views/img/logo_zoo.png" alt="zoo logo" />
                    <p>Durrell</p>
                    </div>
                </a>
                </div>


            </div>
 <!-- END OF CONTENT SECTION -->

<?php 
require 'app/views/footer.php';
