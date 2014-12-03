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

    public function __construct($files, $dir, $ajax) {
        foreach ($files['file']['name'] as $key => $name) {
            if ($files['file']['error'][$key] === 0) {

                $temp = $_FILES['file']['tmp_name'][$key];

                // File Validation 

                $this->_files[] = array(
                    'name' => $name,
                    'temp' => $temp
                );
            }
        }
        
        $this->moveFiles($dir);
        
        if ($ajax !== '') {
            echo json_encode(array(
                'succeeded' => $this->_succeeded,
                'failed' => $this->_failed
            ));
        }
    }

    private function moveFiles($dir) {
        foreach ($this->_files as $file) {
            if (move_uploaded_file($file['temp'], $dir . $file['name']) === true) {
                $this->_succeeded[] = array(
                    'name' => $file['name']
                );
            } else {
                $this->_failed[] = array(
                    'name' => $file['name']
                );
            }
        }
    }

    public function errors() {
        return $this->_failed;
    }

    public function succeeded() {
        return $this->_succeeded;
    }
}
