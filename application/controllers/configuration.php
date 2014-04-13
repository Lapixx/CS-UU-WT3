<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends CI_Controller {

	public function index()
	{
		$this->form_validation->set_rules('distance_measure', 'Distance measure', 'required');
		$this->form_validation->set_rules('x', 'X', 'required|callback_valid_factor');
		$this->form_validation->set_rules('alpha', 'Alpha', 'required|callback_valid_factor');

        $data = $this->configmodel->getSettings();
        if ($this->form_validation->run()) {
        	$this->configmodel->setSettings(array('mix_weight' => $this->input->post('x'),
        										  'match_type' => $this->input->post('distance_measure'),
        										  'alpha' => $this->input->post('alpha')));
        	$data = $this->configmodel->getSettings();
        }
        build_view($this, 'configuration', $data);
	}

	public function valid_factor($x) {
		return $x >= 0 && $x <= 1;
	}
}