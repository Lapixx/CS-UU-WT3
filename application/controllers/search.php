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

                        $this->session->set_flashdata($anon);
        		redirect('search/results');
                }
        	else {
                	build_view($this, 'search', $data);
                }
        }

        public function results($page = -1)
        {
                $profile = $this->profileFromFlashdata();
                $page = intval($page);
                $profiles = $this->usermodel->getSortedMatches($profile);
                if ($page != -1) {
                        build_json($this, paged_results($profiles, $page));
                }
                else {
                        build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'Search results', 'page' => 'search/results', 'pages' => ceil(count($profiles)/6)));
                }
                foreach ($profile as $item) {
                        $this->session->keep_flashdata($item);
                }
        }

        private function profileFromFlashdata()
        {
                $profile = array();
                $profile['firstname'] = $this->session->flashdata('firstname');
                $profile['lastname'] = $this->session->flashdata('lastname');
                $profile['nickname'] = $this->session->flashdata('nickname');
                $profile['gender'] = $this->session->flashdata('gender');
                $profile['dob'] = $this->session->flashdata('dob');
                $profile['description'] = $this->session->flashdata('description');
                $profile['gender_preference'] = $this->session->flashdata('gender_preference');
                $profile['min_age'] = $this->session->flashdata('min_age');
                $profile['max_age'] = $this->session->flashdata('max_age');
                $profile['brands'] = $this->session->flashdata('brands');
                $profile['personality'] = $this->session->flashdata('personality');
                $profile['personality_preference'] = $this->session->flashdata('personality_preference');
                return $profile;
        }
}