<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function getLoginHistory() {

        $this->db->where('user_id', $this->session->userdata('abAdminId'))->order_by('id', 'desc')->limit(6);

        $this->db->where('user_role', 'ADMIN');

        $data = $this->db->get('login_history');

        return $data->result();

    }

    public function changePassword($current, $new) {

        $this->db->where('id', $this->session->userdata('abAdminId'));

        $result = $this->db->get('administrator');

        foreach ($result->result() as $key) {

            $oldEncryptedPassword = $key->password;

        }

        $currentDecrypted = $this->encryption->decrypt($oldEncryptedPassword);

        if ($current == $currentDecrypted) {

            $newEncrypted = $this->encryption->encrypt($new);

            $updateData = [

                'password' => $newEncrypted

            ];

            $this->db->where('id', $this->session->userdata('abAdminId'));

            if ($this->db->update('administrator', $updateData)) {

                return "Password changed";

            } else {

                return "Something went wrong, please try again";

            }

        } else {

            return 'Access denied! Invalid password.';

        }

    }

}

?>