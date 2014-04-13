<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configmodel extends CI_Model 
{
    public function getSettings()
    {
        $results = $this->db->get('settings')->result_array();
        $settings = array();
        foreach ($results as $result) {
            $settings[$result['name']] = $result['value'];
        }
        return $settings;
    }

    public function setSettings($settings)
    {
        foreach ($settings as $key => $value) {
            $this->db->where('name', $key);
            $this->db->update('settings', array('value' => $value));
        }
    }
}