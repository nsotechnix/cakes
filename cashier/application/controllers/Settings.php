<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->library('form_validation');

        // $this->load->library('upload');

        $this->load->model('Settings_model');

        $this->load->library('encryption');

        if (!$this->session->userdata('abCashierId')) {

            redirect('authentication/login');
        }
    }

    public function password()
    {

        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/nav');
        $this->load->view('layouts/sub-header');
        $this->load->view('settings/password');
        $this->load->view('layouts/footer');
    }

    public function changePassword()
    {

        $this->form_validation->set_rules('password', 'Current password', 'required');

        $this->form_validation->set_rules('new_password', 'New password', 'required');

        if ($this->form_validation->run()) {

            $output = $this->Settings_model->changePassword($this->input->post('password'), $this->input->post('new_password'));

            if ($output == 'Password changed') {

                $message = 'success';
            } else {

                $message = 'danger';
            }

            $this->session->set_flashdata($message, $output);

            redirect('settings/password');
        } else {

            $this->session->set_flashdata('danger', 'Please enter valid passwords');

            redirect('settings/password');
        }
    }

    //Change Password alternate
    public function changepass()
    {


        // $data['title'] = 'Change Password';

        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldpass', 'old password', 'callback_password_check');
        $this->form_validation->set_rules('newpass', 'new password', 'required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[newpass]');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == false) {
            $this->load->view('layouts/header');
            $this->load->view('layouts/bar');
            $this->load->view('layouts/nav');
            $this->load->view('layouts/sub-header');
            $this->load->view('settings/password');
            $this->load->view('layouts/footer');
        } else {


            $id = $this->session->userdata('abCashierId');

            $newpass = $this->input->post('newpass');

            $this->Settings_model->update_user($id, array('password' => $newpass));

            redirect('settings/password');
        }
    }

    //Change password alternate

    public function logs()
    {

        $data['LOGIN_HISTORY'] = $this->Settings_model->getLoginHistory();

        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/nav');
        $this->load->view('layouts/sub-header');
        $this->load->view('settings/logs', $data);
        $this->load->view('layouts/footer');
    }

    public function logout()
    {

        $data = $this->session->all_userdata();

        foreach ($data as $key => $value) {

            $this->session->unset_userdata($key);
        }

        redirect('authentication/login');
    }
}
