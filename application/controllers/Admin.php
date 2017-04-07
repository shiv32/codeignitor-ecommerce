<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {




	public function index()
	{

		$this->load->view('admin/admin');
	}

  public function addproduct(){


      $data['msg'] = '';
      $this->load->view('admin/addprod', $data);

  }

	public function insertprod(){


		  $this->form_validation->set_rules('prodname', 'Product Name', 'required');
			$this->form_validation->set_rules('prodprice', 'Product Price', 'required');
			$this->form_validation->set_rules('desc', 'Product Description', 'required');

			$this->form_validation->set_error_delimiters("<div class='alert alert-dismissible alert-danger'><strong>","</strong></div>");


			if($this->form_validation->run() === FALSE){
          $data['msg'] = '';

				 $this->load->view('admin/addprod', $data);

			} else {
				// Upload Image
				$config['upload_path'] = './assets/image/items';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				//$config['max_size'] = '2048';
				//$config['max_width'] = '500';
				//$config['max_height'] = '500';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('userfile')){

					 $errors = array('error' => $this->upload->display_errors());


							$this->session->set_flashdata('error',$errors['error']);

							redirect('admin/addproduct','refresh');

         } else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];

				}

				            $insert = $this->products_model->insert_prod($post_image);


									 if($insert){


												 $data['msg'] = 'Data Inserted Successfully!';

												 $this->load->view('admin/addprod', $data);
                      }

			}
		}

	}
