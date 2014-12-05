<?php

/**
 * Description of Uploader
 *
 * @author Sandro
 */
class Uploader {

    private $_allowed = ['pdf'],
            $_uploaded = [],
            $_files = [],
            $_failed = [],
            $_succeeded = [];

    public function __construct($files, $ajax) {
        foreach ($files['file']['name'] as $key => $name) {
            if ($files['file']['error'][$key] === 0) {

                $temp = $_FILES['file']['tmp_name'][$key];
                
                $this->_files[] = array(
                    'name' => $name,
                    'temp' => $temp
                );
                
                // Validate Files
                
                
                if (move_uploaded_file($temp, "uploads/tmp/{$name}") === true) {
                    $this->_succeeded[] = array(
                        'name' => $name
                    );
                } else {
                    $this->_failed[] = array(
                        'name' => $name
                    );
                }
            }
        }

        if ($ajax !== '') {
            echo json_encode(array(
                'succeeded' => $this->_succeeded,
                'failed' => $this->_failed
            ));
        }
    }

    private function moveFiles($dir) {
        foreach ($this->_files as $file) {
        }
    }

    private function validate() {
        
    }

    public function errors() {
        return $this->_failed;
    }

    public function succeeded() {
        return $this->_succeeded;
    }

}
