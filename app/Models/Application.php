<?php
namespace App\Models;

class Application extends \Illuminate\Foundation\Application{
    
    public function publicPath()
    {
        return $this->basePath.'/../public_html/abosamra-dashboard/';
    }
    
}