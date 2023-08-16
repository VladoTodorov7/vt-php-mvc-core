<?php 
namespace Vlgeto\PhpMvc\Form;

use Vlgeto\PhpMvc\Form\BaseField;

class TextAreaField extends BaseField
{

    public function renderInput(): string {
        return sprintf(
            '<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }
    
}

?>