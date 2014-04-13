<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// return the asset URL
function assets_url() {
	return base_url() . 'assets/';
}

// return the images URL
function img_url() {
	return assets_url() . 'img/';
}

// return the CSS URL
function css_url() {
	return assets_url() . 'css/';
}

// return the Javascript URL
function js_url() {
	return assets_url() . 'js/';
}

// convert date of birth (string) to age
function dob_to_age($dob) {
	$time = strtotime($dob);
	$diff = time() - $time;
	$age = $diff / 60 / 60 / 24 / 365;
	return floor($age);
}

function avatar_url($id) {
	return base_url() . 'profiles/avatar/' . $id;
}

function build_view($self, $name, $data) {

		// load current profile when available
		$currentProfile = false;
		if($self->session->userdata('userid'))
			$currentProfile = $self->usermodel->getProfileByID($self->session->userdata('userid'));
	
		$title = '';
		if(isset($data) && array_key_exists('title', $data))
			$title = $data['title'];
	
		// Build the page
		$self->load->view('partials/header', array(
			'currentProfile' => $currentProfile,
			'title' => $title
		));
			
		// load requested view
		$self->load->view($name, $data);
		
		$self->load->view('partials/footer');
}

function him_her($gender, $him = 'him', $her = 'her'){
	if(is_array($gender) && array_key_exists('gender', $gender))
		$gender = $gender['gender'];
	return ($gender === 'male') ? $him : $her;
}

function format_mbti($scores, $returnAsString = false){
	if(!is_array($scores)){
		$scores = explode(',', $scores);
		foreach ($scores as &$s) {
			$s = intval($s);
		}
	}
	
	$formatted = array();
	$mbti_types = array('IE','NS','TF','PJ');
	
	foreach ($scores as $i => $score) {
		if($score < 50) {
			$score = 100 - $score;
			$formatted[] = $mbti_types[$i][1] . ' (' . round($score) . '%)';
		}
		else{
			$formatted[] = $mbti_types[$i][0] . ' (' . round($score) . '%)';
		}
	}
	
	if ($returnAsString) {
		return implode(', ', $formatted);
	}
	return $formatted;
}








