<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandmodel extends CI_Model 
{
    public function getBrandNames()
    {
        $this->db->select('name');
        $query = $this->db->get('brands');
        $result = array();
        foreach ($query->result_array() as $row) {
            array_push($result, $row['name']);
        }
        sort($result);
        return $result;
    }
}