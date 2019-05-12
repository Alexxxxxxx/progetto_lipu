<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

	getHeaderHTML("ITIS","STATISTICS",$dblipu);
?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistics & Searching - <?php echo strtoupper($_GET['stat']) ?></h1>
            </div>
        </div>

        <?php 

		if($_GET['stat'] == 'fm_F') 
			$script="statFMF.php";
		elseif($_GET['stat'] == 'fm_M')
		     $script="statFMM.php";
		elseif($_GET['stat'] == 'vgm')
            $script="statVGM.php";	
        else			
		   $script="statHistory.php";
	   
		   if(! isset($_POST["date_start"])){
			   $date_end=date("Y-m-d");
			   $date_start=day_shift(date("j"),date("n"),date("Y"),-30);
		   }
			else{
			   $date_start=$_POST["date_start"];
			   $date_end=$_POST["date_end"];
		   }
		   if(isSet($_GET['stat'])) : 
		    
			?>
            <!-- ::::::::::::::::::::::::::::: FM STATS ::::::::::::::::::::::::::::: -->

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-10">
                			<br>
                			<form class="form-horizontal" action="<?php echo $script; ?>" method="GET">
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<label>Date start (yyyy-mm-dd)</label>
											<input name="date_start" type="text" class="form-control incheck-date" maxlength="10" value="<?php echo $date_start; ?>">
										</div>
									</div>
								</div>	
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
											<label>Date end. (yyyy-mm-dd)</label>
											<input name="date_end" type="text" class="form-control incheck-date" maxlength="10" value="<?php echo $date_end; ?>">
										</div>
									</div>			
								</div>	
                				<div class="form-group">
                					<div class="col-sm-offset-4 col-sm-8">
                						<input type="submit" class="btn btn-default" value="Submit">
                					</div>
                				</div>
                			</form>
                		
						


                        

                    </div> <!-- Fine panel-body -->
                </div>
            </div>

            <!-- ::::::::::::::::::::::::::::: END FM STATS ::::::::::::::::::::::::::::: -->
        <?php endif; ?>

    </div>

<?php

    getFooterHTML();
	//	Chiudo la connessione
	$connection->close();
?>
