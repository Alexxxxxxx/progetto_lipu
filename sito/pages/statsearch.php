<?php
	require_once "session.php";
	require_once "settings.php";
	require_once "library.php";

	if(isset($_SESSION['DB_lipu']))
		$dblipu = $_SESSION['DB_lipu'];
	else
		header("location: login.php");

	$connection = new mysqli($db_path,$db_user,$db_pass,$dblipu);

	getHeaderHTML("ITIS","Yard - LAYOUT",$dblipu);
?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistics & Searching - <?php echo strtoupper($_GET['srch']) ?></h1>
            </div>
        </div>

        <?php 

		if($_GET['srch'] == 'cntr') 
			$search="cntr";
		else
		    $search="bk";
		
	   
		   if(! isset($_POST["keysearch"])){
			   $keysearch="";
		   }
			else{
			   $keysearch=$_POST["keysearch"];
		   }
		   if(isSet($_GET['srch'])) : 
		    
			?>
            <!-- ::::::::::::::::::::::::::::: FM SEARCH ::::::::::::::::::::::::::::: -->

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-10">
                			<br>
                			<form class="form-horizontal" action="statSearch_CntrBk.php" method="GET">
								<div class="row">
									<div class="col-lg-2">
										<div class="form-group">
										<?php
											if($search=="cntr"){
												echo "<label>Cntr code:</label>";
												echo '<input name="cntr" class="form-control incheck-alphanum incheck-uppercase" type="text" maxlength="12" value="'.$keysearch.'">';
											}
											else{
												echo "<label>Bk/Bl code:</label>";
												echo '<input name="bk" class="form-control incheck-alphanum incheck-uppercase" type="text" maxlength="12" value="'.$keysearch.'">';	
											}
												/*echo "<input name="cntr" type="text" class="form-control incheck-date" maxlength="10" value="<?php echo $keysearch; ?>">*/
										?>		
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

            <!-- ::::::::::::::::::::::::::::: END FM SEARCH ::::::::::::::::::::::::::::: -->
        <?php endif; ?>

    </div>

<?php

    getFooterHTML();
	//	Chiudo la connessione
	$connection->close();
?>
