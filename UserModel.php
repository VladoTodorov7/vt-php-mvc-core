<?php 
namespace Vlgeto\PhpMvc;

use Vlgeto\PhpMvc\Db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
?>