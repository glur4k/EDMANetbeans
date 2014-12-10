<?php

/**
 * Description of Controller
 *
 * @author Sandro
 */
abstract class AjaxController {
    
    abstract protected function process($name, $id);
    
    public function toString() {
        print_r($this->_succeeded);
        /*
        echo json_encode(array(
            'succeeded' => $this->_succeeded,
            'failed' => $this->_failed
        ));
         
         */
    }
}
