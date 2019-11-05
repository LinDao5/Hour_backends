<?php
/**
* @package     oauth2
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2015
* @version     15.6.25
**/
defined('BASEPATH') OR exit('No direct script access allowed');


class PasswordCredentials extends CI_Controller {

    function __construct(){
//        @session_start();
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('date');

        $this->load->model('OauthUser_model');
        $this->load->model('Api_model');

        $this->load->library("Server", "server");

    }    

    function index(){
        $result = $this->server->password_credentials();
        $this->session->set_userdata('num', 0);
    }




}
