<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is the implementation of the product details save / edit information
 *
 * @category        Controller
 * @author          Chandra Bhushan Sah
 * @email           chandrabhushan[dot]sah[at]live.in
 */
class Product extends MY_Controller {

    private $es_type;
    private $limit;
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('product_model');
        $this->load->helper('security');
        $this->limit = REC_LIMIT;
        
        if (ES_ENABLE) {
            $config = [
                'server' => ES_SERVER,
                'index'  => ES_INDEX,
            ];
            $this->es_type = ES_TYPE;
            $this->load->library('elasticsearch', $config);
        }
    }

    /**
     * Handling the call for specific product details with product id
     * 
     * @param int   id
     * 
     * @return array    (according to request format)
     */
    public function fetch_get()
    {
        $response = [
            'status' => FALSE,
            'message' => 'Product ID is required',
            'product' => (Object)[]
        ];

        $product = NULL;
        $id = $this->get('id');
        if ($id === NULL) {
            $this->response($response, parent::HTTP_NOT_FOUND);
        }

        // Validate the id.
        if (! ctype_digit($id)) {
            // Invalid id, set the response and exit.
            $response['message'] = 'Invalid id found';
            $this->response($response, parent::HTTP_BAD_REQUEST);
        }

        if (ES_ENABLE) {
            $sresult = $this->elasticsearch->get($this->es_type, $id);
            if (empty($sresult) || isset($sresult['error']) || ! $sresult['found']) {
                $product = $this->product_model->get_product($id);
                if (! empty($product)) {
                    $this->elasticsearch->add($this->es_type, $id, $product);
                }
            } else {
                $product = $sresult['_source'];
            }
        } else {
            $product = $this->product_model->get_product($id);
        }

        if (!empty($product)) {
            $response['status'] = TRUE;
            $response['message'] = 'success';
            $response['product'] = $product;
            // $this->output->cache(300);
            $this->set_response($response, parent::HTTP_OK);
        } else {
            $response['message'] = 'No products were found!';
            $this->set_response($response, parent::HTTP_NOT_FOUND);
        }
    }


    /**
     * Handling the call for inserting / creating / adding new product details
     * 
     * @param string    name
     * @param string    size
     * @param double    price
     * @param string    image
     * @param int       category_id
     * @param string    status
     * @param string    descriptions
     * 
     * @return array    (according to request format)
     */
    public function  add_post()
    {
        $product = $this->_validate($this->post(), $err, TRUE);
        if (empty($product)) {
            // Invalid data, set the response and exit.
            $response = [
                'status'    => FALSE,
                'message'   => $err,
                'id'        => '',
            ];
            $this->response($response, parent::HTTP_BAD_REQUEST);
        }

        $id = $this->product_model->insert($product);
        if ($id > 0 && ES_ENABLE) {
            $product = $this->product_model->get_product($id);
            if (! empty($product)) {
                $this->elasticsearch->add($this->es_type, $id, $product);
            }
        }
        $response = [
            'status'    => (!empty($id) && $id > 0),
            'message'   => (!empty($id) && $id > 0) ? 'Created Successfully' : 'DB Error! Please retry later',
            'id'        => $id,
        ];

        $this->set_response($response, parent::HTTP_CREATED);
    }


    /**
     * Handling the call for updating product details
     * 
     * @param int       id
     * @param string    name
     * @param string    size
     * @param double    price
     * @param string    image
     * @param int       category_id
     * @param string    status
     * @param string    descriptions
     * 
     * @return array    (according to request format)
     */
    public function update_put()
    {
        $id = $this->get('id');
        
        $response = [
            'status' => FALSE,
            'message' => 'Invalid ID Found!',
            'id' => $id,
        ];
        
        // Validate the id.
        if (! ctype_digit($id)) {
            // Invalid id, set the response and exit.
            $this->response($response, parent::HTTP_BAD_REQUEST);
        }

        $product = $this->_validate($this->put(), $err, TRUE);
        if (empty($product)) {
            // Invalid data, set the response and exit.
            $response['message'] = $err;
            $this->response($response, parent::HTTP_BAD_REQUEST);
        }

        $n = $this->product_model->update($product, $id);
        if ($n && ES_ENABLE) {
            $product = $this->product_model->get_product($id);
            $this->elasticsearch->add($this->es_type, $id, [$product]);
        }
        
        $response = [
            'status'  => $n,
            'message' => $n ? 'Updated Successfully' : 'Product not found!',
            'id'      => $id,
        ];

        $this->set_response($response, parent::HTTP_ACCEPTED);
    }

    /**
     * Handling the call for deleting product details
     * 
     * @param int       id
     * 
     * @return array    (according to request format)
     */
    public function remove_delete()
    {
        $id = $this->get('id');

        // Validate the id.
        if (! ctype_digit($id)) {
            // Invalid id, set the response and exit.
            $response = [
                'status' => FALSE,
                'message' => 'Invalid ID Found!',
                'id' => $id,
            ];
            $this->response($response, parent::HTTP_BAD_REQUEST);
        }

        $n = $this->product_model->delete($id);
        if ($n && ES_ENABLE) {
            $sresult = $this->elasticsearch->get($this->es_type, $id);
            if (isset($sresult['found']) && $sresult['found']) {
                $this->elasticsearch->delete($this->es_type, $id);
            }
        }
        $response = [
            'status'  => $n,
            'message' => $n ? 'Deleted Successfully!' : 'Product not found!',
            'id'      => $id,
        ];

        $this->set_response($response, parent::HTTP_ACCEPTED);
    }

    /**
     * Handling the call for searching / listing product details
     * 
     * @param string    keyword     optional
     * @param int       page        optional
     * 
     * @return array    (according to request format)
     */
    public function search_get()
    {
        $response = [
            'status' => FALSE,
            'message' => 'No products were found!',
            'products' => []
        ];
        
        $keyword = $this->get('keyword');
        $page = (int) $this->get('page');
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page - 1) * $this->limit;
        $products = [];

        if (empty(trim($keyword))) {
            $products = $this->product_model->get_products($offset, $this->limit);
            if ($products) {
                $response['status'] = TRUE;
                $response['message'] = 'success';
                $response['products'] = $products;
                // $this->output->cache(300);
                $this->response($response, parent::HTTP_OK);
            } else {
                $this->response($response, parent::HTTP_NOT_FOUND);
            }
        }

        if (ES_ENABLE) {
            $sresult = $this->elasticsearch->query_wresultSize($this->es_type, $keyword, $this->limit, $offset);
            if (empty($sresult) || isset($sresult['error']) || ! $sresult["hits"]["total"]) {    
                $srch = ['/(-|\s)+/', '/[^a-zA-Z0-9\-\s]+/'];
                $rplc = ['%', ''];
                $keyword = preg_replace($srch, $rplc, $keyword);
                $products = $this->product_model->search_products($keyword, $offset, $this->limit);
            } else {
                $products = array_map(function($item){
                    return $item['_source'];
                }, $sresult['hits']['hits']);
            }
        } else {
            $products = $this->product_model->search_products($keyword, $offset, $this->limit);
        }

        if (! empty($products)) {
            $response['status'] = TRUE;
            $response['message'] = 'success';
            $response['products'] = $products;
            // $this->output->cache(300);
            $this->set_response($response, parent::HTTP_OK);
        } else {
            $response['message'] = 'No products were found!';
            $this->set_response($response, parent::HTTP_NOT_FOUND);
        }
    }

    /**
     * Fields validation with rules. Return product details array
     * on success otherwise false and error will be set in $err param
     * 
     * @param array         data
     * @param reference     err
     * @param boolean       skip_rqd
     * 
     * @return mix    (array on success otherwise boolean false)
     */
    private function _validate($data, &$err, $skip_rqd = FALSE)
    {
        $field_v = [
            'name'              => [
                'required'      => TRUE,
                'min_length'    => 3,
                'max_length'    => 120,
                'regex'         => '/^[a-zA-Z0-9\.\-\_\+\@\$\%\&\*\:\|\s]+$/',
                'field_name'    => 'name',
            ],
            'size'              => [
                'required'      => TRUE,
                'max_length'    => 5,
                'regex'         => '/^[a-zA-Z0-9.]+$/',
                'field_name'    => 'available_size',
            ],
            'price'             => [
                'required'      => TRUE,
                'min'           => 10.00,
                'max'           => 9999.99,
                'type'          => 'number',
                'field_name'    => 'price',
            ],
            'descriptions'      => [
                'required'      => TRUE,
                'min_length'    => 3,
                'max_length'    => 300,
                'field_name'    => 'descriptions',
            ],
            'images'            => [
                'required'      => TRUE,
                'min_length'    => 10,
                'max_length'    => 250,
                'type'          => 'url',
                'field_name'    => 'image_url',
            ],
            'category_id'       => [
                'required'      => TRUE,
                'model_check'   => [
                    'model'     => 'product_model',
                    'method'    => 'category_exist',
                    'err_msg'   => 'Product Category does not exist!'
                ],
                'field_name'    => 'category_id',
            ],
            'status'            => [
                'required'      => TRUE,
                'in_list'       => ['Y', 'N'],
                'field_name'    => 'active_status',
            ],
        ];

        $key_fields     = array_keys($field_v);
        $data_fields    = array_keys($data);
        $left_fields    = array_diff($key_fields, $data_fields);
        if (count($left_fields) && ! $skip_rqd) {
            $err = 'Some of the field(s) named (' . implode(',', $left_fields) . ') is/are missing';
            return FALSE;
        }
        $product = [];
        foreach($field_v as $k => $f) {
            if ($skip_rqd && ! isset($data[$k])) {
                continue;
            }
            $v   = $data[$k];
            $avl = !empty($v);
            $required = $f['required'] && ! $skip_rqd;
            if ($required && empty($v)) {
                $err = "'$k' field is required!";
                return FALSE;
            }
            if ($avl && isset($f['type'])) {
                $tp = $f['type'];
                if ($tp == 'number' && ! is_numeric($v)) {
                    $err = "'$k' field is not a valid number!";
                    return FALSE;
                }
                if ($tp == 'url' && ! filter_var($v, FILTER_VALIDATE_URL)) {
                    $err = "'$k' field is not a valid URL!";
                    return FALSE;
                }
            }
            if ($avl && isset($f['min_length']) && strlen($v) < $f['min_length']) {
                $err = "'$k' field must have at least " . $f['min_length'] . " characters!";
                return FALSE;
            }
            if ($avl && isset($f['max_length']) && strlen($v) > $f['max_length']) {
                $err = "'$k' field must not have more than " . $f['max_length'] . " characters!";
                return FALSE;
            }
            if ($avl && isset($f['min']) && $v < $f['min']) {
                $err = "'$k' field must be greater than " . $f['min'] . "!";
                return FALSE;
            }
            if ($avl && isset($f['max']) && $v > $f['max']) {
                $err = "'$k' field must be less than " . $f['max'] . "!";
                return FALSE;
            }
            if ($avl && isset($f['in_list']) && ! in_array($v, $f['in_list'])) {
                $err = "'$k' field must contain any of these: " . implode(',', $f['in_list']) . "!";
                return FALSE;
            }
            if ($avl && isset($f['regex']) && ! preg_match($f['regex'], $v)) {
                $err = "'$k' field not in valid format!";
                return FALSE;
            }
            if ($avl && isset($f['model_check'])) {
                $model  = $f['model_check']['model'];
                $method = $f['model_check']['method'];
                if (! $this->$model->$method($v)) {
                    $err = $f['model_check']['err_msg'];
                    return FALSE;
                }
            }
            $product[$f['field_name']] = xss_clean($v);
        }
        return $product;
    }
}