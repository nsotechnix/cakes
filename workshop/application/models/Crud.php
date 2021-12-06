<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

    public function ciRead($TableName, $Condition) {

        if ($Condition == '')

            $Condition = ' 1';

        $this->db->where($Condition);

        $data = $this->db->get($TableName);

        return $data->result();

    }

    public function ciCreate($data, $TableName) {

        if ($this->db->insert($data, $TableName))

            return $this->db->insert_id();

        else

            return false;

    }

    public function ciUpdate($TableName, $Fields, $Condition) {

        if ($Condition == '')

            $Condition = ' 1';

        $this->db->where($Condition);

        if ($this->db->update($TableName, $Fields))

            return true;

        else

            return false;

    }

    public function ciDelete($TableName, $Condition) {

        if ($Condition == '')

            $Condition = ' 1';

        $this->db->where($Condition);

        if ($this->db->delete($TableName))

            return true;

        else

            return false;

    }

    public function ciCount($TableName, $Condition) {

        if ($Condition == '')

            $Condition = ' 1';

        $this->db->where($Condition);

        $result = $this->db->get($TableName);

        if ($result)

            return $result->num_rows();

        else

            return false;

    }

}

?>