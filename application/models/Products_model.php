<?php

class Products_model extends CI_Model{

    public function __construct() {

        $this->load->database();
    }

    public function get_products(){


            $this->db->order_by('id', 'RANDOM');
            $this->db->limit(6);
            $query = $this->db->get('products');

            return $query->result();

    }

    public function insert_prod($post_image){

                 $data = array(
                    'name' => $this->input->post('prodname'),
                    'price' => $this->input->post('prodprice'),

                    'desc' => $this->input->post('desc'),

                    'image' => $post_image
                  );

                  return $this->db->insert('products', $data);
  }

  public function detail_products($id){


          $query = $this->db->get_where('products', array('id' => $id));

          return $query->row();

  }

  public function all_products($limit, $offset){


            $this->db->limit($limit, $offset);
            $this->db->order_by('id', 'DESC');


          $query = $this->db->get('products');

          return $query->result();

  }

  public function count_all_products(){

         $query = $this->db
                       ->select('id')

                       ->from('products')

                       ->get();

      return $query->num_rows();
  }

  /*
   *	Get Single Product
   */
   public function get_product_details($id){
   $this->db->select('*');
   $this->db->from('products');
   $this->db->where('id', $id);

   $query = $this->db->get();
   return $query->row();
   }

public function insert_account($data){

        return $this->db->insert('account', $data);
}

/*
 *	Add Order To Database
 */
 public function add_order($order_data){
  $insert = $this->db->insert('orders', $order_data);
      return $insert;
}

public function user_order_total($order_total){
 $insert = $this->db->insert('user_grandtotal', $order_total);
     return $insert;
}

public function login($username,$password){
      //Validate
      $this->db->where('username',$username);
      $this->db->where('pass',$password);

      $result = $this->db->get('account');
      if($result->num_rows() == 1){
          return $result->row(0)->id;
      } else {
          return false;
      }
  }

  }
