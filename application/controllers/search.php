<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class Search extends ProfileForm {

	
	public function personality_level($x) {
		return ($x >= 0 && $x <= 100);
	}
	
	public function index()
	{
        ProfileForm::index();
        
        //	$mbti_types = array('IE','NS','TF','PJ')
        // Extrovert (E) versus Introvert (I).
        // Intuitive (N) versus Sensing (S).
        // Thinking (T) versus Feeling (F).
        // Judging (J) versus Perceiving (P).
        
        $this->form_validation->set_rules('personality_i', 'Introversion level', 'required|callback_personality_level');
        $this->form_validation->set_rules('personality_n', 'Intuition level', 'required|callback_personality_level');
        $this->form_validation->set_rules('personality_t', 'Thinking level', 'required|callback_personality_level');
        $this->form_validation->set_rules('personality_p', 'Perceiving level', 'required|callback_personality_level');

		$this->form_validation->set_message('personality_level', 'This value should lie between 0 and 100');        

        $data = array('brands' => $this->brandmodel->getAllBrandNames());
        if ($this->form_validation->run()) {
        	$anon = $this->buildProfile(true);
        	$anon['userid'] = -1;
          
        	$personality_preference = $this->input->post('personality_i') . ',' .$this->input->post('personality_n') . ',' .$this->input->post('personality_t') . ',' .$this->input->post('personality_p');
        	$anon['personality_preference'] = $personality_preference;
        	$anon['personality'] = implode(',', array_map(function ($x) { return 100-$x; }, explode(',', $personality_preference)));

			$profiles = $this->usermodel->getSortedMatches($anon);
			build_view($this, 'profile_list', array('profiles' => $profiles, 'title' => 'Search results'));
        }
		else {
        	build_view($this, 'search', $data);
        }
	}
}