<?php


namespace App\Presenters\Html;


/**
 * Class HtmlPresenter
 * @package App\Presenters\Html
 *
 * @property Bootstrap4HtmlPresenter $bootstrap
 * @property FontAwesomeHtmlPresenter $fontawesome
 */
class HtmlPresenter
{
    use BaseHtmlPresenter;

    private $bootstrap;

    private $fontawesome;

    public function __construct()
    {
        $this->bootstrap = app()->make(Bootstrap4HtmlPresenter::class);
        $this->fontawesome = app()->make(FontAwesomeHtmlPresenter::class);
    }

    public function bootstrap()
    {
        return $this->bootstrap;
    }

    public function bs()
    {
        return $this->bootstrap();
    }

    public function fontawesome()
    {
        return $this->fontawesome;
    }

    public function fa()
    {
        return $this->fontawesome();
    }
}
