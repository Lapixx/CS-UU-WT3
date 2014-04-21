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

                	$personality_preference = $this->input->post('personality_i') . ',' . $this->input->post('personality_n') . ',' . $this->input->post('personality_t') . ',' . $this->input->post('personality_p');
                	$anon['personality_preference'] = $personality_preference;
                	$anon['personality'] = implode(',', array_map(function ($x) { return 100-$x; }, explode(',', $personality_preference)));

                    $this->anonToUserData($anon);
        			redirect('search/results');
                }
        	else {
                	build_view($this, 'search', $data);
                }
        }

        public function results($page = -1)
        {
            $anon = $this->anonFromUserdata();
            
            $page = intval($page);
            $profiles = $this->usermodel->getSortedMatches($anon);
            if ($page != -1) {
                    build_json($this, paged_results($profiles, $page));
            }
            else {
            		build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'Search results', 'page' => 'search/results', 'pages' => ceil(count($profiles)/6)));
            }
        }

        private function anonFromUserdata()
        {
            $profile = array();
            $profile['firstname'] = $this->session->userdata('anon_firstname');
            $profile['lastname'] = $this->session->userdata('anon_lastname');
            $profile['nickname'] = $this->session->userdata('anon_nickname');
            $profile['gender'] = $this->session->userdata('anon_gender');
            $profile['dob'] = $this->session->userdata('anon_dob');
            $profile['description'] = $this->session->userdata('anon_description');
            $profile['gender_preference'] = $this->session->userdata('anon_gender_preference');
            $profile['min_age'] = $this->session->userdata('anon_min_age');
            $profile['max_age'] = $this->session->userdata('anon_max_age');
            $profile['brands'] = $this->session->userdata('anon_brands');
            $profile['personality'] = $this->session->userdata('anon_personality');
            $profile['personality_preference'] = $this->session->userdata('anon_personality_preference');                
            return $profile;
        }
        
        private function anonToUserdata($anon)
        {
        	$this->session->set_userdata('anon_firstname', $anon['firstname']);
            $this->session->set_userdata('anon_lastname', $anon['lastname']);
            $this->session->set_userdata('anon_nickname', $anon['nickname']);
            $this->session->set_userdata('anon_gender', $anon['gender']);
            $this->session->set_userdata('anon_dob', $anon['dob']);
            $this->session->set_userdata('anon_description', $anon['description']);
            $this->session->set_userdata('anon_gender_preference', $anon['gender_preference']);
            $this->session->set_userdata('anon_min_age', $anon['min_age']);
            $this->session->set_userdata('anon_max_age', $anon['max_age']);
            $this->session->set_userdata('anon_brands', $anon['brands']);
            $this->session->set_userdata('anon_personality', $anon['personality']);
            $this->session->set_userdata('anon_personality_preference', $anon['personality_preference']);                
        }
}