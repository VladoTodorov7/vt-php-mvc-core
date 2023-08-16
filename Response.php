<?php
namespace Vlgeto\PhpMvc;

/** 
 * Class Response
 * 
 * @package Vlgeto\PhpMvc
*/

class Response 
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url) {
        header('Location: ' . $url);
    }
}
?>