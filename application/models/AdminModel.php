<?php
	if (!defined('BASEPATH'))
	    exit('No direct script access allowed');

	class AdminModel extends CI_Model
	{
	  
	    function __construct()
	    {
	        parent::__construct();
	    }

	    public function userExiste($login, $pass)
	    {
            $this->db->select('*');
		    $this->db->from('jp_user');
		    $this->db->where(array('login'=> $login, 'password'=>$pass));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return true;
		    }else{
		        return false;
		    }
	    }

	    public function infouser($login='', $pass='')
	    {
            $this->db->select('*');
		    $this->db->from('jp_user');
		    $this->db->where(array('login'=> $login, 'password'=>$pass));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
	    }

	    public function verification_($tablename, $verif)
	    {
            $this->db->select('*');
		    $this->db->from($tablename);
		    $this->db->where($verif);
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		         return true;
		    }else{
		        return false;
		    }
	    }

	    public function insertion_($tablename, $data)
	    {
          $this->db->insert($tablename, $data);
          return $this->db->insert_id();
        }

        public function correction($data, $id)
	    {
	      $this->db->where('id_products', $id);
          $this->db->update('jp_inv_products', $data);
          return true;
        }

        public function terminervalidation($data, $idinv)
	    {
	      $this->db->where('id_inventaire', $idinv);
          $this->db->update('jp_inventaire', $data);
          return true;
        }


        


        public function selectInventaireByUser($user_id)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inventaire');
		    $this->db->where(array('user_id'=> $user_id));
		    $this->db->order_by('etat', 'ASC');
		    $this->db->order_by('date_create', 'ASC');
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->result();
		    }else{
		        return false;
		    }
        }

        public function selectInventaireNotValid()
        {
        	$this->db->select('*');
		    $this->db->from('jp_inventaire');
		    $this->db->where(array('etat'=> '1'));
		    $this->db->or_where(array('etat'=> '2'));
		    $this->db->order_by('etat', 'ASC');
			$this->db->order_by('date_create', 'DESC');
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->result();
		    }else{
		        return false;
		    }
        }

        public function verifSelectInventaireByUser($id_user)
        {
		    $sql = "SELECT * FROM jp_inventaire WHERE `user_id` = ? AND (etat = 0 or etat is Null)";
			$query = $this->db->query($sql, array($id_user));
			return $query->num_rows();
        }

        public function inventaireExiste($id)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inventaire');
		    $this->db->where(array('id_inventaire'=>$id,'etat'=>1));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return true;
		    }else{
		        return false;
		    }
        }

        public function inventaireExiste1($id_inv, $user_id)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inventaire');
		    $this->db->where(array('id_inventaire'=>$id_inv,'etat'=>1, 'user_id'=> $user_id));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return true;
		    }else{
		        return false;
		    }
        }
        public function inventaireExiste2($id_inv, $user_id)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inventaire');
		    $this->db->where(array('id_inventaire'=>$id_inv, 'user_id'=> $user_id));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return true;
		    }else{
		        return false;
		    }
        }

        public function countProduitByinventaire($id_inventaire)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inv_products');
		    $this->db->where(array('id_inv'=>$id_inventaire, 'etat'=>0));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->result();
		    }else{
		        return false;
		    }
        }

        public function countProduitByinventaire3($id_inventaire)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inv_products');
		    $this->db->where(array('id_inv'=>$id_inventaire, 'etat'=>1));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->result();
		    }else{
		        return false;
		    }
        }

        public function countProduitByinventaire1($id_inventaire)
        {
        	$this->db->select('*');
		    $this->db->from('jp_inv_products');
		    $this->db->where(array('id_inv'=>$id_inventaire));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return true;
		    }else{
		        return false;
		    }
        }


        public function selectProduitByID($idproduit)
        {
        	$this->db->select('*');
		    $this->db->from('sma_products');
		    $this->db->where(array('id'=>$idproduit));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row();
		    }else{
		        return false;
		    }
        }

        public function sectionprod($cb=""){
        	$this->db->select('*');
		    $this->db->from('sma_products');
		    $this->db->where(array('code'=> $cb));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
        }
        public function sectionrefprod($ref=""){
        	$this->db->select('*');
		    $this->db->from('sma_products');
		    $this->db->where(array('ref'=> $ref
		));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
        }
        public function sectionameprod($name=""){
        	$this->db->select('*');
		    $this->db->from('sma_products');
		    $this->db->where(array('name'=> $name));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
        }


        public function sectionform($id="",$nametb=""){
        	$this->db->select('*');
        	if ($nametb=='category') {
        		$tableau='sma_categories';
        	}
        	if ($nametb=='marque') {
        		$tableau='sma_brands';
        	}
		    $this->db->from($tableau);
		    $this->db->where(array('id'=> $id));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
        }
        public function verfiExisteProd($info="", $type=""){
        	$this->db->select('*');
		    $this->db->from('sma_products');
		    $this->db->where(array($type=> $info));
		    $query = $this->db->get();
		    if($query->num_rows() > 0){
		        return $query->row_array();
		    }else{
		        return false;
		    }
        }


	}