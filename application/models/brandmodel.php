<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandmodel extends CI_Model 
{
    public function getAllBrandNames()
    {
        $query = $this->db->get('brands');
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[$row['brandid']] = $row['name'];
        }
        asort($result);
        return $result;
    }

    public function getBrandNames($ids)
    {
        $this->db->where_in('brandid', $ids);
        $query = $this->db->get('brands');
        $result = array();
        foreach ($query->result_array() as $row) {
            array_push($result, $row['name']);
        }
        return $result;
    }
}