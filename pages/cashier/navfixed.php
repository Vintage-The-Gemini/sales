<?php
require_once('auth.php');

// Include a common functions file instead of declaring the function here
if (!function_exists('createRandomPassword')) {
	function createRandomPassword()
	{
		$chars = "003232303232023232023456789";
		srand((float)microtime() * 1000000);
		$i = 0;
		$pass = '';
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}
}

$finalcode = 'RS-' . createRandomPassword();
?>

<style>
	/* Basic navigation styling */
	.navbar {
		background-color: #337ab7;
		color: white;
		position: relative;
		min-height: 50px;
		margin-bottom: 20px;
		border: 1px solid transparent;
	}

	.navbar-brand {
		float: left;
		height: 50px;
		padding: 15px;
		font-size: 18px;
		line-height: 20px;
		color: white;
		text-decoration: none;
	}

	.navbar-top-links {
		margin-right: 0;
		float: right;
	}

	.navbar-top-links li {
		display: inline-block;
	}

	.dropdown-menu {
		position: absolute;
		top: 100%;
		left: 0;
		z-index: 1000;
		display: none;
		float: left;
		min-width: 160px;
		padding: 5px 0;
		margin: 2px 0 0;
		list-style: none;
		font-size: 14px;
		text-align: left;
		background-color: #fff;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
	}

	.sidebar {
		position: fixed;
		top: 51px;
		left: 0;
		width: 250px;
		margin-left: 0;
		border: none;
		border-radius: 0;
		overflow-y: auto;
		background-color: #222;
		bottom: 0;
		overflow-x: hidden;
		padding-bottom: 40px;
	}

	.sidebar .sidebar-nav.navbar-collapse {
		padding-left: 0;
		padding-right: 0;
	}

	.sidebar ul li {
		border-bottom: 1px solid #e7e7e7;
	}

	.sidebar ul li a {
		color: #eee;
		display: block;
		padding: 10px 15px;
		text-decoration: none;
	}

	.sidebar ul li a:hover {
		background-color: #555;
	}

	.sidebar .arrow {
		float: right;
	}

	.sidebar .nav-second-level li a {
		padding-left: 37px;
	}

	#page-wrapper {
		position: inherit;
		margin: 0 0 0 250px;
		padding: 0 30px;
		border-left: 1px solid #e7e7e7;
	}
</style>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="home.php">SKYNET IMS Cashier</a>
	</div>
	<!-- /.navbar-header -->

	<ul class="nav navbar-top-links navbar-right">
		Welcome:<strong> <?php echo $session_cashier_name; ?></strong>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->



	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li>
					<a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<li>
					<a href="#"><i class="fa fa-money fa-fw"></i> Sales<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>">Cash</a>
						</li>
						<li>
							<a href="sales.php?id=credit&invoice=<?php echo $finalcode ?>">Credit</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /.navbar-static-side -->
</nav>