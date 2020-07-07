<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>

<style type="text/css">
    video {
        height: 300px;
        width: 100%;

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
                    <div id="camera" style="height: 300px; width:100%"></div>
                    <hr>
                    <form action="<?=site_url('admin/description_prodution/'.$id_inventaire)?>" method="post">
                        <input type="text" name="name_prod" class="form-control col-md-12 text-center" placeholder="Le nom du produit" value="" onkeyup="verifname()" id="name_prod"><br/>
                        <input type="text" name="ref" class="form-control col-md-12 text-center" placeholder="La reference" id="ref" value="" ><br/>
                        <input type="text" name="vue" class="form-control col-md-12 text-center" placeholder="CODE BARRE" id="reponses" value="" ><br/>
                        <button type="submit" class="btn btn-primary col-md-12" onclick="lancemme()" style="position: relative;" >lancer</button>
                    </form>
                    <br/>
                    <?php 
                        if ($this->AdminModel->countProduitByinventaire1($id_inventaire)==true) {
                       ?>
                        <button class="btn btn-warning pd0" aria-label="Left Align" type="button" onclick="controleInventaire()">
                            cliquer ici pour fin de l'inventaire
                        </button>
                        <?php
                    }
                    ?>
                </div>
                <div class="panel-footer">
                    <center><a class="btn btn-danger" href="../">Retour en arrière</a></center>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?=site_url('/assets/js/')?>dist/quagga.js"></script>
<!-- <script type="text/javascript">
    function verifname(){
        var base_url = "<?php echo base_url(''); ?>";
        var nom_produit=document.getElementById('name_prod').value;
        if (nom_produit==' ') {
        }else{
            $.ajax({
                url: base_url+'Admin/receptionForName',
                type: 'GET',
                dataType: 'json',
                data : {vueinfo : nom_produit, type : 1},    
                success:function(response) {
                    $.each(response, function(index, values) {
                        var reponseverification = values.nbre;
                        var reference = values.ref;
                        var codebarre = values.code;
                        if (reponseverification == 1) {
                           document.getElementById('testproblem').innerHTML='le nom est incomplete ou inconnu de la boutique';
                        }
                        if (reponseverification == 2) {
                           document.getElementById('testsucces').innerHTML="Ce produit a été enregistrer à l'inventaire";
                            document.getElementById('ref').value = reference;
                            document.getElementById('reponses').value = codebarre;

                        }
                        if (reponseverification == 3) {
                           document.getElementById('testsucces').innerHTML='Ce produit existe';
                           document.getElementById('ref').value = reference;
                            document.getElementById('reponses').value = codebarre;
                        }
                    });
                }
            });
            
        }
        
    }
</script> -->
<script type="text/javascript">
    var base_url = "<?php echo base_url(''); ?>";
    function controleInventaire(){
        var box = bootbox.confirm({ 
            size: "small",
            message: "Inventaire termier, Si vous être sûr cliquez OK; si non ANNULER",
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
    function lancemme(){
        var point = document.getElementById('reponses').value;
        if (point==" ") {
            alert('svp faite le scanne ou entrer le code barre');
        }
        
    }
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#camera') // Or '#yourElement' (optional)
        },
        decoder: {
                readers: [
                'code_128_reader',
                'ean_reader',
                'ean_8_reader',
                'code_39_reader',
                'code_39_vin_reader',
                'codabar_reader',
                'upc_reader',
                'upc_e_reader'

              ]



/*
            readers: ["ean_13_reader"],
             readers : ["code_128_reader"],
             readers : ["i2of5_reader"]
*/            /*
            		     	readers : ["2of5_reader"],
            		      	,

            		      	readers : ["upc_reader"],
            		      	readers : ["codabar_reader"],
            		      	readers : ["code_39_vin_reader"],
            		      	readers : ["code_39_reader"],
            		      readers : ["ean_8_reader"]
            		      
            		      readers : ["ean_13_reader"]*/

        }
    }, function(error) {
        if (error) {
            console.log(error);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });
    Quagga.onDetected(function(data) {
        console.log(data);
        document.querySelector('#reponses').value = data.codeResult.code;
        var info = document.querySelector('#reponses').value;

    });
    

</script>

<?php $this->load->view('templates/_parts/front_master_footer_view');?>
