<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// return the asset URL
function assets_url() {
	return base_url() . 'assets/';
}

function img_url() {
	return assets_url() . 'img/';
}

function css_url() {
	return assets_url() . 'css/';
}

function js_url() {
	return assets_url() . 'js/';
}