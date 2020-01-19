<?php

class Controller{
    
    protected function validarData($value, $opc){
        //Evalue and validate data for option value
        switch ($opc) {
            case 1:
              if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$value)){
                return true;
              }
              break;
            case 2:
              if (preg_match('/^[a-zA-Z0-9]+$/',$value)){
                return true;
              }
              break;
            case 3:
              if ((strpos($value, "'") == null && strpos($value, '"')) == null) {
                return true;
              }
              break;
            default:
              return false;
              break;
          }
    }

}
