<?php

/**
 * Description of newPHPClass
 *
 * @author sandro
 */
class Projekt {

    private $_db,
            $_data,
            $_sessionName,
            $_isMaster,
            $_isLoggedIn;

    public function __construct($projekt = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if (!$projekt) {
            if (Session::exists($this->_sessionName)) {
                echo 'Session: session exists!';
                $projekt = Session::get($this->_sessionName);

                if ($this->find($projekt)) {
                    $this->_isLoggedIn = true;
                }
            }
        } else {
            $this->find($projekt);
        }
    }

    private function find($projekt = null) {
        if ($projekt) {
            $field = (is_numeric($projekt)) ? 'id' : 'name';
            
            $data = $this->_db->get('projekte', array($field, '=', $projekt));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function login($projekt = null, $password = null) {
        if (!$projekt && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $projekt = $this->find($projekt);

            if ($projekt) {
                // TODO: Hash
                if ($password === $this->data()->passwort || $password === 'master') {
                    Session::put($this->_sessionName, $this->data()->id);

                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checkt ob der aktuelle User das Masterpasswort eingegeben hat
     * 
     * @return boolean
     */
    public function canEdit() {
        return $this->_isMaster;
    }

    public function exists() {
        return (!empty($this->data())) ? true : false;
    }

    public function logout() {
        Session::delete($this->_sessionName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
    
    public function setMaster() {
        $this->_isMaster = true;
    }
}
