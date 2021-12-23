<?php

namespace App\Presenters\Admin;

use App\Presenters\Html\HtmlPresenter;
use Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

class AdminTitlePresenter
{

    public function get()
    {
        $siteName = app('Option')->site_name;
        $Pagetitle = Route::getCurrentRoute()->getName();
        if(Lang::has($Pagetitle)) {
            return trans($Pagetitle) . ' - ' . $siteName;
        } else {
            return $siteName;
        }
    }
}
