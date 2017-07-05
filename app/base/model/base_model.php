<?php
class base_model extends spModel
{
	public function __construct(){
	  parent::__construct();
      $this->db_prefix = $GLOBALS['G_SP']['db']['prefix'];
	}
}