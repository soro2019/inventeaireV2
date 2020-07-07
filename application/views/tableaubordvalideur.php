<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/_parts/front_master_header_view'); ?>
<meta http-equiv="Refresh" content="5; url=<site_url('admin/tableaubord')>">

<div class="container">
    <br>
    
    <br>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="fa fa-home"></span> Liste des inventaires non validaté</h3>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <?php 
                            if($listinventairesnotvalided==false){
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
                            <th>Nom</th>
                            <th>Commencé le</th>
                            <th>Fini le</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            
                                foreach ($listinventairesnotvalided as $listinventaire) {  ?>
                                    <tr>
                                        <td><?=$listinventaire->nom_inventaire?></td>
                                        <td><?=date("d/m/Y H:i:s", $listinventaire->date_create)?></td>
                                        <td><?=date("d/m/Y H:i:s", $listinventaire->date_end)?></td>
                                        <td>
                                            <?php if($listinventaire->etat == 2){ ?>
                                            <div class="statut"><span class="label label-success">En cour de validation</span></div>
                                            <?php } if($listinventaire->etat == 1){ ?>
                                            <div class="statut"><a href="<?=site_url('admin/valideinvetaire/'.$listinventaire->id_inventaire)?>" class="label label-success">A vérifier</span></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  }
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

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










<!-- <html>
	<head>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="<?=site_url('/assets/css/fonte.css')?>">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?=site_url('/assets/css/style.login.css')?>">
	</head>
	<body>
		
				<div class="container">

					<div class="row">
						<div class="col-sm-12 ">

					        <div class="inbox_people ">
								<div class="headind_srch">
									<div class="recent_heading">
										<h4>Liste de mes inventaires</h4>
									</div>
									<?php //var_dump($listinventaires);die; ?>	
								</div>
					          	<div class="inbox_chat">
					          		<?php foreach ($listinventaires as $listinventaire) {  ?>
						            	<div class="chat_list active_chat">
						              		<div class="chat_people">
						                		<div class="chat_ib">
							                  		<h5><?=$listinventaire->nom_inventaire?> <span class="chat_date">Le <?=date("d/m/Y H:i:s", $listinventaire->date_create)?></span></h5>
							                  		<p><?=$listinventaire->des_inventaire?></p>
						                		</div>
						                		<div class="chat_img" title="la forme"> 
						                			<i style="color:green;margin-left:.3em" class="fa fa-check fa-2x" aria-hidden="true"></i> 
						                		</div>
						              		</div>
							            </div>
						            <?php  } ?>
					            </div>
					    </div>
					</div>
						<div class="col-sm-3 "></div>
						<div class="col-sm-6 ">
						<div class="card moicard">
		                   <a href="<?=site_url('admin/forminventaire')?>" title="Faire un inventaire" class="float"><i class="fa fa-plus my-float"></i></a>
					    </div>
				</div>
				</div>
		
    </body>
</html> -->
