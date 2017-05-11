<!DOCTYPE html>
<html lang="en">
<html>
  <head>
    <title>Interface</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

       <meta name="description" content="">
       <meta name="author" content="">

       <title>LPA - eComms</title>

       <!-- Bootstrap Core CSS -->
       <link href="css/bootstrap.min.css" rel="stylesheet">

       <!-- Custom CSS -->
       <link href="css/sb-admin.css" rel="stylesheet">

       <!-- Custom Fonts -->
       <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->
    <link href="css/app.css" rel="stylesheet" type="text/css">

    <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>



    <script src="js/script.js" type="text/javascript"></script>
  </head>
  <body>
  <div id="wrapper" class="fill" style="min-height: 100% !important">
    <!-- Navigation -->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">LPA - eComms</a>
      </div>
      <!-- Top Menu Items -->
      <ul class="nav navbar-right top-nav">
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $displayName ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li>
                      <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                  </li>
                  <li class="divider"></li>
                  <li>
                      <a href="login.php?killses=true"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                  </li>
              </ul>
          </li>
      </ul>
      <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
              <li class="active">
                  <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Home</a>
              </li>
              <li>
                  <a href="stock.php"><i class="fa fa-fw fa-table"></i> Stock</a>
              </li>
              <li>
                  <a href="sales.php"><i class="fa fa-fw fa-bar-chart-o"></i> Sales</a>
              </li>
          </ul>
      </div>
      <!-- /.navbar-collapse -->
  </nav>
  <!-- ./Navigation -->
<div id="page-wrapper">
  <div class="container">
