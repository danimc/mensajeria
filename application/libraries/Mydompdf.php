<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;


class Mydompdf extends Dompdf
{
    function __construct()
    {
        parent::__construct();
    }
}

/**
* 
*/

/* application/libraries/Pdf.php */

?>