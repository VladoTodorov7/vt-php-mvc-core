<?php 
namespace Vlgeto\PhpMvc\Form;

use Vlgeto\PhpMvc\Model;

/**
 * Form
 * @package Vlgeto\PhpMvc\Form
 */

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);

        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public static function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}

?>