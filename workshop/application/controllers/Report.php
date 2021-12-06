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
        $this->load->model('Admin_Product_Model');
        if (!$this->session->userdata('abAdminId')) {
            redirect('authentication/login');
        }
    }

    public function todayReport_old()
    {
        $start = strtotime('first day of this month');
        $end = strtotime('last day of this month');
        if (isset($_POST['filter'])) {
            extract($_POST);
            $start = strtotime($start);
            $end = strtotime($end) + (24 * 60 * 60);
        }
        $report = $this->Crud->ciRead('payments', " `transaction_status` = '1' AND `transferred_on` BETWEEN '$start' AND '$end'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/todays-sale', compact('start', 'end', 'report'));
        $this->load->view('layouts/footer');
    }

    public function saleReport_old()
    {
        $start = strtotime('first day of this month');
        $end = strtotime('last day of this month');
        if (isset($_POST['filter'])) {
            extract($_POST);
            $start = strtotime($start);
            $end = strtotime($end) + (24 * 60 * 60);
        }
        $report = $this->Crud->ciRead('users', " `user_type` = 'USER' AND `joined_on` BETWEEN '$start' AND '$end'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/sale-report', compact('start', 'end', 'report'));
        $this->load->view('layouts/footer');
    }

    public function transactionReport()
    {
        $start = strtotime('first day of this month');
        $end = strtotime('last day of this month');
        if (isset($_POST['filter'])) {
            extract($_POST);
            $start = strtotime($start);
            $end = strtotime($end) + (24 * 60 * 60);
        }
        $report = $this->Crud->ciRead('payments', " `transaction_status` = '1' AND `transferred_on` BETWEEN '$start' AND '$end'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/transaction-report', compact('start', 'end', 'report'));
        $this->load->view('layouts/footer');
    }

    public function incomeReport()
    {
        $data['PAYMENTS'] = [];
        if (isset($_POST['filter'])) {
            extract($_POST);
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate . " 23:59:59");
            $q = " `updated_on` BETWEEN '$startDate' AND '$endDate'";
            $data['PAYMENTS'] = $this->Crud->ciRead('transaction_history', " $q ORDER BY `id` DESC");
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/income-report', $data);
        $this->load->view('layouts/footer');
    }

    public function incomeReportUser()
    {
        $data['PAYMENTS'] = [];
        if (isset($_POST['filter'])) {
            extract($_POST);
            if ($this->Crud->ciCount('users', " (`epin` = '$epin' OR `phone` = '$epin')")) {
                $startDate = strtotime($startDate);
                $endDate = strtotime($endDate . " 23:59:59");
                // $data['endDate'] = $endDate;
                $q = " `updated_on` BETWEEN '$startDate' AND '$endDate'";
                $epin = $this->Crud->ciRead('users', " (`epin` = '$epin' OR `phone` = '$epin')")[0]->epin;
                $data['PAYMENTS'] = $this->Crud->ciRead('transaction_history', " `epin` = '$epin' AND $q ORDER BY `id` DESC");
            } else {
                $this->session->set_flashdata('danger', "User not found");
                $data['PAYMENTS'] = [];
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/income-report-user', $data);
        $this->load->view('layouts/footer');
    }

    public function saleReportUser()
    {
        $report = array();
        if (isset($_POST['filter'])) {
            extract($_POST);
            if ($this->Crud->ciCount('users', " `epin` = '$epin'")) {
                $start = strtotime($start);
                $end = strtotime($end) + (24 * 60 * 60);
                $report = $this->Crud->ciRead('users', " `user_type` = 'USER' AND `epin` = '$epin' AND `joined_on` BETWEEN '$start' AND '$end'");
            } else {
                $this->session->set_flashdata('danger', "User not found");
                $data['PAYMENTS'] = [];
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/sale-report-user', compact('report'));
        $this->load->view('layouts/footer');
    }

    public function teamLevelwise()
    {
        $report = array();
        $levels = $this->Crud->ciRead('team_income_levels', " `id` <> 0");
        if (isset($_POST['filter'])) {
            extract($_POST);
            $report = $this->Crud->ciRead('recurring_income', " `if_rank` = '$level'");
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/team-level-wise', compact('report', 'levels'));
        $this->load->view('layouts/footer');
    }

    public function levelwiseIncome()
    {
        $data['PAYMENTS'] = [];
        if (isset($_POST['filter'])) {
            extract($_POST);
            if ($this->Crud->ciCount('users', " (`epin` = '$epin' OR `phone` = '$epin')")) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                $endDate = date('Y-m-d H:i:s', strtotime($endDate . " 23:59:59"));
                // $data['endDate'] = $endDate;
                $q = " `added_on` BETWEEN '$startDate' AND '$endDate'";
                $epin = $this->Crud->ciRead('users', " (`epin` = '$epin' OR `phone` = '$epin')")[0]->epin;
                $data['PAYMENTS'] = $this->Crud->ciRead('level_pay_history', " `epin` = '$epin' AND $q ORDER BY `id` DESC");
            } else {
                $this->session->set_flashdata('danger', "User not found");
                $data['PAYMENTS'] = [];
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/levelwise-income-report-user', $data);
        $this->load->view('layouts/footer');
    }

    //Today sale & Datewise Sale New
    public function saleReport()
    {


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['salesreport'] = $this->Admin_Product_Model->select_sales_by_date($start_date1, $end_date1);
        $data['salesreportall'] = $this->Admin_Product_Model->select_sales_all();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/sale-report', $data);
        $this->load->view('layouts/footer');
    }

    public function todayReport()
    {
        $sql = $this->db->query("SELECT SUM(sales_round_amount) AS total
        FROM sales
        ");
        $data['amount'] = $sql->row();
        $data['todaysales'] = $this->Admin_Product_Model->select_today_sales();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('reports/todays-sale', $data);
        $this->load->view('layouts/footer');
    }


    //Today Sale an Datewise Sale New
}
