<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Currencies
 * Crypto / FIAT conversion & stock
 */
class Currency_model extends CI_Model {

    private $table;
    private $prefix;

    public function __construct() {
        parent::__construct();
        $this->table = 'currency';
        $this->prefix = 'currency_';
    }

    /**
     * Add 
     */
    public function add($datas) {
        $datas = array_merge($datas, array(
            $this->prefix . 'created_at' => date('Y-m-d H:i:s'),
            $this->prefix . 'updated_at' => date('Y-m-d H:i:s')
        ));

        $this->db->insert($this->table, $datas);

        return $this->db->insert_id();
    }
    
    /**
     * Update
     * @return type
     */
    public function update($where, $values) {
        $values = array_merge($values, array(
            $this->prefix . 'updated_at' => date('Y-m-d H:i:s')
        ));
        return $this->db->where($where)->update($this->table, $values);
    }
    
    /**
     * Add or update
     * 
     * @param array $where value to check & insert
     */
    public function addUpdate($where, $values) {
        $currencyExists = $this->db->where($where)->get($this->table)->num_rows();
        if($currencyExists) {
            $this->update($where, $values);
        } else {
            $this->add($values);
        }
    }
    
    /**
     * Convert a value or get the convertion between 2 currencies
     * 
     * @param type $curr_a currency base
     * @param type $curr_b currency value asked
     * @param type $value value to convert
     */
    public function convert($curr_a, $curr_b, $value = false) {
        $convert = $this->db->where(array('currency_a' => $curr_a, 'currency_b' => $curr_b))->get($this->table)->row();
        if(isset($convert)) {
            if($value == false) {
                // Return the convertion value
                return $convert;
            } else {
                // Return the value sended converted
                return $value*$convert->currency_value;
            }
        } else {
            return false;
        }
    }
    
}