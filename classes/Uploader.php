<?php

/**
 * Description of Uploader
 *
 * @author Sandro
 */
class Uploader {
    
    private $_errors = [],
            $_succeeded = [];
    
    public function __construct($files) {
        foreach ($files as $file) {
            $this->_succeeded[] = $file;
        }
    }
    
    public function errors() {
        return $this->_errors;
    }
    
    public function succeeded() {
        return $this->_succeeded;
    }
}
