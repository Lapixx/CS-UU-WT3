<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileForm extends CI_Controller {

	public function index()
	{
        
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('min_age', 'Minimum preferred age', 'required|is_natural|less_than[100]|greater_than[17]');
        $this->form_validation->set_rules('max_age', 'Maximum preferred age', 'required|is_natural|less_than[100]|greater_than[17]|greater_than[' . $this->input->post('min_age') . ']');
        $this->form_validation->set_rules('dob', 'Date of birth', 'required|callback_date_valid');
        $this->form_validation->set_rules('gender_pref', 'Gender preference', 'required');
        $this->form_validation->set_rules('brands', 'Brands', 'callback_brands_valid');
        $this->form_validation->set_rules('brands[]', 'Brands', 'callback_brands_valid');
        
		$this->form_validation->set_message('is_natural', 'Please enter integers');
        $this->form_validation->set_message('is_unique', 'Already in use.');
        $this->form_validation->set_message('required', 'This field is required.');
	}

    public function date_valid($date) {
        $this->form_validation->set_message('date_valid', 'Please enter a valid date between 01-01-1900 and 31-01-' . (date('Y') - 18));        
        $regex = '/^(\d{2})-(\d{2})-(\d{4})$/';

        if (!preg_match($regex, $date, $components)) {
            return false;
        }
    
        list($full, $d, $m, $y) = $components;

        if ($y < 1900 || $y > date('Y') - 18) {
            return false;
        }

        if ($d == 0 || $m == 0) {
            return false;
        }
        
        if ($d > 31 || $m > 12) {
            return false;
        }
        
        if ($d == 31 && ($m % 2 == 0 && $m < 8)) {
            return false;
        }
        
        if ($m == 2 && $d > 29) {
            return false;
        }
        
        $leap = ($y % 4 == 0) && ($y % 100 != 0 || $y % 400 == 0);
        if ($m == 2 && $d == 29 && !$leap) {
            return false;
        }
        
        return true;
    }

    public function brands_valid($brands) {
        $this->form_validation->set_message('brands_valid', 'Please select at least one brand.');
        return !empty($brands);
    }

    public function buildPersonality() {
        $pers = array('I' => 50, 'N' => 50, 'T' => 50, 'P' => 50);

        $answers = $this->input->post('questions');
        foreach ($answers as $i => $ans) {
            $question = $this->questions[$i];
            if ($ans == 'a') {
                $pers[$question[3]] += $question[4];
            }
            else if ($ans == 'b') {
                $pers[$question[3]] -= $question[4];
            }
        }

        $pers['I'] = round($pers['I']);
        $pers['N'] = round($pers['N']);
        $pers['T'] = round($pers['T']);
        $pers['P'] = round($pers['P']);

        return $pers;
    }

    public function buildProfile($anon = false) {
        $profile = array();
        
        $profile['gender'] = $this->input->post('gender');
        $profile['dob'] = $this->input->post('dob');
        $profile['description'] = $this->input->post('description');
        $profile['gender_preference'] = $this->input->post('gender_pref');
        $profile['min_age'] = $this->input->post('min_age');
        $profile['max_age'] = $this->input->post('max_age');
        $profile['brands'] = implode(',', $this->input->post('brands'));

		if (!$anon) {
			$profile['firstname'] = $this->input->post('first_name');
			$profile['lastname'] = $this->input->post('last_name');
			$profile['nickname'] = $this->input->post('nickname');
			
	        $personality = $this->buildPersonality();
	        $profile['personality'] = implode(',', $personality);
	        $profile['personality_preference'] = implode(',', array(100 - $personality['I'], 100 - $personality['N'], 100 - $personality['T'], 100 - $personality['P']));
        }

        return $profile;
    }
}