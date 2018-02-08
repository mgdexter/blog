<?php
/**
 * Description:
 * User: Mustafa Genç
 * Date: 09/02/2018 01:28
 */

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class TinyMCE extends Field
{
    public static $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.6/jquery.tinymce.min.js'
    ];

    protected $view = 'admin.TinyMCE';

    public function render()
    {
        $this->script = "tinymce.init({ selector: '.{$this->getElementClass()[0]}'});";
        return parent::render();
    }
}