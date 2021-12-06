<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier_auth extends CI_Model {

    public function checkLogin($epin, $password, $operatingSystem, $browser) {

        $this->db->where('email', $epin);

        $query = $this->db->get('cashier');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key) {

                $decPassword = $this->encryption->decrypt($key->password);

                if ($decPassword == $password) {

                    if ($key->is_active == 1) {

                        $loginData = [

                            'user_id' => $key->id,

                            'user_role' => 'CASHIER',

                            'os' => $operatingSystem,

                            'browser' => $browser,

                            'ip' => $_SERVER['REMOTE_ADDR'],

                            'login_date' => date('Y-m-d'),

                            'login_time' => date('H:i:s')

                        ];

                        $this->db->insert('login_history', $loginData);

                        $this->session->set_userdata('abCashierId', $key->id);

                        $this->session->set_userdata('abCashierEmail', $key->email);

                        $this->session->set_userdata('role', 'CASHIER');

                        $this->session->set_userdata('abCashierName', $key->name);

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
