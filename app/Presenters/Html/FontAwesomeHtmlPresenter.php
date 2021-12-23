<?php

namespace App\Presenters\Html;

class FontAwesomeHtmlPresenter
{
    use BaseHtmlPresenter;

    public function icon($name = '')
    {
        return $this->tag('i', [
            'class' => [
                'fa',
                'fa-' . $name
            ]
        ]);
    }
}
