<?php
defined('BASEPATH') or exit('nikal bey');

class Members extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('sms');
        if (!$this->session->userdata('abAdminId')) {
            redirect('authentication/login');
        }
    }

    public function activeMembers() {
        $data['ACTIVE_MEMBERS'] = $this->Crud->ciRead('users', " `is_active` = '1' AND `user_type` = 'USER'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/active', $data);
        $this->load->view('layouts/footer');
    }

    public function changeStatus() {
        $tableName = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $conditionId = $this->uri->segment(5);
        $condition = " `id` = '$conditionId'";
        $data = [
            'is_active' => $status
        ];
        if ($this->Crud->ciUpdate($tableName, $data, $condition))
            $this->session->set_flashdata('success', "Success! Changes saved");
        else
            $this->session->set_flashdata('danger', "Something went wrong");
        $referer = basename($_SERVER['HTTP_REFERER']);
        redirect(__CLASS__ . '/' . $referer);
    }

    public function blockedMembers() {
        $data['INACTIVE_MEMBERS'] = $this->Crud->ciRead('users', " `is_active` = '0' AND `user_type` = 'USER'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/inactive', $data);
        $this->load->view('layouts/footer');
    }

    public function heldMembers() {
        $data['HELD_MEMBERS'] = $this->Crud->ciRead('users', " `is_active` = '2'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/held', $data);
        $this->load->view('layouts/footer');
    }

    public function wallets() {
        $data['WALLETS'] = $this->Crud->ciRead('wallet', " `is_active` = '1' ORDER BY `available` DESC");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/wallets', $data);
        $this->load->view('layouts/footer');
    }

    public function withdraw() {
        if (isset($_POST['pay'])) {
            extract($_POST);
            $this->db
                ->trans_start();
            if ($this->Crud->ciCreate('payments', array(
                'user_id' => $user_id,
                'vendor_id' => $vendor_id,
                'user_epin' => $user_epin,
                'amount' => $amount,
                'admin_charge' => ($amount / 100 * ADMIN_CHARGE),
                'tds' => ($amount / 100 * ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID)),
                'paid_amount' => $amount - ($amount / 100 * ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID)) - ($amount / 100 * ADMIN_CHARGE),
                'transferred_on' => time(),
                'tds_percentage' => ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID),
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'ifsc' => $ifsc,
                'payee_name' => $payee_name
            ))) {
                $available = (float)$this->Crud->ciRead('wallet', " `epin` = '$user_epin'")[0]->available;
                $this->Crud->ciUpdate('wallet', array(
                    'available' => $available - (float)$amount
                ), " `epin` = '$user_epin'");
                $this->Crud->ciCreate('transaction_history', array(
                    'epin' => $user_epin,
                    'narration' => 'Debit payment amount',
                    'debit' => $amount,
                    'updated_amount' => $available - (float)$amount,
                    'updated_on' => time(),
                    'updated_date' => date('Y-m-d')
                ));
                // send message here
                $userDetails = $this->Crud->ciRead('users', " `epin` = '$user_epin'");
                $paidAmount = $available - (float)$amount;
                $message = "Hi " . $userDetails[0]->name . ", Rs. " . $paidAmount . " has been transferred to your account from your wallet. It will be reflected in your account shortly. Keep earning. " . PROJECT_NAME . " SANDZ GLOBAL UNIQUE MARKETING PRIVATE LIMITED";
                sendsms($message, $userDetails[0]->phone);
                $this->session->set_flashdata('success', "Amount of &#8377;" . $amount . " has been deducted from ePin: " . $user_epin . "'s wallet");
            } else {
                $this->session->set_flashdata('danger', "Opps! Something went wrong, please try again!");
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_complete();
            }
        }
        redirect('members/wallets');
    }

    // public function downline() {
    //     $data['MEMBERS'] = $this->Crud->ciRead('users', " `id` <> '0'");
    //     $this->load->view('layouts/header');
    //     $this->load->view('layouts/bar');
    //     $this->load->view('layouts/sub-header');
    //     $this->load->view('layouts/nav');
    //     $this->load->view('members/downline', $data);
    //     $this->load->view('layouts/footer');
    // }

    public function branches() {
        if ($this->uri->segment(3)) {
            $epin = $this->uri->segment(3);
            $data['BRANCHES'] = $this->Crud->ciRead('users', " `position_under` = '$epin'");
        } else {
            $data['BRANCHES'] = $this->Crud->ciRead('seller', " `id` <> '0'");
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/branches', $data);
        $this->load->view('layouts/footer');
    }

    public function treeView() {
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/tree');
        $this->load->view('layouts/footer');
    }

    public function treeFrame() {
        $SHOW_LEVELS = 4;
        $ROOT_EPIN = $this->session->userdata('abVendorId');
        $myLevel = isset($this->Crud->ciRead('users', " `epin` = '$ROOT_EPIN'")[0]->level_from_top) ? $this->Crud->ciRead('users', " `epin` = '$ROOT_EPIN'")[0]->level_from_top : 1;
        if ($this->uri->segment(3) && strlen($this->uri->segment(3)) == 8) {
            $ROOT_EPIN = $this->uri->segment(3);
            $currentUser = $this->Crud->ciRead('users', " `epin` = '$ROOT_EPIN'");
            if (!isset($currentUser[0]->epin)) {
                $this->session->set_flashdata('warning', "The ePin you specified is cannot be found");
                redirect('members/treeFrame/' . $currentUser);
                return false;
            }
            $myLevel = $currentUser[0]->level_from_top;
        } else {
            $ROOT_EPIN = $this->session->userdata('userEpin');
        }
        $this->load->view('members/tree-frame', compact('ROOT_EPIN', 'SHOW_LEVELS', 'myLevel'));
    }

    public function editMember() {
        if (!empty($_POST)) {
            extract($_POST);
            if ($this->Crud->ciUpdate('users', array(
                'name' => $name,
                'phone' => $phone
            ), " `id` = '$id'")) {
                $this->session->set_flashdata('success', "User modified");
            } else {
                $this->session->set_flashdata('danger', "Opps! Something went wrong, please try again!");
            }
        }
        redirect('members/activeMembers');
    }

    public function returnCredentials() {
        $this->load->library('encryption');
        if (!empty($_POST)) {
            extract($_POST);
            $userDetails = $this->Crud->ciRead('users', " `id` = '$id'");
            echo json_encode(array(
                'status' => 200,
                'phone' => $userDetails[0]->phone,
                'password' => $this->encryption->decrypt($userDetails[0]->password)
            ));
        } else {
            echo json_encode(array(
                'status' => 500,
                'message' => "Something went wrong"
            ));
        }
    }

    public function rank_downline() {
        $data = array();
        if (isset($_POST['filter'])) {
            extract($_POST);
            $userId = $epin;
            if ($this->Crud->ciCount('users', " (`epin` = '$epin' OR `phone` = '$epin')") > 0) {
                $data['MY_LEVEL'] = $this->Crud->ciRead('users', " (`epin` = '$userId' OR `phone` = '$userId'")[0]->level_from_top;
                // echo $this->Crud->ciCount('users', " (`epin` = '$epin' OR `phone` = '$epin')");
            } else {
                $this->session->set_flashdata('danger', "User ID not found");
                redirect('members/rank_downline');
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/rank-downline', $data);
        $this->load->view('layouts/footer');
    }

    public function downline() {
        $data = array();
        if (isset($_POST['filter'])) {
            extract($_POST);
            // $data['myEpin'] = $rootEpin;
            $data['myEpin'] = $this->Crud->ciRead('users', " (`epin` = '$rootEpin' OR `phone` = '$rootEpin')")[0]->epin;
            if ($this->Crud->ciCount('users', " (`epin` = '$rootEpin' OR `phone` = '$rootEpin')") == 0) {
                $this->session->set_flashdata('danger', "ID not found");
                redirect('members/downline');
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/downline', $data);
        $this->load->view('layouts/footer');
    }

    public function expired() {
        $data['EXPIRED'] = $this->Crud->ciRead('users', " `is_active` = '3'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/expired', $data);
        $this->load->view('layouts/footer');
    }

    public function unblockFromExpired() {
        $id = $this->uri->segment(3);
        $this->Crud->ciUpdate('users', array(
            'is_active' => 1,
            'is_admin_unlocked_after_expiration' => 1
        ), " `id` = '$id'");
        $this->session->set_flashdata('success', "ID Unblocked after expiration");
        redirect('members/expired');
    }

    public function paymentRequests() {
        $data['PAYMENT_REQUESTS'] = $this->Crud->ciRead('withdrawl_requests', " `status` = '0'");
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('members/requests', $data);
        $this->load->view('layouts/footer');
    }

    public function approveRequest() {
        if (isset($_POST['pay'])) {
            extract($_POST);
            $this->db
                ->trans_start();
            if ($this->Crud->ciCreate('payments', array(
                'user_id' => $user_id,
                'vendor_id' => $vendor_id,
                'user_epin' => $user_epin,
                'amount' => $amount,
                'admin_charge' => ($amount / 100 * ADMIN_CHARGE),
                'tds' => ($amount / 100 * ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID)),
                'paid_amount' => $amount - ($amount / 100 * ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID)) - ($amount / 100 * ADMIN_CHARGE),
                'transferred_on' => time(),
                'tds_percentage' => ($pan == '' ? TDS_CHARGE_PERCENTAGE_PAN_INVALID : TDS_CHARGE_PERCENTAGE_PAN_VALID),
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'ifsc' => $ifsc,
                'payee_name' => $payee_name
            ))) {
                //update request
                $this->Crud->ciUpdate('withdrawl_requests', array(
                    'status' => 1,
                    'paid_on' => time()
                ), " `id` = '$request_id'");
                // send message here
                $userDetails = $this->Crud->ciRead('users', " `epin` = '$user_epin'");
                $paidAmount = (float)$this->Crud->ciRead('wallet', " `epin` = '$user_epin'")[0]->available - (float)$amount;
                $message = "Hi " . $userDetails[0]->name . ", Rs. " . $paidAmount . " has been transferred to your account from your wallet. It will be reflected in your account shortly. Keep earning. " . PROJECT_NAME . " SANDZ GLOBAL UNIQUE MARKETING PRIVATE LIMITED";
                sendsms($message, $userDetails[0]->phone);
                $this->session->set_flashdata('success', "Amount of &#8377;" . $amount . " has been deducted from ePin: " . $user_epin . "'s wallet");
            } else {
                $this->session->set_flashdata('danger', "Opps! Something went wrong, please try again!");
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_complete();
            }
        }
        redirect('members/paymentRequests');
    }

    public function rejectRequest() {
        $request_id = $this->uri->segment(3);
        $requestDetails = $this->Crud->ciRead('withdrawl_requests', " `id` = '$request_id' AND `status` = '0'");
        if (count($request_id)) {
            //update request
            $user_epin = $requestDetails[0]->epin;
            $this->Crud->ciUpdate('withdrawl_requests', array(
                'status' => 2,
                'rejected_on' => time()
            ), " `id` = '$request_id'");
            $available = (float)$this->Crud->ciRead('wallet', " `epin` = '$user_epin'")[0]->available;
            $this->Crud->ciUpdate('wallet', array(
                'available' => $available + (float)$requestDetails[0]->amount
            ), " `epin` = '$user_epin'");

            $this->Crud->ciCreate('transaction_history', array(
                'epin' => $user_epin,
                'narration' => 'Refund of rejected amount',
                'credit' => $requestDetails[0]->amount,
                'updated_amount' => $available + (float)$requestDetails[0]->amount,
                'updated_on' => time(),
                'updated_date' => date('Y-m-d')
            ));
            $this->session->set_flashdata('warning', "Payment Rejected!");
        } else {
            $this->session->set_flashdata('danger', "Payment already reviewed!");
        }
        redirect('members/paymentRequests');
    }
}
