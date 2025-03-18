<?php
require_once('auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SKYNET IMS</title>

	<link rel="shortcut icon" href="logo.jpg">

	<!-- Bootstrap Core CSS -->
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="../vendor/morrisjs/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- Additional inline styles to ensure the page looks good even if external CSS fails to load -->
	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 14px;
			line-height: 1.42857143;
			color: #333;
			background-color: #f8f8f8;
		}

		#page-wrapper {
			position: relative;
			margin: 0 0 0 250px;
			padding: 65px 30px 30px;
			min-height: calc(100vh - 50px);
			background-color: white;
		}

		.panel {
			margin-bottom: 20px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
		}

		.panel-primary {
			border-color: #337ab7;
		}

		.panel-primary>.panel-heading {
			color: #fff;
			background-color: #337ab7;
			border-color: #337ab7;
			padding: 10px 15px;
		}

		.panel-body {
			padding: 15px;
		}

		.well {
			min-height: 20px;
			padding: 19px;
			margin-bottom: 20px;
			background-color: #f5f5f5;
			border: 1px solid #e3e3e3;
			border-radius: 4px;
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
		}

		.btn {
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 0;
			font-size: 14px;
			font-weight: 400;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			cursor: pointer;
			border: 1px solid transparent;
			border-radius: 4px;
		}

		.btn-success {
			color: #fff;
			background-color: #5cb85c;
			border-color: #4cae4c;
		}

		.btn-info {
			color: #fff;
			background-color: #5bc0de;
			border-color: #46b8da;
		}

		.btn-block {
			display: block;
			width: 100%;
		}

		.page-header {
			padding-bottom: 9px;
			margin: 0 0 20px;
			border-bottom: 1px solid #eee;
		}
	</style>

	<!-- JavaScript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/metisMenu/metisMenu.min.js"></script>

	<!-- Facebox CSS -->
	<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="src/facebox.js" type="text/javascript"></script>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[rel*=facebox]').facebox({
				loadingImage: 'src/loading.gif',
				closeImage: 'src/closelabel.png'
			});

			// Initialize the metisMenu
			$("#side-menu").metisMenu();
		});
	</script>
</head>

<body>
	<div id="wrapper">
		<?php include('navfixed.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Welcome: <strong><?php echo $session_cashier_name; ?></strong></h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Cashier Dashboard</h3>
						</div>
						<div class="panel-body">
							<p>Select one of the following options to proceed:</p>

							<div class="row">
								<div class="col-lg-6">
									<div class="well">
										<h4>Cash Transaction</h4>
										<p>Process a cash-based sale</p>
										<?php
										// We'll use the $finalcode from navfixed.php which is already included
										if (!isset($finalcode)) {
											// If navfixed.php didn't set it (unlikely), we'll create it here
											$finalcode = 'RS-' . rand(10000, 99999);
										}
										?>
										<a href="sales.php?id=cash&invoice=<?php echo $finalcode; ?>" class="btn btn-success btn-block">
											<i class="fa fa-money fa-fw"></i> New Cash Sale
										</a>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="well">
										<h4>Credit Transaction</h4>
										<p>Process a credit-based sale</p>
										<a href="sales.php?id=credit&invoice=<?php echo $finalcode; ?>" class="btn btn-info btn-block">
											<i class="fa fa-credit-card fa-fw"></i> New Credit Sale
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /#page-wrapper -->
	</div>
	<!-- /#wrapper -->

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>