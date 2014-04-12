<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {
	
	public function details($id)
	{	
		$profile = $this->usermodel->getProfileByID($id);
		
		$like = $this->usermodel->doesLike($id);
		$liked = $this->usermodel->doesLiked($id);
		
		build_view($this, 'profile_details', array('profile' => $profile, 'title' => $profile['nickname'], 'like' => $like, 'liked' => $liked));
	}
	
	public function my_likes()
	{
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
		
		$profiles = $this->usermodel->getLikeProfiles();
		build_view($this, 'profile_list', array('profiles' => $profiles, 'title' => 'People I like'));
	}
	
	public function like_me()
	{
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
	
		$profiles = $this->usermodel->getLikedProfiles();
		build_view($this, 'profile_list', array('profiles' => $profiles, 'title' => 'People who like me'));
	}
	
	public function connections()
	{
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
		
		$profiles = $this->usermodel->getMutualLikesProfiles();		
		build_view($this, 'profile_list', array('profiles' => $profiles, 'title' => 'Connections'));
	}
	
	public function like($id)
	{
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
	
		// get current profile
		$query = $this->db->get_where('profiles', array('userid' => $this->session->userdata('userid')));
		$profile = $query->row_array();
		
		// not liking yourself and not yet liked
		if($id !== $this->session->userdata('userid') && !in_array($id, $profile['likes'])) {
			$this->usermodel->like($id);
		}
		
		// back to profile
		redirect("/profiles/details/" . $id);
	}
	
	public function avatar($id)
	{
		$profile = $this->usermodel->getProfileByID($id);

		// profile not found - return 404
		if(!array_key_exists('userid', $profile)){
			show_404('avatar/'.$id);
		}
		
		$profile_avatar = 'application/avatars/'.$profile['userid'].'.jpg';

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