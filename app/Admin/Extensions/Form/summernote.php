<?php
/**
 * Description:
 * User: Mustafa Genç
 * Date: 09/02/2018 01:39
 */

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class summernote extends Field
{
    public static $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/lang/summernote-tr-TR.min.js'
    ];

    public static $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css'
    ];

    protected $view = 'admin.summernote';

    public function render()
    {
        $this->script = "$('#{$this->getElementClass()[0]}').summernote({lang: 'tr-TR'});";
        return parent::render();
    }
}