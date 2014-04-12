<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileForm extends CI_Controller {

	public function index()
	{
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('pass_conf', 'Password confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('first_name', 'First name', 'required|alpha');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|alpha');
        $this->form_validation->set_rules('nickname', 'Nickname', 'required|is_unique[profiles.nickname]|alpha_dash');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('min_age', 'Minimum preferred age', 'required|is_natural|less_than[100]|greater_than[17]');
        $this->form_validation->set_rules('max_age', 'Maximum preferred age', 'required|is_natural|less_than[100]|greater_than[17]|greater_than[' . $this->input->post('min_age') . ']');
        $this->form_validation->set_rules('dob', 'Date of birth', 'required|callback_date_valid');
        $this->form_validation->set_rules('description', 'About you', 'required');
        $this->form_validation->set_rules('gender_pref', 'Gender preference', 'required');
        $this->form_validation->set_rules('brands[]', 'Brands', 'callback_brands_valid');
        $this->form_validation->set_rules('questions', 'Questions', 'callback_questions_valid');

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

    public function questions_valid($questions) {
        $this->form_validation->set_message('questions_valid', 'Please answer all the questions.');
        return count($questions) == count($this->questions);
    }

    private function buildPersonality() {
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

    private function buildProfile() {
        $profile = array();

        $profile['firstname'] = $this->input->post('first_name');
        $profile['lastname'] = $this->input->post('last_name');
        $profile['nickname'] = $this->input->post('nickname');
        $profile['gender'] = $this->input->post('gender');
        $profile['dob'] = $this->input->post('dob');
        $profile['description'] = $this->input->post('description');
        $profile['gender_preference'] = $this->input->post('gender_pref');
        $profile['min_age'] = $this->input->post('min_age');
        $profile['max_age'] = $this->input->post('max_age');
        $profile['brands'] = implode(',', $this->input->post('brands'));

        $personality = $this->buildPersonality();
        $profile['personality'] = implode(',', $personality);
        $profile['personality_preference'] = implode(',', array(100 - $personality['I'], 100 - $personality['N'], 100 - $personality['T'], 100 - $personality['P']));

        return $profile;
    }

    // (Question number, Option A, Option B, Option C, Affected parameter, Effect in %)
    private $questions = array(
            array('I prefer large groups of people, with a high degree of diversity.', 'I prefer intimate gatherings with only close friends.', 'I am really inbetween.', 'I', '-10'),
            array('I act first, then think.', 'I think first, then act.', 'I am really inbetween.', 'I', '-10'),
            array('I am easily distracted and am less interested in specific tasks.', 'I can concentrate well and am less interested in the big picture.', 'I am really inbetween.', 'I', '-10'),
            array('I am a good speaker and enjoy going out.', 'I am a good listener and am more of a private person.', 'I am really inbetween.', 'I', '-10'),
            array('When hosting an event, I am always at the centre of attention.', 'When hosting an event, I work quietly behind the scenes to make sure everything goes smoothly.', 'I am really inbetween.', 'I', '-10'),
            array('I prefer concepts and learning based on associations.', 'I prefer observations and learning based on facts.', 'I am really inbetween.', 'N', '12.5'),
            array('I have an active imagination and have a global overview of a project.', 'I am pragmatic and have an detailed knowledge of every step.', 'I am really inbetween.', 'N', '12.5'),
            array('I look to the future.', 'I keep my focus on the present.', 'I am really inbetween.', 'N', '12.5'),
            array('I enjoy the dynamic aspect of relations and tasks.', 'I enjoy the predictability of relations and tasks.', 'I am really inbetween.', 'N', '12.5'),
            array('I completely think my decisions through.', 'I decide based on intuition.', 'I am really inbetween.', 'T', '12.5'),
            array('I work best with a list of pros and cons.', 'I decide based on the consequences for people.', 'I am really inbetween.', 'T', '12.5'),
            array('I am inherently critical.', 'I like to make sure people enjoy themselves.', 'I am really inbetween.', 'T', '12.5'),
            array('I am honest rather than tactical.', 'I am tactical rather than honest.', 'I am really inbetween.', 'T', '12.5'),
            array('I prefer familiar situations.', 'I prefer flexible situations.', 'I am really inbetween.', 'P', '8.333'),
            array('I plan everything, with a "to do" list at hand.', 'I wait until I have several ideas and then decide what to do on the fly.', 'I am really inbetween.', 'P', '8.333'),
            array('I like finishing up projects.', 'I like starting up projects.', 'I am really inbetween.', 'P', '8.333'),
            array('I get stressed by abrupt changes and a lack of planning.', 'I find detailed plans stifling and look forward to change.', 'I am really inbetween.', 'P', '8.333'),
            array('I am more likely to reach a goal.', 'I am more likely to see an opportunity.', 'I am really inbetween.', 'P', '8.333'),
            array('All play and no work causes the project to go unfinished.', 'All work and no play makes you a boring chap.', 'I am really inbetween.', 'P', '8.333')
        );
}