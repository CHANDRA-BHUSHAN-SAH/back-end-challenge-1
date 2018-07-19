<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the implementation of the product model for db operations
 *
 * @category        Model
 * @author          Chandra Bhushan Sah
 * @email           chandrabhushan[dot]sah[at]live.in
 */
class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (DB_CACHE_ON) {
            $this->db->cache_on();
        }
    }

    public function get_products($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        return $this->db
            ->select('p.id AS id, p.name AS name, available_size, price, image_url AS image, c.name as category')
            ->limit($limit, $offset)
            ->from('products p')
            ->join('categories c', 'c.id = category_id')
            ->get()
            ->result();
    }

    

    public function get_product($id)
    {
        return $this->db
            ->select('p.id AS id, p.name AS name, descriptions, available_size, price, image_url as image, c.name as category')
            ->where('p.id', $id)
            ->from('products p')
            ->join('categories c', 'c.id = category_id')
            ->get()
            ->row();
    }

    public function insert($data)
    {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        $this->db->update('products', $data, ['id' => $id]);
        return $this->db->affected_rows() > 0;
    }

    public function delete($id)
    {
        $this->db->delete('products', ['id' => $id]);
        return $this->db->affected_rows() > 0;
    }

    public function search_products($keyword, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        return $this->db
            ->select('p.id AS id, p.name AS name, available_size, price, image_url AS image, c.name as category')
            ->limit($limit, $offset)
            ->like('p.name', $keyword, 'BOTH')
            ->or_like('descriptions', $keyword, 'BOTH')
            ->from('products p')
            ->join('categories c', 'c.id = category_id')
            ->get()
            ->result();
    }

    public function category_exist($id)
    {
        return $this->db
            ->select('name')
            ->get_where('categories', [
                'id' => $id,
                'active_status' => 'Y'
            ])
            ->num_rows() > 0;
    }
}
