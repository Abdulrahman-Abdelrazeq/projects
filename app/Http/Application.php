<?php
namespace App\Http;

class Application extends \Illuminate\Foundation\Application{

    public function publicPath()
    {
        return $this->basePath.'/../public_html/control-panel/';
    }

}
