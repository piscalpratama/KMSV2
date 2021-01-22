<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<link rel="icon" href="<?=base_url()?>assets/img/logo_uin.png">
		<title><?=$title?></title>

		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/adminlte.min.css">
		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

		<?php $this->load->view($css); ?>
	</head>
	<body class="hold-transition layout-top-nav">
		<div class="wrapper">
			<!-- Navbar -->
			<?php $this->load->view('layout/navbar'); ?>
			<!-- /.navbar -->
			<!-- Content Wrapper. Contains page content -->
			<?php $this->load->view($content); ?>
			<!-- /.content-wrapper -->

			<!-- Control Sidebar -->
			<?php $this->load->view('layout/sidebar'); ?>
			<!-- /.control-sidebar -->

			<!-- Main Footer -->
			<?php $this->load->view('layout/footer'); ?>
		</div>
		<!-- ./wrapper -->

		<?php $this->load->view($modal); ?>

		<!-- REQUIRED SCRIPTS -->

		<!-- jQuery -->
		<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?=base_url()?>assets/js/adminlte.min.js"></script>

		<?php $this->load->view($javascript); ?>
	</body>
</html>