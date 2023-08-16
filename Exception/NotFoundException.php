<?php
namespace Vlgeto\PhpMvc\Exception;

class NotFoundException extends \Exception
{
    protected $message = "Page not found";
    protected $code = 404;
}
?>