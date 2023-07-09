<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Service Order | <?= $this->renderSection('title') ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= site_url('admin_lte')?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= site_url('admin_lte')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= site_url('admin_lte')?>/dist/css/adminlte.min.css">

  <?= $this->renderSection('styles') ?>

</head>
<body class="hold-transition login-page">
  <?= $this->renderSection('content')?>

  
  <!-- jQuery -->
  <script src="<?= site_url('admin_lte')?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= site_url('admin_lte')?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= site_url('admin_lte')?>/dist/js/adminlte.min.js"></script>
  <?= $this->renderSection('scripts')?>
</body>
</html>
