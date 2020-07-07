<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	private $data;

	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('AdminModel');
    }

	/*public function index()
	{

		if(isset($_POST['btnsubmit']))
		{
			$login = $_POST['login'];
			$password =  $_POST['password'];
			$password = sha1($password);

			if(empty($login) or empty($password))
			{
				//message d'erreur
			}else
			{
                if($this->AdminModel->userExiste($login, $password)==true)
                {
                	$this->session->set_userdata(array('infouser'=>$login, 'timecon'=>time()));
                	redirect(site_url('admin/tableaubord'));
                }else
                {
                	//message d'erreur
                }
			}
		}
		$this->load->view('index', $this->data);
	}*/
    public function index()
	{
		if ($this->session->userdata('name')){
			redirect(site_url('admin/tableaubord'));
		}
        	if(isset($_POST['btnsubmit']))
		    {
			   $login = $_POST['login'];
			   $password =  $_POST['password'];
			   $password_hashed = sha1($password);

			   if(empty($login) or empty($password))
			   {
				  $this->data['errors'] = 'Renseignez tous les champs svp';
				  $this->load->view('login', $this->data);
			   }else
			   {

			      //var_dump($this->AdminModel->userExiste($login, $password));die();
	                 if($this->AdminModel->userExiste($login, $password_hashed)==true)
	                 {

	                	$log = $this->AdminModel->infouser($login, $password_hashed);
	                	$logged_info_in_sess = array(
	           				'iden' => $log['id_user'],
					        'name'     => $log['login'],
					        'speudo' => $log['vuename'],
					        'type' => $log['niveau'],
						);
						$this->session->set_userdata($logged_info_in_sess);
	                	redirect(site_url('admin/tableaubord'));
	                	//var_dump(redirect(site_url('admin/tableaubord')));die;

	                 }else
	                 {
	                	$this->data['errors'] = 'Login ou mot de passe incorrect';
					    $this->load->view('login', $this->data);
	                 }
			    }
            }else{

            	$this->load->view('login', $this->data);
            }
	}


	public function tableaubord()
	{
		if (!$this->session->userdata('name')){
			redirect(site_url('/'));
		}
		if($this->session->userdata('type')==1)
		{
			//valideur
			$this->data['listinventairesnotvalided'] = $this->AdminModel->selectInventaireNotValid();
			$this->load->view('tableaubordvalideur', $this->data);
		}else
		{
			//inventeur
			$user_id = $this->session->userdata('iden');
			$this->data['veriftrans'] = $this->AdminModel->verifSelectInventaireByUser($user_id);
			$this->data['listinventaires'] = $this->AdminModel->selectInventaireByUser($user_id);
			$this->load->view('tableaubordinventaire', $this->data);
		}
	}

	public function valideinvetaire($id_inventaire)
	{
	   	if (!$this->session->userdata('name')){
			redirect(site_url('/'));
		}
	  	if($id_inventaire==NULL or $id_inventaire==0){
		  	$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==false) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				/*if ($this->AdminModel->inventaireExiste1($id_inventaire, $this->session->userdata('iden'))) {
					$this->session->set_flashdata('message_error', "Cet verification est en cours d'utilisation, veillez utiliser un autre");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {*/
					$this->data['listproduit'] = $this->AdminModel->countProduitByinventaire($id_inventaire);
					$this->session->set_userdata('id_inv', $id_inventaire);
					$this->load->view('valideinvetaire', $this->data);
				//}
				
			}	
		}
	}

	


	public function validationinventaireByproduit($idproduit)
	{
		if (!$this->session->userdata('name')){
			redirect(site_url('/'));
		}
	  if($idproduit==NULL or $idproduit==0)
	  {
	  	$this->session->set_flashdata('erros', 'Inventaire inexistant !!!');
	  }else
	  {
	  	 $id_inv = $this->session->userdata('id_inv');
	  	 $nbp_restant = count($this->AdminModel->countProduitByinventaire($id_inv));
	  	 //var_dump($nbp_restant);die;
	  	 if($nbp_restant==1)
	  	 {
	  	 	if($this->AdminModel->correction(array('etat'=>1), $idproduit))
		  	{
		  	  $this->session->set_flashdata('message', 'Validé avec succès');
		  	  $this->AdminModel->terminervalidation(array('etat'=>3, 'date_end'=>time()), $id_inv);
		  	  redirect(site_url('admin/tableaubord'));
		  	}
	  	 }else
	  	 {
	  	 	if($this->AdminModel->correction(array('etat'=>1), $idproduit))
		  	{
		  	  $this->session->set_flashdata('message', 'Validé avec succès');
		  	  redirect(site_url('admin/valideinvetaire/'.$id_inv));
		  	}
	  	 }	
	  	
	  }
	}


	public function corrections()
	{
		if (!$this->session->userdata('name')){
			redirect(site_url('/'));
		}
	  if(isset($_POST['btncorrige']))
	  {
	  	$data = array('qte'=>trim($_POST['quantity']), 'unit_price'=>trim($_POST['price']), 'etat'=>1);
        //var_dump($data);
	  	$idproduit = $_POST['id_pro'];
	  	//var_dump($idproduit);
	  	$id_inv = $this->session->userdata('id_inv');
	  	//var_dump($id_inv);
	  	$nbp_restant = count($this->AdminModel->countProduitByinventaire($id_inv));
	  	//var_dump($nbp_restant);die;
	  	//var_dump($this->AdminModel->correction($data, $idproduit));die;
	  	if($nbp_restant==1)
	  	{
	  		//var_dump($this->AdminModel->correction($data, $idproduit));die;
	  		if($this->AdminModel->correction($data, $idproduit))
	        {
	        	$this->session->set_flashdata('message', 'Corrigé et validé avec succès');
	        	$this->AdminModel->terminervalidation(array('etat'=>3, 'date_end'=>time()), $id_inv);
		  	    redirect(site_url('admin/tableaubord'));
	        	//redirect(site_url('admin/valideinvetaire/'.$id_inv));
	        }
	  	}
	  	else
	  	{
	  		//var_dump($this->AdminModel->correction($data, $idproduit));die;
	  	 	if($this->AdminModel->correction($data, $idproduit))
		  	{
		  	  $this->session->set_flashdata('message', 'Corrigé et validé avec succès');
		  	  redirect(site_url('admin/valideinvetaire/'.$id_inv));
		  	}
	  	}

        

	  }
	}


	
	
	public function forminventaire()
	{
		if(!$this->session->userdata('name')){
			redirect(site_url('/'));
		}
		else{
			
			if ($this->input->post()) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nom', '', 'trim|required');
		        $this->form_validation->set_rules('des', '', 'trim|required');
		        if($this->form_validation->run()===TRUE)
		        {
			
					//var_dump($this->input->post());die;
					if(empty($this->input->post('nom')) or empty($this->input->post('des')))
					{
						$this->session->set_flashdata('message_error1', "L'un des deux information n'est pas correcte");
						$this->session->mark_as_temp('message_error1', 5);
					  	redirect(site_url('admin/forminventaire'));
					}else
					{
						
						$name = $this->input->post('nom');
						$description = $this->input->post('des');
						date_default_timezone_set('Africa/Abidjan');
						$tim = time();
						$status = NULL;
						$user_id = $this->session->userdata('iden');
						$table='jp_inventaire';
						$data = array("nom_inventaire"=>strtoupper($name),
									  "des_inventaire"=>$description,
									  "date_create"=>$tim,
									  "etat"=>$status,
									  "user_id"=>$user_id);
						$data_verif = array("nom_inventaire"=>strtoupper($name));

						if ($this->AdminModel->verification_($table, $data_verif)==false) {
							if($id = $this->AdminModel->insertion_($table, $data)){
								redirect(site_url('admin/dossier_de_inventaire/'.$id));
							}
						} else {
							$this->session->set_flashdata('message_error1', "L'inventaire existe déjà !!!");
						  	$this->session->mark_as_temp('message_error1', 5);
						  	redirect(site_url('admin/forminventaire'));
						}
						
						
					}
					
				} else{
					$this->session->set_flashdata('message_error1', "L'un des deux information n'est pas correcte");
					$this->session->mark_as_temp('message_error1', 5);
				  	redirect(site_url('admin/forminventaire'));
				}
			} else {
				$this->load->helper('form');
				$this->load->view('forminventaire');
			}
			
		}	
	}


	public function commencescanne($id_inventaire='')
	{
		if($id_inventaire==NULL or $id_inventaire==0){
			$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==TRUE) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				if ($this->AdminModel->inventaireExiste2($id_inventaire, $this->session->userdata('iden'))==false) {
					$this->session->set_flashdata('message_error', "Ce n'est pas votre inventaire");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {
					$data = ['id_inventaire' => $id_inventaire];
					$this->load->view('commencescanne',$data);
				}
			}
		}
	}

	public function dossier_de_inventaire($id_inventaire=""){
		if($id_inventaire==NULL or $id_inventaire==0){
			$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==TRUE) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				if ($this->AdminModel->inventaireExiste2($id_inventaire, $this->session->userdata('iden'))==false) {
					$this->session->set_flashdata('message_error', "Ce n'est pas votre inventaire");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {
					$data = ['id_inventaire' => $id_inventaire];
					$this->load->view('viewcodebarre',$data);
				}
			}
		}
	}


	public function description_prodution($id_inventaire=""){
		$_SESSION['message_error4']="";
		if($id_inventaire==NULL or $id_inventaire==0){
			$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==TRUE) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				if ($this->AdminModel->inventaireExiste2($id_inventaire, $this->session->userdata('iden'))==false) {
					$this->session->set_flashdata('message_error', "Ce n'est pas votre inventaire");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {

					if ($this->input->post()) {



						$name_prod=trim($this->input->post('name_prod'));
				        $name_prod = stripslashes($name_prod);
				        $name_prod = htmlspecialchars($name_prod);

				        $ref=trim($this->input->post('ref'));
				        $ref = stripslashes($ref);
				        $ref = htmlspecialchars($ref);

				        $vue=trim($this->input->post('vue'));
				        $vue = stripslashes($vue);
				        $vue = htmlspecialchars($vue);


				        

						$name_prod = strtoupper($name_prod);
						$ref = strtoupper($ref);
						

						if ($vue=='') {
							if ($name_prod=="") {
								if ($ref=='') {
									$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
								  	$this->session->mark_as_temp('message_error4', 2);
								  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
								} else {
									if ($this->AdminModel->verfiExisteProd($ref,'ref')==false) {
										$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
									  	$this->session->mark_as_temp('message_error4', 2);
									  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
									}else{
										$infoprod=$this->AdminModel->verfiExisteProd($ref,'ref');
										$data = [
											'id_inventaire' => $id_inventaire,
											'cb' => $infoprod['code']
										];
										$this->load->view('description',$data);
									}
								}
							} else {
								if ($this->AdminModel->verfiExisteProd($name_prod,'name')==false) {
									if ($ref=='') {
										$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
									  	$this->session->mark_as_temp('message_error4', 2);
									  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
									} else {
										if ($this->AdminModel->verfiExisteProd($ref,'ref')==false) {
											$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
										  	$this->session->mark_as_temp('message_error4', 2);
										  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
										}else{
											$infoprod=$this->AdminModel->verfiExisteProd($ref,'ref');
											$data = [
												'id_inventaire' => $id_inventaire,
												'cb' => $infoprod['code']
											];
											$this->load->view('description',$data);
										}
									}
								}else{
									$infoprod=$this->AdminModel->verfiExisteProd($name_prod,'name');
									$data = [
										'id_inventaire' => $id_inventaire,
										'cb' => $infoprod['code']
									];
									$this->load->view('description',$data);
								}
							}	
						}
						else{
							if ($this->AdminModel->verfiExisteProd($vue,'code')==false) {
								if ($name_prod=='') {
									
									if ($this->AdminModel->verfiExisteProd($name_prod,'name')==false) {
										if ($ref=='') {
											$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
										  	$this->session->mark_as_temp('message_error4', 2);
										  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
										} else {
											if ($this->AdminModel->verfiExisteProd($ref,'ref')==false) {
												$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
											  	$this->session->mark_as_temp('message_error4', 2);
											  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
											}else{
												$infoprod=$this->AdminModel->verfiExisteProd($ref,'ref');
												$data = [
													'id_inventaire' => $id_inventaire,
													'cb' => $infoprod['code']
												];
												$this->load->view('description',$data);
											}
										}
									}else{
										$infoprod=$this->AdminModel->verfiExisteProd($name_prod,'name');
										$data = [
											'id_inventaire' => $id_inventaire,
											'cb' => $infoprod['code']
										];
										$this->load->view('description',$data);
									}
								} else {
									if ($this->AdminModel->verfiExisteProd($name_prod,'name')==false) {

										if ($this->AdminModel->verfiExisteProd($name_prod,'name')==false) {
											if ($ref=='') {
												$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
											  	$this->session->mark_as_temp('message_error4', 2);
											  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
											} else {
												if ($this->AdminModel->verfiExisteProd($ref,'ref')==false) {
													$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit");
												  	$this->session->mark_as_temp('message_error4', 2);
												  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
												}else{
													$infoprod=$this->AdminModel->verfiExisteProd($ref,'ref');
													$data = [
														'id_inventaire' => $id_inventaire,
														'cb' => $infoprod['code']
													];
													$this->load->view('description',$data);
												}
											}
										}else{
											$infoprod=$this->AdminModel->verfiExisteProd($name_prod,'name');
											$data = [
												'id_inventaire' => $id_inventaire,
												'cb' => $infoprod['code']
											];
											$this->load->view('description',$data);
										}
									}else{
										$infoprod=$this->AdminModel->verfiExisteProd($name_prod,'name');
										$data = [
											'id_inventaire' => $id_inventaire,
											'cb' => $infoprod['code']
										];
										$this->load->view('description',$data);
									}
								}
							} else {
								$data = [
									'id_inventaire' => $id_inventaire,
									'cb' => $vue
								];
								$this->load->view('description',$data);
							}

						}
						
					}else{
						$this->session->set_flashdata('message_error4', "SVP scanner ou tapé le code barre, la reférence ou le nom du produit1");
					  	$this->session->mark_as_temp('message_error4', 5);
					  	redirect('admin/dossier_de_inventaire/'.$id_inventaire);
					}
				}
				
			}	
		}
	}

	public function deconnexion()
	{
		$this->session->unset_userdata(array('iden','speudo','type','name'));
		redirect(site_url('/'));
	}
	
	public function receptionForProduit($id_inventaire){
		if($id_inventaire==NULL or $id_inventaire==0){
			$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==TRUE) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				if ($this->AdminModel->inventaireExiste2($id_inventaire, $this->session->userdata('iden'))==false) {
					$this->session->set_flashdata('message_error', "Ce n'est pas votre inventaire");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {
					if ($this->input->post()) {
						//var_dump($this->input->post());die;
						if(empty($this->input->post('qte')) or empty($this->input->post('prix')))
						{
							//$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
						}else{
							date_default_timezone_set('Africa/Abidjan');
							$tim = time();
							$table='jp_inv_products';
						  	$data = array(
					  			"id_inv"=>$id_inventaire,
								"id_products"=>$this->input->post('id_prod'),
								"qte"=>$this->input->post('qte'),
								"unit_price"=>$this->input->post('prix'),
								"etat"=>0,
								"created"=>$tim
							);

							$data_verif = array(
					  			"id_inv"=>$id_inventaire,
								"id_products"=>$this->input->post('id_prod')
							);
							
							if ($this->AdminModel->verification_($table, $data_verif)==false) {
								$update_etatinven = array('etat' => 0 );
								$this->AdminModel->terminervalidation($update_etatinven, $id_inventaire);

								if($id = $this->AdminModel->insertion_($table, $data)){
									$this->session->set_flashdata('message_error5', "Enregistrer avec succes");
							  		$this->session->mark_as_temp('message_error5', 5);
									redirect(site_url('admin/commencescanne/'.$id_inventaire));
								}
							} else {
								$this->session->set_flashdata('message_error4', "Ce produit est déjà enregistrer");
							  	$this->session->mark_as_temp('message_error4', 5);
							  	redirect(site_url('admin/commencescanne/'.$id_inventaire));
							}
						}
					} else {
						echo "non ok";
					}
				}
			}
		}
	}
	public function endInventaire($id_inventaire){
		if($id_inventaire==NULL or $id_inventaire==0){
			$this->session->set_flashdata('message_error', 'Inventaire inexistant !!!');
		  	$this->session->mark_as_temp('message_error', 5);
		  	redirect('tableau-bord');
		}else
		{
			if ($this->AdminModel->inventaireExiste($id_inventaire)==TRUE) {
				$this->session->set_flashdata('message_error', "Inventaire terminer !!!");
			  	$this->session->mark_as_temp('message_error', 5);
			  	redirect('tableau-bord');
			} else {
				if ($this->AdminModel->inventaireExiste2($id_inventaire, $this->session->userdata('iden'))==false) {
					$this->session->set_flashdata('message_error', "Ce n'est pas votre inventaire");
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				} else {
					$update_etatinven = array('etat' => 1, 'date_end' => time());
					$this->AdminModel->terminervalidation($update_etatinven, $id_inventaire);
					$this->session->set_flashdata('message_error', 'Inventaire '.$id_inventaire.' est terminé');
				  	$this->session->mark_as_temp('message_error', 5);
				  	redirect('tableau-bord');
				}
			}
		}
	}
}
