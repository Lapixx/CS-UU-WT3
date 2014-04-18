<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redirect_404 extends CI_Controller {

	public function index()
	{
		redirect("/home");
	}
}