<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Workshop_auth extends CI_Model
{

    public function checkLogin($email, $password, $operatingSystem, $browser)
    {

        // $this->db->where('email', $email);

        $this->db->where('email', $email)->or_where('phone', $email);

        $query = $this->db->get('workshop');

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $key) {

                $decPassword = $this->encryption->decrypt($key->password);

                if ($decPassword == $password) {

                    if ($key->is_verified == 1) {

                        $loginData = [

                            'user_id' => $key->id,

                            'os' => $operatingSystem,

                            'browser' => $browser,

                            'ip' => $_SERVER['REMOTE_ADDR'],

                            'login_date' => date('Y-m-d'),

                            'login_time' => date('H:i:s')


                        ];

                        $this->db->insert('login_history', $loginData);

                        $this->session->set_userdata('abWorkshopId', $key->id);

                        $this->session->set_userdata('abWorkshopEmail', $key->email);


                        $this->session->set_userdata('abWorkshopName', $key->workshop_name);
                    } else {

                        return "Email not verified";
                    }
                } else {

                    return 'Incorrect password';
                }
            }
        } else {

            return "Invalid username";
        }
    }
}
