<?php

use Encore\Admin\Form;
use Encore\Admin\Widgets\Navbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Admin\Extensions\Form\TinyMCE;
use App\Admin\Extensions\Form\summernote;

Encore\Admin\Form::forget(['map','editor']);

Admin::navbar(function (Navbar $navbar) {
    $navbar->add(view('admin.navbar'))->render();
});

Form::extend('tinymce', TinyMCE::class);
Form::extend('summernote', summernote::class);