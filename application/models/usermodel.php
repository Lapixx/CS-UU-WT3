<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model 
{
    public function getUserByID($id)
    {
        $query = $this->db->get_where('users', array('userid' => $id));
        return $query->row_array();
    }

    public function getUserByEmail($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->row_array();
    }

    public function getProfileByID($id)
    {
        $query = $this->db->get_where('profiles', array('userid' => $id));
        return $query->row_array();
    }
    
    public function getRandomProfiles($n)
    {
        $query = $this->db->get('profiles');
        $results = $query->result_array();
        
        $n = min($n, count($results));
        $random_keys = array_rand($results, $n);
        
		if ($n === 1) return array($results[$random_keys]);
		
        $random_results = array();
        foreach ($random_keys as $i) {
        	array_push($random_results, $results[$i]);
        }
        
        return $random_results;
    }

    public function getProfileByEmail($email)
    {
        $user = $this->getUserByEmail($email);
        $userid = $user['userid'];
        return $this->getProfileByID($userid);
    }

    public function tryLogin($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if (empty($user)) {
            return false;
        }

        if (crypt($password, $user['password']) != $user['password']) {
            return false;
        }

        $this->db->where('userid', $user['userid']);
        $this->db->update('users', array('password' => crypt($password, $this->generateSalt())));

        $session_data = array(
                            'userid' => $user['userid'],
                            'email' => $user['email']
                        );

        $this->session->set_userdata($session_data);
        return true;
    }

    public function tryRegister($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if (!empty($user)) {
            return false;
        }

        $pass_hash = crypt($password, $this->generateSalt());
        $this->db->insert('users', array('email' => $email, 'password' => $pass_hash, 'admin' => 'FALSE'));

        return $this->db->affected_rows() > 0;
    }

    public function tryUpdateProfile($email, $profile)
    {
        $user = $this->getUserByEmail($email);
        if (empty($user)) {
            return false;
        }

        $current_profile = $this->getProfileByID($user['userid']);
        if (empty($current_profile)) {
            $profile['userid'] = $user['userid'];
            $this->db->insert('profiles', $profile);
        }
        else {
            $this->db->where('userid', $user['userid']);
            $this->db->update('profiles', $profile);
        }
        
        return $this->db->affected_rows() > 0;
    }

    // source: http://www.techrepublic.com/blog/australian-technology/securing-passwords-with-blowfish/
    private function generateSalt() {
        $salt = "$2y$10$";

        for ($i = 0; $i < 22; $i++) {
            $salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
        }

        return $salt;
    }
}