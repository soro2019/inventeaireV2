<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>
<style type="text/css">

    
    .material-button-anim {
      position: relative;
      padding: 5% 15px 27px;
      text-align: center;
      max-width: 320px;
      margin: 0 auto 20px;
    }

    .material-button {
        position: relative;
        top: 0;
        z-index: 1;
        width: 70px;
        height: 70px;
        font-size: 1.5em;
        color: #fff;
        background: #2C98DE;
        border: none;
        border-radius: 50%;
        box-shadow: 0 3px 6px rgba(0,0,0,.275);
        outline: none;
    }
    .material-button-toggle {
        z-index: 3;
        width: 90px;
        height: 90px;
        margin: 0 auto;
    }
    .material-button-toggle span {
        -webkit-transform: none;
        transform:         none;
        -webkit-transition: -webkit-transform .175s cubic-bazier(.175,.67,.83,.67);
        transition:         transform .175s cubic-bazier(.175,.67,.83,.67);
    }
    .material-button-toggle.open {
        -webkit-transform: scale(1.3,1.3);
        transform:         scale(1.3,1.3);
        -webkit-animation: toggleBtnAnim .175s;
        animation:         toggleBtnAnim .175s;
    }
    .material-button-toggle.open span {
        -webkit-transform: rotate(45deg);
        transform:         rotate(45deg);
        -webkit-transition: -webkit-transform .175s cubic-bazier(.175,.67,.83,.67);
        transition:         transform .175s cubic-bazier(.175,.67,.83,.67);
    }

    #options {
      height: 70px;
    }
    .option {
        position: relative;
    }
    .option .option1,
    .option .option2,
    .option .option3 {
        filter: blur(5px);
        -webkit-filter: blur(5px);
        -webkit-transition: all .175s;
        transition:         all .175s;
    }
    .option .option1 {
        -webkit-transform: translate3d(90px,90px,0) scale(.8,.8);
        transform:         translate3d(0px,100px,0) scale(.8,.8);
    }
    .option .option2 {
        -webkit-transform: translate3d(0,90px,0) scale(.8,.8);
        transform:         translate3d(0,90px,0) scale(.8,.8);
    }
    .option .option3 {
        -webkit-transform: translate3d(-90px,90px,0) scale(.8,.8);
        transform:         translate3d(0px,15px,0) scale(.8,.8);
    }
    .option.scale-on .option1, 
    .option.scale-on .option2,
    .option.scale-on .option3 {
        filter: blur(0);
        -webkit-filter: blur(0);
        -webkit-transform: none;
        transform:         none;
        -webkit-transition: all .175s;
        transition:         all .175s;
    }
    .option.scale-on .option2 {
        -webkit-transform: translateY(-28px) translateZ(0);
        transform:         translateY(-28px) translateZ(0);
        -webkit-transition: all .175s;
        transition:         all .175s;
    }

    @keyframes toggleBtnAnim {
        0% {
            -webkit-transform: scale(1,1);
            transform:         scale(1,1);
        }
        25% {
            -webkit-transform: scale(1.4,1.4);
            transform:         scale(1.4,1.4); 
        }
        75% {
            -webkit-transform: scale(1.2,1.2);
            transform:         scale(1.2,1.2);
        }
        100% {
            -webkit-transform: scale(1.3,1.3);
            transform:         scale(1.3,1.3);
        }
    }
    @-webkit-keyframes toggleBtnAnim {
        0% {
            -webkit-transform: scale(1,1);
            transform:         scale(1,1);
        }
        25% {
            -webkit-transform: scale(1.4,1.4);
            transform:         scale(1.4,1.4); 
        }
        75% {
            -webkit-transform: scale(1.2,1.2);
            transform:         scale(1.2,1.2);
        }
        100% {
            -webkit-transform: scale(1.3,1.3);
            transform:         scale(1.3,1.3);
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Scan du Code-barres</h3>
                </div>
                <div class="panel-body text-center">
                     <div class="form-group">
                        <?php if(!empty($_SESSION['message_error5'])) {   ?>
                         
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <label id="testemise"><?php echo $_SESSION['message_error5']; ?></label>
                          
                        </div>
                        <?php  } ?>
                        <?php if(!empty($_SESSION['message_error4'])) {   ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $_SESSION['message_error4']; ?>
                        </div>
                        <?php  } ?>
                      </div>

                        <div class="material-button-anim">
                          <ul class="list-inline" id="options">
                            <li>Cliquez sur le boutton bleu pour scanner</li>
                          </ul>
                          <button class="material-button material-button-toggle" type="button">
                            <a href="<?=site_url('admin/dossier_de_inventaire/'.$id_inventaire)?>"><i class="fa fa-barcode" style="color: #fff;"></i></a>
                          </button>
                        </div> 
                        <?php 
                        
                        if($this->AdminModel->countProduitByinventaire1($id_inventaire)==true) {
                           ?>
                            <button class="btn btn-warning pd0" aria-label="Left Align" type="button" onclick="controleInventaire()">
                                Cliquer ici pour fin de l'inventaire
                            </button>
                            <?php
                        }
                        ?>
                        
                    
                </div>
                <div class="panel-footer">
                    <div class='row'>
                      <div class="col-sm-6">

                      </div>
                    </div>
                    <center><a class="btn btn-danger" href="../">Retour en arrière</a></center>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function controleInventaire(){
    var box = bootbox.confirm({ 
        size: "small",
        message: "Inventaire termier, Si vous être sûr cliquez OK, sinon ANNULER",
        callback: function(result){ 
             /* result is a boolean; true = OK, false = Cancel*/
             if(result==true)
             {
                var url = "<?php echo site_url('admin/endInventaire/'.$id_inventaire) ?>";
                window.setTimeout(function(){
                        // Move to a new location or you can do something else
                        window.location.href =  url;

                    }, 300);
                //window.location.href = url;
             }
      }
    })
 }
</script>

<?php $this->load->view('templates/_parts/front_master_footer_view');?>
