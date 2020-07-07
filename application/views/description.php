<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>
<?php 
  $info = $this->AdminModel->sectionprod($cb);

  $nameproduit=$info['name'];
  if ($info['quantity']=='') {
    $qtery ="inconnue";
  } else {
    $qtery =$info['quantity'];
  }
  if ($info['price'] == "") {
   $price ="inconnue";
  } else {
    $price =$info['price'];
  }
  if ($info['quantity_depot'] == "") {
    $qtedp="inconnue";
  } else {
    $qtedp=$info['quantity_depot'];
  }
  if ($cb == "") {
    $codebare="inconnue";
  } else {
    $codebare=$cb;
  }
  $info2 = $this->AdminModel->sectionform($info['category_id'], 'category');
  
  if ($info2['name'] == "") {
    $category="inconnu";
  } else {
    $category=$info2['name'];
  }
  /*if ($info2['slug'] == "") {
    $surcategory="inconu";
  } else {
    $surcategory=$info2['slug'];
  }*/
  $info2 = $this->AdminModel->sectionform($info['brand'], 'marque');
  if ($info2['name'] == "") {
    $brand="inconnu";
  } else {
    $brand=$info2['name'];
  }
  if ($info['ref'] == "") {
   $ref="inconnue";
  } else {
    $ref=$info['ref'];
  }
  
?>
<style type="text/css">
    video {
        height: 300px;
        width: 100%;
    }

    label{

      font-size: 14px;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Détail Produit</h3>
                </div>
                <div class="panel-body">
                  <form action="<?=site_url('admin/receptionForProduit/'.$id_inventaire)?>" method="POST">
                    <div class="dates ">
                      <h3 class="text-left">
                        <small class="col-md-4 col-lg-12 col-xs-12 text-left">Code barre: </small>
                        <label class="col-md-6 col-lg-6 text-left"><?=$codebare?></label>
                      </h3>
                      <h3 class="text-left">
                        <small class="col-md-4 col-lg-12 col-xs-12 text-left">Nom produit: </small>
                        <label class="col-md-8 text-left"><?=$nameproduit?></label>
                      </h3>
                      <h3 class="text-left">
                        <small class="col-md-4 col-lg-12 col-xs-12 text-left">Référence: </small>
                        <label class="col-md-8 text-left"><?=$ref?>  </label>
                      </h3>
                      <h3 class="text-left">
                        <small class="col-md-4 col-lg-12 col-xs-12 text-left">Categorie: </small>
                        <label class="col-md-8 text-left"><?=$category?></label>
                      </h3>
                      <h3 class="text-left">
                        <small class="col-md-4 col-lg-12 col-xs-12 text-left">Marque: </small>
                        <label class="col-md-8 text-left"><?=$brand?></label>
                      </h3>
                    </div>
                    <div class="dates">
                      <h4>Stock Actuel : <strong><?=round($qtery)?></strong></h4>
                      <div class="ends">
                         <label>Changer ici</label>
                         <input type="number" class="form-control" min="0" value="<?=round($qtery)?>" name="qte"> 
                      </div>
                      <h4>Prix de Vente Actuel : <strong><?=preg_replace("#,#"," ",number_format($price))?></strong></h4>
                      <div class="ends">
                         <label>Changer ici</label>
                         <input style="margin-bottom: 24px;" type="number" class="form-control" min="0" value="<?=round($price)?>" name="prix"> 
                      </div>
                    </div>
                    <div class="dates text-center" style="font-size: 3em;">
                      <input type="hidden" name="mode" value="enregistre">
                      <input type="hidden" name="id_prod" value="<?=$info['id']?>">
                    </div>
                    <div class="dates" style="border: 0px solid transparent;">
                      <a class="btn btn-danger" style="float: left" href="<?=site_url('admin/dossier_de_inventaire/'.$id_inventaire)?>">Retour au scanne</a>
                      <input class="btn btn-primary" type="submit" style="background-color: green;color:#fff;font-size: 1.2em;float: right" value="valider"/>
                    </div>
                  </form>
                </div>
                <div class="panel-footer">
                    <center><a class="btn btn-danger" href="admin/dossier_de_inventaire/">Retour à la liste</a></center>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?=site_url('/assets/js/')?>dist/quagga.js"></script>

<script type="text/javascript">
    

</script>

<?php $this->load->view('templates/_parts/front_master_footer_view');?>
