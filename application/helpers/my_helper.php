<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	// Helper For print_r
	function pr($var = '')
	{
		echo "<pre>";
		   print_r($var);	
		echo "</pre>";
	    // die();	
	}

	//Helper For base_url()
	function bs($value = '')
	{
		// public $url = ""
		echo base_url($value);
	}
	// function fa($name='',$attr='')
	// {
	// 	echo "<i class="'fa fa'.-.".$name."-".$attr""></i>";
	// }

	//Helper for $this->load->view()
	function view($value='', $data=array(), $output = false)
	{
		$CI =& get_instance();
		$CI->load->view($value,$data,$output);
	}

	//Helper For thsi->input->post()
	function post($value='')
	{
		$CI =& get_instance();
	    return $CI->input->post($value);
	}

	//helper for var_dump
    function dd($value='')
	{
		echo "<pre>";
		   var_dump($value);	
		echo "</pre>";
		die();
	}

	//Helper for last_query()
	function vd()
	{
		$CI =& get_instance();
		return $CI->db->last_query();
	}



/* End of file custom_helpers.php */
/* Location: ./application/helpers/custom_helpers.php */