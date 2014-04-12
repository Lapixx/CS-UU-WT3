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
        $profile = $query->row_array();
        
		// replace brand IDs with brand names
		if(!empty($profile)) {
        	$profile['brands'] = $this->brandmodel->getBrandNames(explode(',', $profile['brands']));
        }
        
        return $profile;
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
        	$profile = $results[$i];
        	
        	// replace brand IDs with brand names
        	$profile['brands'] = $this->brandmodel->getBrandNames(explode(',', $profile['brands']));
        	shuffle($profile['brands']);
        	
        	array_push($random_results, $profile);
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
    }

    public function doesLike($user)
    {
        $userid = $this->session->userdata('userid');
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $userid))->row_array();
        $exp = explode(',', $likes['likes']);
        return in_array($user, $exp);
    }

    public function doesLiked($user)
    {
        $userid = $this->session->userdata('userid');
        $this->db->select('likes');
        $likes = $this->db->get_where('profiles', array('userid' => $user['userid']))->row_array();
        $exp = explode(',', $likes['likes']);
        return in_array($userid, $exp);
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
            array_push($matches, array('userid' => $row['userid'], 'score' => $score));
        }

        usort($matches, function($item1, $item2)
                        {
                            if ($item1['score'] < $item2['score'])
                                return -1;
                            if ($item2['score'] < $item1['score'])
                                return 1;
                            return 0;
                        });

        return $matches;
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