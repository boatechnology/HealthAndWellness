<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('includes/header_crud', $data);
$this->load->view($content, $data);
$this->load->view('includes/footer_crud', $data);
