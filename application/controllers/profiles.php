<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {

	public function details($id)
	{
		$profile = $this->usermodel->getProfileByID($id);
		$user = $this->usermodel->getUserByID($id);
		$profile['email'] = $user['email'];

		build_view($this, 'profile_details', array('profile' => $profile, 'title' => $profile['nickname']));
	}

	public function me()
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		$id = $this->session->userdata('userid');
		$profile = $this->usermodel->getProfileByID($id);
		$user = $this->usermodel->getUserByID($id);
		$profile['email'] = $user['email'];

		build_view($this, 'profile_details', array('profile' => $profile, 'title' => $profile['nickname']));
	}

	public function my_likes($page = -1)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		$page = intval($page);
		$profiles = $this->usermodel->getLikeProfiles();
		if($page != -1){
			build_json($this, paged_results($profiles, $page));
		}
		else
			build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'People I like', 'page' => 'profiles/my_likes', 'pages' => ceil(count($profiles)/6)));
	}

	public function like_me($page = -1)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		$page = intval($page);
		$profiles = $this->usermodel->getLikedProfiles();
		if($page != -1){
			build_json($this, paged_results($profiles, $page));
		}
		else
			build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'People who like me', 'page' => 'profiles/like_me', 'pages' => ceil(count($profiles)/6)));
	}

	public function connections($page = -1)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		$page = intval($page);
		$profiles = $this->usermodel->getMutualLikesProfiles();
		if($page != -1){
			build_json($this, paged_results($profiles, $page));
		}
		else
			build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'Connections', 'page' => 'profiles/connections', 'pages' => ceil(count($profiles)/6)));
	}

	public function discover($page = -1)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		$page = intval($page);
		$profiles = $this->usermodel->getSortedMatchesForUser();
		if($page != -1){
			build_json($this, paged_results($profiles, $page));
		}
		else{
			build_view($this, 'profile_list', array('profiles' => paged_results($profiles), 'title' => 'People you might like', 'page' => 'profiles/discover', 'pages' => ceil(count($profiles)/6)));
		}
	}

	public function like($id)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		// get current profile
		$profile = $this->usermodel->getProfileByID($this->session->userdata('userid'), true);

		// not liking yourself and not yet liked
		if($id !== $this->session->userdata('userid') && !in_array($id, $profile['likes'])) {
			$this->usermodel->like($id);
		}

		// back to profile
		redirect("/profiles/details/" . $id);
	}

	public function avatar($id, $s = '')
	{
		$profile = $this->usermodel->getProfileByID($id);

		// profile not found - return 404
		if(!array_key_exists('userid', $profile)){
			show_404('avatar/'.$id);
		}

		$profile_avatar = 'application/avatars/'.($s === 's' ? 's' : '').$profile['userid'].'.jpg';

		// not logged in/no avatar set - return default avatar (m/f)
		if(!$this->session->userdata('userid') || !file_exists($profile_avatar)) {
			header('Content-Type: image/jpeg');
			readfile('assets/img/default_'.$profile['gender'][0].'.jpg');
			exit;
		}

		// logged in and avatar set - return avatar
		header('Content-Type: image/jpeg');
		readfile($profile_avatar);
		exit;
	}
}