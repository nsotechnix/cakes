<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cashier_auth extends CI_Model
{

    public function checkLogin($epin, $password, $operatingSystem, $browser)
    {

        $this->db->where('email', $epin);

        $query = $this->db->get('store');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key) {

                $decPassword = $this->encryption->decrypt($key->password);

                if ($decPassword == $password) {

                    if ($key->is_active == 1) {

                        $loginData = [

                            'user_id' => $key->store_id,

                            'user_role' => 'STORE',

                            'os' => $operatingSystem,

                            'browser' => $browser,

                            'ip' => $_SERVER['REMOTE_ADDR'],

                            'login_date' => date('Y-m-d'),

                            'login_time' => date('H:i:s')

                        ];

                        $this->db->insert('login_history', $loginData);

                        $this->session->set_userdata('abStoreId', $key->store_id);

                        $this->session->set_userdata('abstoreEmail', $key->email);

                        $this->session->set_userdata('role', 'STORE');

                        $this->session->set_userdata('abStoreName', $key->store_name);

                        return '';
                    } else {

                        return "Your account has been disabled by administrator!";
                    }
                } else {

                    return 'Incorrect password';
                }
            }
        } else {

            return "Invalid Email or Phone Number";
        }
    }
}
