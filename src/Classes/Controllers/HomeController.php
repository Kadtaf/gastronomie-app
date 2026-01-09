<?php
namespace App\Classes\Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->renderView("Home/index");
    }
}