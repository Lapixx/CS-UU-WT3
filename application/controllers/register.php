<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class Register extends ProfileForm {

	public function index()
	{
        if($this->session->userdata('userid')) {
            redirect("/home");
        }

        ProfileForm::index();

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('pass_conf', 'Password confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('first_name', 'First name', 'required|alpha');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|alpha');
		$this->form_validation->set_rules('nickname', 'Nickname', 'required|is_unique[profiles.nickname]|alpha_dash');
        $this->form_validation->set_rules('description', 'About you', 'required');
		$this->form_validation->set_rules('questions', 'Questions', 'callback_questions_valid');

        $data = array('brands' => $this->brandmodel->getAllBrandNames(), 'questions' => $this->questions, 'title' => 'Register');
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $profile = $this->buildProfile();

            if ($this->usermodel->tryRegister($email, $password) && $this->usermodel->tryUpdateProfile($email, $profile)) {
                $this->usermodel->tryLogin($email, $password);
                build_view($this, 'registersuccess');
                return;
            }
        }

        build_view($this, 'register', $data);
	}

	public function questions_valid($questions) {
		$this->form_validation->set_message('questions_valid', 'Please answer all the questions.');
		return count($questions) == count($this->questions);
	}
    // (Question number, Option A, Option B, Option C, Affected parameter, Effect in %)
    public $questions = array(
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