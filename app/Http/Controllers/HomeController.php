<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories ; 
use App\Models\Books ; 
use App\Charts\ExpensesChart;


class HomeController extends Controller
{
  
      public function index(ExpensesChart $chart) 
      {
        $countCategories = Categories::count() ;
        $countBooks= Books::count() ;
         return view('dashboard' , ['countCategories'=>$countCategories , 'countBooks'=>$countBooks  , 'chart' => $chart->build()]) ; 
      }
}
