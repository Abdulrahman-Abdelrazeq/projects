<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
  
    public function index(){
        return view('dashboard.index');
    }

    public function ayat(){
        return view('dashboard.ayat');
    }
    public function ayatTags(){
        return view('dashboard.ayat-tags');
    }
    public function articleTags(){
        return view('dashboard.article-tags');
    }
    public function articleDetails(){
        return view('dashboard.articles-details');
    }
    public function allArticles(){
        return view('dashboard.articles');
    }
    public function ayaExplanation(){
        return view('dashboard.aya-explanation');
    }
    public function usersDisplay(){
        return view('dashboard.users');
    }
    public function langsDisplay(){
        return view('dashboard.langs');
    }

    public function vediosDisplay(){
        return view('dashboard.vedios');
    }

}
