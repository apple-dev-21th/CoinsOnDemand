<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/application/libraries/tcpdf/tcpdf.php";
require_once $root . "/application/libraries/fpdi/fpdi.php";
/**
 * Description of pdf_model
 *
 * @author aelbuni
 */
class pdf_model extends FPDI {
  //put your code here
  var $files = array();
  function setFiles($files) {
      $this->files = $files;
  }
  
  function concat() {
      foreach($this->files AS $file) {
          $pagecount = $this->setSourceFile($file);
          for ($i = 1; $i <= $pagecount; $i++) {
              $tplidx = $this->ImportPage($i);
              $s = $this->getTemplatesize($tplidx);
              $this->setPrintHeader(false);
              $this->setPrintFooter(false);
              $this->AddPage('P', array($s['w'], $s['h']));
              $this->useTemplate($tplidx);
          }
      }
  }
}

?>
