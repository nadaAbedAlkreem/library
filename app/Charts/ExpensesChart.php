<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Categories ; 
use App\Models\Books ; 
use Illuminate\Support\Facades\DB;

class ExpensesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $categoies  = Categories::leftJoin('books', 'categories.id', '=', 'books.category_id')
        ->select('categories.name as category_name', DB::raw('COUNT(Books.id) as book_count'))
        ->groupBy('categories.name')
        ->get();
        $categoriesArray = $categoies->toArray() ; 
        $namesCategory = array_column($categoriesArray, 'category_name');
        $bookCount = array_column($categoriesArray, 'book_count');
           return $this->chart->barChart()
            ->setTitle('Expression of each category and how many books it has')
            ->setSubtitle('category')
            ->addData('books', $bookCount)
            ->setXAxis($namesCategory);
    }
}
