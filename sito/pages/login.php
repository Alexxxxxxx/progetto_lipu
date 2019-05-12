<?php
	require_once "library.php";
	require_once "settings.php";

	if (!isset($_POST['username']) || !isset($_POST['password'])||!isset($_POST['dblipu'])){
		if(isset($_GET['err'])){
			$err = $_GET['err'];
			if($err==1){
				$err_str = "Username error";
			}
			else if($err==2){
				$err_str = "Password error";
			}
			else if($err==3){
				$err_str = "Correct logout";
			}
			else{
				$err_str = "Error during login";
			}
		}
		else
			$err_str = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LIPU Provincia di Livorno - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
						<h3 class='panel-title'>Inserisci le tue credenziali</h3>					
                    </div>
                    <div class="panel-body">
                    	<?php if($err_str!=""){ ?>
	                    <div class="alert alert-danger">
		    	        	<?php echo $err_str; ?>
		        		</div>
		        		<?php } ?>
                        <form role="form" action="login.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="dblipu" id="dblipu">
										<?php
											//Elenca i vari possibili dblipu con il relativo database
											foreach($DB_lipu as $DB_lipu => $db_name)
												echo "<option value='$db_name'>$DB_lipu</option>";
										?>
									</select>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="LOGIN">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
	}
	else {

		//Il dblipu costituisce il nome del database. Controlla che sia all'interno dei possibili dblipu $DB_lipu
		$dblipu = $_POST['dblipu'];
		if(!in_array($dblipu, $DB_lipu)) {
			header("location: login.php?err=4");
			die();
		}

		$connection = new mysqli($db_path, $db_user, $db_pass, $dblipu);
		$username = mysqli_real_escape_string($connection, $_POST['username']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);

		if (strlen($username) != 0 && strlen($password) != 0){
			$query ="SELECT * FROM user WHERE user = '$username'";
			$result = $connection->query($query);
			if ($result->num_rows == 0) {
				header("location: login.php?err=1");
			}
			else {
				$user_row = $result->fetch_array();
				// cifratura e verifica della password
				$password = crypt($password, $seed);
				if ($password == $user_row['password']) {
					// distruzione eventuale sessione
					// precedente
					session_start();
					session_unset();
					session_destroy();
					// inizializzazione nuova sessione
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['start_time'] = time();
					$_SESSION['DB_username'] = $user_row['user'];
					$_SESSION['DB_password'] = $user_row['password'];
					$_SESSION['DB_lipu'] = $dblipu;
					$_SESSION['is_mobile'] = $user_row['is_mobile'];
					$_SESSION['is_admin'] = $user_row['is_admin'];

					// controlla se si tratta di un depot o di un dblipu
					$query ="SELECT depot FROM settings";
					$result = $connection->query($query);
					// in caso di errori, imposta dblipu
					$_SESSION['is_depot'] = 0;
					if($result != NULL) {
						$row = $result->fetch_array();
						$_SESSION['is_depot'] = $row[0];
					}

					header("location: index.php");
				}
				else {
					header("location: login.php?err=2");
				}
			}
			$result->free();
			$connection->close();
		}
		else {
			header("location: login.php?err=4");
		}
	}
?>
