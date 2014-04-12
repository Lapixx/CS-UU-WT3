<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model 
{

	private function resolveBrands($profiles) {
	
		// single profile
		if(array_key_exists('userid', $profiles)) {
			if(!empty($profiles)) {
				$profiles['brands'] = $this->brandmodel->getBrandNames(explode(',', $profiles['brands']));
			}
			return $profiles;
		}
	
		// list of profiles
		foreach ($profiles as &$profile) {
		    if(!empty($profile)) {
		    	$profile['brands'] = $this->brandmodel->getBrandNames(explode(',', $profile['brands']));
		    }
		}
		return $profiles;
	}
	
	private function ignoreMe($profiles) {
		if(!$this->session->userdata('userid')) return $profiles;
		
		global $myid;
		$myid = $this->session->userdata('userid');
		
		if (!function_exists('filterIgnoreMe')) {
			function filterIgnoreMe($profile){
				global $myid;
				return $profile['userid'] !== $myid;
			}
		}
		$profiles = array_filter($profiles, 'filterIgnoreMe');
		return $profiles;
	}
	
	private function addLikeStatus($profile) {
		$profile['like'] = $this->doesLike($profile['userid']);
		$profile['liked'] = $this->doesLiked($profile['userid']);
		return $profile;
	}
	
	private function compileProfile($profile) {
		$profile = $this->resolveBrands($profile);
		$profile = $this->addLikeStatus($profile);
		return $profile;
	}
	
	private function compileProfiles($profiles, $include_me = false) {
		$profiles = $this->resolveBrands($profiles);
		
		foreach ($profiles as &$profile) {
		    if(!empty($profile)) {
				$profile = $this->addLikeStatus($profile);
			}
		}
		
		if(!$include_me)
			$profiles = $this->ignoreMe($profiles);
			
		return $profiles;
	}
	
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
        $profile = $query->row_array();
        
        return $this->compileProfile($profile);
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
        
        $random_results = $this->compileProfiles($random_results);
        foreach ($random_results as &$profile) {
        	shuffle($profile['brands']);  
        }
        
        shuffle($random_results);
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
                            'email' => $user['email'],
                            'admin' => $user['admin']
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

    public function like($user)
    {
        $userid = $this->session->userdata('userid');
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $userid))->row_array();
        if (empty($likes['likes'])) {
            $likes['likes'] = "$user";
        }
        else {
            $likes['likes'] .= ",$user";
        }
        $this->db->where('userid', $userid);
        $this->db->update('profiles', $likes);

        $personality = $this->db->get_where('profiles', array('userid' => $user))->row_array();
        $this->learnPreference($userid, $personality['personality']);
    }

    private function learnPreference($userid, $personality)
    {
        $alpha = $this->db->get_where('settings', array('name' => 'alpha'))->row_array();
        $alpha = $alpha['value'];

        $preference = $this->db->get_where('profiles', array('userid' => $userid))->row_array();
        $preference = explode(',', $preference['personality_preference']);
        $personality = explode(',', $personality);

        for ($i = 0; $i < 4; $i++) {
            $preference[$i] = $alpha * $preference[$i] + (1 - $alpha) * $personality[$i];
        }

        $preference = implode(',', $preference);
        $this->db->where('userid', $userid);
        $this->db->update('profiles', array('personality_preference' => $preference));
    }

    public function doesLike($user)
    {
        $userid = $this->session->userdata('userid');
        if(!$userid) return false;
        
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $userid))->row_array();
        $exp = explode(',', $likes['likes']);
        return in_array($user, $exp);
    }

    public function doesLiked($user)
    {
        $userid = $this->session->userdata('userid');
        if(!$userid) return false;
        
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $user['userid']))->row_array();
        $exp = explode(',', $likes['likes']);
        return in_array($userid, $exp);
    }

    public function getLikeProfiles()
    {
        $userid = $this->session->userdata('userid');
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $userid))->row_array();
        $exp = explode(',', $likes['likes']);

        $this->db->where_in('userid', $exp);
        $profiles = $this->db->get('profiles')->result_array();
        
        $profiles = $this->compileProfiles($profiles);
                
        return $profiles;        
    }

    public function getLikedProfiles()
    {
    	global $userid;
        $userid = $this->session->userdata('userid');
        $profiles = $this->db->get('profiles')->result_array();
        
        if (!function_exists('filterLikedProfiles')) {
	        function filterLikedProfiles($profile){
	        	global $userid;
	        	return in_array($userid, explode(',', $profile['likes']));
	        }
        }
        
        $profiles = array_filter($profiles, 'filterLikedProfiles');
        
        $profiles = $this->compileProfiles($profiles);
        
        return $profiles;   
    }
    
    public function getMutualLikesProfiles()
    {
    	global $liked_ids;
    	
    	// people who like me
    	$liked = $this->getLikedProfiles();
    	
    	// ids of those people
    	$liked_ids = array_map(function($x){
    		return $x['userid'];
    	}, $liked);
    	
    	if (!function_exists('filterConnections')) {
	    	function filterConnections($y){
	    		global $liked_ids;
	    		return in_array($y['userid'], $liked_ids);
	    	}
    	}
    	
    	// people I like, filtering out those who do not like me back
    	$profiles = array_filter($this->getLikeProfiles(), 'filterConnections');
    	
    	return $profiles;
    }

    public function getSortedMatchesForUser($userid = -1)
    {
        if ($userid == -1) {
            $userid = $this->session->userdata('userid');
        }
        $user = $this->db->get_where('profiles', array('userid' => $userid))->row_array();

        return $this->getSortedMatches($user);
    }

    public function getSortedMatches($user)
    {
        $this->db->where_not_in('userid', array($user['userid']));
        $otherUsers = $this->db->get('profiles')->result_array();

        $preferredGender = $this->genderPreferenceToGender($user['gender_preference']);
        $age = dob_to_age($user['dob']);
        $matches = array();
        foreach ($otherUsers as $row) {
            $rowAge = dob_to_age($row['dob']);

            if ($user['gender_preference'] != 'both' && $row['gender'] != $preferredGender) {
                continue;
            }
            if ($user['min_age'] > $rowAge || $user['max_age'] < dob_to_age($row['dob'])) {
                continue;
            }

            if ($row['gender_preference'] != 'both' && $user['gender'] != $this->genderPreferenceToGender($row['gender_preference'])) {
                continue;
            }
            if ($row['min_age'] > $age || $row['max_age'] < $age) {
                continue;
            }

            // mutual match
            $score = $this->calculateMatch($user, $row);
            array_push($matches, array('profile' => $row, 'score' => $score));
        }

        usort($matches, function($item1, $item2)
                        {
                            if ($item1['score'] < $item2['score'])
                                return -1;
                            if ($item2['score'] < $item1['score'])
                                return 1;
                            return 0;
                        });

        $profiles = array_map(function($match){
        	return $match['profile'];
        }, $matches);
        
        $profiles = $this->compileProfiles($profiles);
        
        return $profiles;
    }

    public function calculateMatch($user1, $user2)
    {
        $brandMatch = $this->calculateBrandMatch($user1['brands'], $user2['brands']);
        $personalityMatch = max($this->calculatePersonalityMatch($user1['personality_preference'], $user2['personality']),
                                $this->calculatePersonalityMatch($user2['personality_preference'], $user1['personality']));

        $weight = $this->db->get_where('settings', array('name' => 'mix_weight'))->row_array();
        $weight = $weight['value'];

        return $weight * $personalityMatch + (1 - $weight) * $brandMatch;
    }

    public function calculateBrandMatch($brands1, $brands2)
    {
        $type = $this->db->get_where('settings', array('name' => 'match_type'))->row_array();
        $type = $type['value'];
        $brandsArray1 = explode(',', $brands1); $brandsArray2 = explode(',', $brands2);
        $size1 = count($brandsArray1); $size2 = count($brandsArray2);
        $overlap = count(array_intersect($brandsArray1, $brandsArray2));

        $match;
        switch ($type)
        {
            case 'dice':
                $match = 2 * $overlap / ($size1 + $size2);
                break;
            case 'jaccard':
                $match = $overlap / count($brandsArray1 + $brandsArray2);
                break;
            case 'cosine':
                $match = $overlap / (sqrt($size1) * sqrt($size2));
                break;
            case 'overlap':
                $match = $overlap / min($size1, $size2);
                break;
        }

        return 1 - $match;
    }

    public function calculatePersonalityMatch($preference, $personality)
    {
        $prefArray = explode(',', $preference); $persArray = explode(',', $personality);
        $diffs = array_map(function($a, $b) { return abs($a - $b); }, $prefArray, $persArray);
        $sum = array_reduce($diffs, function($a, $b) { return $a + $b; });
        return $sum / 400;
    }

    // source: http://www.techrepublic.com/blog/australian-technology/securing-passwords-with-blowfish/
    private function generateSalt()
    {
        $salt = "$2y$10$";

        for ($i = 0; $i < 22; $i++) {
            $salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1);
        }

        return $salt;
    }

    private function genderPreferenceToGender($pref)
    {
        switch ($pref)
        {
            case 'men':
                return 'male';
            case 'women':
                return 'female';
            case 'both':
                return 'both';
        }
    }
}