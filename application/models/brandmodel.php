<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandmodel extends CI_Model 
{
    public function getBrandNames()
    {
        $query = $this->db->get('brands');
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[$row['brandid']] = $row['name'];
        }
        asort($result);
        return $result;
    }
}