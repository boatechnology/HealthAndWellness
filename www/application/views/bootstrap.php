<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('includes/header_bootstrap', $data);

if (!isset($nonav)) {
    $this->load->view('includes/nav', $data);
}

$this->load->view($content , $data);
$this->load->view('includes/footer_js', $data);
$this->load->view('includes/footer_bootstrap', $data);