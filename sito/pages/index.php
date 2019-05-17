<?php
		require_once "session.php";
		require_once "settings.php";
		require_once "library.php";

		if(isset($_SESSION['DB_lipu']))
			$dblipu = $_SESSION['DB_lipu'];
		else
			header("location: login.php");
		getHeaderHTML("LIPU","Home",$dblipu);
?>

<div id="page-wrapper">
    <div class="row">
    	<div class="col-lg-12">
            <?php 
				$user = $_SESSION['username'];
				echo "<h1 class='page-header'>Benvenuto, $user</h1>"; 
			?>
        </div>		
    </div>
	<div class="row">
    	<div class="col-lg-12">
		<!--  <body background="background.png"> -->
          <img class = "img-responsive" src="<?php echo $pathImgPg.'background.jpg';?>" align="center" >
        </div>
    </div>
</div>
            
                

<?php
	getFooterHTML();
?>		