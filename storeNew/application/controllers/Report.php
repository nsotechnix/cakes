<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('encryption');
        $this->load->model('Crud');
        $this->load->model('Cashier_Sale_Model');
        if (!$this->session->userdata('abCashierId')) {
            redirect('authentication/login');
        }
    }


    public function saleReport()
    {

        $id = $this->session->userdata('abCashierId');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['salesreport'] = $this->Cashier_Sale_Model->select_sales_by_date($id, $start_date1, $end_date1);
        $data['salesreportall'] = $this->Cashier_Sale_Model->select_sales_all($id);
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/sale-report', $data);
        $this->load->view('layouts/footer');
    }

    public function todaySale()
    {


        $data['todaysales'] = $this->Cashier_Sale_Model->select_sales_today();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/todays-sale', $data);
        $this->load->view('layouts/footer');
    }
}
