<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>


<div class="container page-main">
    <div class="col-md-4 col-md-offset-4">
        <br>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-lock" aria-hidden="true"></i> CONNEXION</h3>
            </div>
            <div class="panel-body">
                <?php if(!empty($errors)) {   ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php
              echo $errors;
              ?>
                </div>
                <?php  } ?>

                <form method="post" action="" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login" autocomplete="off" placeholder="Login" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Mot de passe" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-lg btn-success btn-block" name="btnsubmit" value="Connexion" />
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>


<?php $this->load->view('templates/_parts/front_master_footer_view');?>
