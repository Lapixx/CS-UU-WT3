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