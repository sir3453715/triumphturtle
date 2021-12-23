<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 顯示名稱
     *
     * @var string
     */
    protected $name;

    /**
     * Slug
     *
     * @var string
     */
    protected $slug;


    /**
     * @return string
     */
    public function getName()
    {
        return trans($this->name);
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function isValid()
    {
        return $this->getName() && $this->getSlug();
    }
}
