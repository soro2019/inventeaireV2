<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=site_url('/assets/img/favicons/favicon.ico')?>">

    <title>APPLICATION D'INVENTAIRE ALEPH</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=site_url('/assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=site_url('/assets/css/description.css')?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=site_url('/assets/css/style.css')?>" rel="stylesheet">

    <link rel="stylesheet" href="<?=site_url('/assets/css/font-awesome.min.css')?>">
    <script src="<?=site_url('/assets/js/vendor/jquery-slim.min.js')?>"></script>
    <script src="<?=site_url('/assets/js/qrcodelib.js')?>"></script>
    <script src="<?=site_url('/assets/js/webcodecamjquery.js')?>"></script>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
              <?php if($this->uri->segment(2)!=NULL or $this->session->userdata('name')){ ?>
                <button type="button" class="btn navbar-toggle pd0" aria-label="Left Align" onclick="myFunction()">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </button>
              <?php } ?>
                <a class="navbar-brand" href="" disabled>APP INVENTAIRE ALEPH</a>
            </div>
        </div>
    </nav>
    
