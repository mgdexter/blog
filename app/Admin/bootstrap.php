<?php

use Encore\Admin\Widgets\Navbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

Encore\Admin\Form::forget(['map']);

Admin::navbar(function (Navbar $navbar) {
    $navbar->add(view('admin.navbar'))->render();
});