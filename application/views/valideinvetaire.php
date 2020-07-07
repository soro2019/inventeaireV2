<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>

<div class="container">
    <br>
    
    <br>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h4>Total : <?php echo count($listproduit);?> Produits</h4>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <?php //$listinventairesnotvalided = false;
                            if($listproduit==false){
                                 ?>   
                                    <ul class="fa-ul col-sm-12">
                                      <li><i  style="position: initial;"class="fa-li fa fa-spinner fa-spin fa-5x"></i></li>
                                    </ul>

                                 <?php
                            }
                            else{?>

                            <?php if(!empty($this->session->flashdata('message'))) {   ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php
                              echo $this->session->flashdata('message');
                              ?>
                                </div>
                                <?php  }if(!empty($this->session->flashdata('errors'))) { ?><div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php
                              echo $this->session->flashdata('errors');
                              ?>
                                </div>
                                <?php  } ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listproduit as $listproduit) {  

                          $row = $this->AdminModel->selectProduitByID($listproduit->id_products);
                          //var_dump($row);die;
                        ?>  
                                    <tr>
                                        <td><?=$row->code?></td>
                                        <td style='font-size: 12px;'><?php echo $row->name?></td>
                                        <td><?=preg_replace("#,#"," ",number_format($listproduit->qte))?></td>
                                        <td><?=preg_replace("#,#"," ",number_format($listproduit->unit_price))?></td>
                                        <td><button type="button" class="btn btn-success btnmoi2" data-backdrop="static" data-toggle="modal" data-target="#myModal2<?=$row->id?>" style='margin-bottom: 10px;'>Valider</button>


                                        <div id="myModal2<?=$row->id?>" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                  Êtes vous sûre ?
                                                </h4>
                                              </div>
                                              <div class="modal-body">
                                                <p>
                                                Quantité : <?=preg_replace("#,#"," ",number_format($listproduit->qte))?><br/><br/>
                                                Prix : <?=preg_replace("#,#"," ",number_format($listproduit->unit_price))?>
                                                </p>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Non</button>
                                                <a type="submit" class="btn btn-success btnmoi" href="<?=site_url('admin/validationinventaireByproduit/'.$row->id)?>">Oui</a>
                                              </div>
                                            </div>
                                          </div>
                                      </div>



                                          <div id="myModal<?=$row->id?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h6 class="modal-title">Nom : <?php if( strlen($row->name) > 28){
                                                      $ts = str_split($row->name, 28);
                                                      foreach($ts as $value){
                                                        echo $value;
                                                      }
                                                  }else{echo $row->name;} ?> <br>
                                                    Code : <?=$row->code?> <br>
                                                    Ref : <?=$row->ref?> <br>
                                                  </h6>
                                                </div>
                                                <form action="<?=site_url('admin/corrections')?>" method="post">
                                                  <div class="modal-body">
                                                  <p>
                                                   
                                                      Quantité : <input class="form-control" value="<?=$listproduit->qte?>" name="quantity">
                                                      Prix : <input class="form-control" value="<?=$listproduit->unit_price?>" name="price">

                                                      <input type='hidden' value="<?=$row->id?>" name="id_pro">
                                                  </p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <input type="submit" name="btncorrige" class="btn btn-success" value="Corriger et Valider">
                                                  </div>
                                                </div> 
                                            </form>
                                            </div>
                                          </div>

                                          <!--  <button type="submit" style='margin-top: 25;' class="btn btn-primary btnmoi2" onclick="correctionProduts()">Corriger</button> -->
                                        </td><td><button type="button" class="btn btn-primary btnmoi2" data-backdrop="static" data-toggle="modal" data-target="#myModal<?=$row->id?>">Correction</button></td>
                                    </tr>
                                <?php  }
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<!-- Modal -->


<script type="application/javascript">
    $(function() {
        $(".table-wrap").each(function() {
            var nmtTable = $(this);
            var nmtHeadRow = nmtTable.find("thead tr");
            nmtTable.find("tbody tr").each(function() {
                var curRow = $(this);
                for (var i = 0; i < curRow.find("td").length; i++) {
                    var rowSelector = "td:eq(" + i + ")";
                    var headSelector = "th:eq(" + i + ")";
                    curRow.find(rowSelector).attr('data-title', nmtHeadRow.find(headSelector).text());
                }
            });
        });
    });

</script>
<?php $this->load->view('templates/_parts/front_master_footer_view');?>
