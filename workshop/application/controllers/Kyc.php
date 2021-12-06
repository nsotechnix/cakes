<?php
defined('BASEPATH') or exit('nikal bey');

class Kyc extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('Sms_helper');
        if (!$this->session->userdata('abAdminId')) {
            redirect('authentication/login');
        }
    }

    public function pending() {
        $data['PENDING'] = $this->Crud->ciRead("users", " `bank_details_given` = '2'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('kyc/pending', $data);
        $this->load->view('layouts/footer');
    }

    public function approved() {
        $data['APPROVED'] = $this->Crud->ciRead("users", " `bank_details_given` = '1'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('kyc/approved', $data);
        $this->load->view('layouts/footer');
    }

    public function changeStatus() {
        $tableName = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $conditionId = $this->uri->segment(5);
        $condition = " `id` = '$conditionId'";
        if ($status == 1) {
            $data = [
                'bank_details_given' => $status,
                'kyc_approved_by' => 1,
                'kyc_approved_by_user_type' => 'ADMIN',
            ];
        } else {
            $data = [
                'bank_details_given' => $status
            ];
        }
        if ($this->Crud->ciUpdate($tableName, $data, $condition))
            $this->session->set_flashdata('success', "Success! Changes saved");
        else
            $this->session->set_flashdata('danger', "Something went wrong");
        $referer = basename($_SERVER['HTTP_REFERER']);
        redirect(__CLASS__ . '/' . $referer);
    }

    public function manual() {
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('kyc/manual-update');
        $this->load->view('layouts/footer');
    }

    public function kycUpdate() {
        if (isset($_POST['update'])) {
            extract($_POST);
            if ($this->Crud->ciCount('users', " `epin` = '$epin'") == 0) {
                $this->session->set_flashdata('danger', "ID not found");
            } else {
                $this->Crud->ciUpdate('users', array(
                    'account_number' => $account_number,
                    'ifsc' => $ifsc,
                    'bank_name' => $bank_name,
                    'payee_name' => $payee_name,
                    'passbook' => $passbookImage,
                    'pan' => $pan,
                    'branch_name' => $branch_name,
                    'bank_details_given' => 1,
                    'kyc_approved_by' => 1,
                    'kyc_approved_by_user_type' => 'ADMIN',
                ), " `epin` = '$epin'");
                $this->session->set_flashdata('success', "KYC Details updated for ID: " . $epin);
            }
            redirect('kyc/manual');
        }
    }
}
