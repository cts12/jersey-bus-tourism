<?php 


class homecontroller {


	public function __construct(){

		return $this;
	}

	function index($app){
		
		$app->render('views/homeview.php');

}



} 