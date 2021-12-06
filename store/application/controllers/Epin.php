<?php
defined('BASEPATH') or exit('nikal bey');

class Epin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('Sms_helper');
        if (!$this->session->userdata('abStoreName')) {
            redirect('authentication/login');
        }
    }

    public function generate()
    {
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('epin/generate');
        $this->load->view('layouts/footer');
    }

    public function generator()
    {
        if (isset($_POST['generate'])) {
            extract($_POST);
            for ($i = 1; $i <= $epins; $i++) {
                $epin = epinValidator();
                $data = [
                    'epin' => $epin,
                    'generated_by' => 'ADMIN',
                    'owner' => 'ADMIN',
                    'generated_date' => date('Y-m-d'),
                    'generated_time' => date('H:i:s')
                ];
                $creator = $this->Crud->ciCreate('epins', $data);
                if ($i == $epins) {
                    $this->session->set_flashdata('success', "Success, " . $i . " epins generated");
                    redirect('epin/generate/');
                }
            }
        }
    }

    public function fresh()
    {
        $userEpin = $this->session->userdata('abMyEpin');
        $data['freshCountAvailable'] = $this->Crud->ciCount("epins", " `status` = '1' AND `owner` = '$userEpin' AND `used` = '0'");
        $data['freshCount'] = $this->Crud->ciCount("epins", " `status` = '1' AND `used` = '0'");
        if ($userEpin == 'ADMIN') {
            $data['EPINS'] = $this->Crud->ciRead("epins", " `status` = '1' AND `used` = '0' AND `owner` = 'ADMIN'");
        } else {
            $data['EPINS'] = $this->Crud->ciRead("epins", " `status` = '1' AND `used` = '0' AND `owner` = '$userEpin'");
        }
        $data['VENDORS'] = $this->Crud->ciRead('seller', " `id` <> '0'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('epin/fresh', $data);
        $this->load->view('layouts/footer');
    }

    public function transferer()
    {
        if (isset($_POST['transfer'])) {
            $userEpin = $this->session->userdata('abMyEpin');
            extract($_POST);
            $ifEpinExists = $this->Crud->ciCount('seller', " `id` = '$transfer_to'");
            if ($ifEpinExists < 1) {
                $this->session->set_flashdata('danger', "Invalid EPIN or EPIN not used, Unable to transfer");
            } else {
                $limitations = (int)$transfer_quantity;
                $epinList = $this->Crud->ciRead("epins", " `status` = '1' AND `used` = '0' AND `owner` = '$userEpin' LIMIT $limitations");
                foreach ($epinList as $key) {
                    $thisEpin = $key->epin;
                    $transferData = [
                        'epin' => $thisEpin,
                        'transfered_from' => $this->session->userdata('abMyEpin'),
                        'transfered_to' => $transfer_to,
                        'transfered_date' => date('Y-m-d'),
                        'transfered_time' => date('H:i:s')
                    ];
                    $updateData = [
                        'owner' => $transfer_to
                    ];
                    if ($this->Crud->ciUpdate('epins', $updateData, " `epin` = '$thisEpin'")) {
                        $historyCreate = $this->Crud->ciCreate('epin_transfer_history', $transferData);
                        $this->session->set_flashdata('success', "ePins transferred");
                    }
                }
            }
            redirect('epin/fresh');
        }
    }

    public function validateEpin()
    {
        $val = $_POST['val'];
        $ifExists = $this->Crud->ciCount("users", " `epin` = '$val'");
        if ($ifExists == 1) {
            $userData = $this->Crud->ciRead("users", " `epin` = '$val'");
            $data['err'] = 'FOUND';
            $data['user'] = $userData[0]->name;
        } else {
            $data['err'] = 'NOT_FOUND';
        }
        echo json_encode($data);
    }

    public function used()
    {
        $data['USED_EPINS'] = $this->Crud->ciRead("epins", " `status` = '1' AND `used` = '1'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('epin/used', $data);
        $this->load->view('layouts/footer');
    }

    public function report()
    {
        $userEpin = $this->session->userdata('abMyEpin');
        $data['REPORT'] = $this->Crud->ciRead("epin_transfer_history", " `status` = '1' AND `transfered_from` = '$userEpin'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('epin/report', $data);
        $this->load->view('layouts/footer');
    }
}
