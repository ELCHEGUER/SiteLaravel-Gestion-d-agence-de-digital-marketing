<?php

/*namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Income;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::id()){
            if(Auth::user()->usertype=='1'){
                $allClients = Client::count();
                $task = Task::where('task_status' , 0)->count();
                $donetask = Task::where('task_status' , 1)->count();
                $user = auth()->user();
                $name =$user->name;
                $data = Task::where('responsable_id', $user->id)->get();

                $totalRevenues = Income::whereYear('date', now()->year)
                            ->whereMonth('date', now()->month)
                            ->sum('price');

                $totalCharges = Charge::whereYear('date', now()->year)
                            ->whereMonth('date', now()->month)
                            ->sum('price');

                $averagePrices = Charge::select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(price) as avg_price')
                )->groupBy('year', 'month')
                ->get();

                $averagePrices1 = Income::select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(price) as avg_price')
                )->groupBy('year', 'month')
                ->get();
                return view('admin.home' ,compact('allClients' , 'task' ,'data', 'averagePrices' , 'averagePrices1' , 'name' , 'donetask','totalRevenues','totalCharges'));

            }else{
                $user = auth()->user();
                $name =$user->name;
                $task = Task::where('task_status' , 0)->count();
                $donetask = Task::where('task_status' , 1)->count();
                $allClients = Client::count();
                $data = Task::where('responsable_id', $user->id)->get();
                return view('responsable.home' , compact('name' , 'allClients','data','task','donetask'));
            }
        }else{
            return redirect()->back();
        }
    }
}*/


namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use App\Models\Income;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::id()){
            if(Auth::user()->usertype=='1'){
                $allClients = Client::count();
                $task = Task::where('task_status', 0)->count();
                $donetask = Task::where('task_status', 1)->count();
                $user = auth()->user();
                $name = $user->name;
                $data1 = Task::where('responsable_id', $user->id)->get();
                //TOTAL CHARGE GROUP BY MONTH
                $averagePrices = Charge::select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(price) as avg_price')
                )->groupBy('year', 'month')->get();
                //TOTAL INCOME GROUP BY MONTH
                $averagePrices1 = Income::select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(price) as avg_price')
                )->groupBy('year', 'month')->get();
                //DIFFERNCE BETWEEN CHARGE AND INCOME GROUP BY MONTH
                $averagePrices3 = [];
                foreach ($averagePrices as $avgPrice) {
                    $key = $avgPrice->year . '-' . $avgPrice->month;
                    if (isset($averagePrices3[$key])) {
                        $averagePrices3[$key] += $avgPrice->avg_price;
                    } else {
                        $averagePrices3[$key] = $avgPrice->avg_price;
                    }
                }
                foreach ($averagePrices1 as $avgPrice) {
                    $key = $avgPrice->year . '-' . $avgPrice->month;
                    if (isset($averagePrices3[$key])) {
                        $averagePrices3[$key] -= $avgPrice->avg_price;
                    } else {
                        $averagePrices3[$key] = -$avgPrice->avg_price;
                    }
                }

                // Convert to collection and format the data
                $averagePrices3Collection = collect($averagePrices3);
                $labels = array_map(function($key) {
                    return explode('-', $key)[1]; // Extract the month part from the key
                }, $averagePrices3Collection->keys()->toArray());
                $data = $averagePrices3Collection->values()->toArray();

                //get Profit fot last month:
                $totalRevenues = Income::whereYear('date', now()->year)
                        ->whereMonth('date', now()->month)
                        ->sum('price');

                $totalCharges = Charge::whereYear('date', now()->year)
                        ->whereMonth('date', now()->month)
                        ->sum('price');

                $monthprofit = $totalRevenues - $totalCharges;


                return view('admin.home', compact('allClients', 'task', 'data','data1', 'labels', 'name', 'donetask' ,'averagePrices', 'averagePrices1' ,'monthprofit'));
        }else{
                $user = auth()->user();
                $name =$user->name;
                $task = Task::where('task_status', 0)->count();
                $donetask = Task::where('task_status', 1)->count();
                $allClients = Client::count();
                $data = Task::where('responsable_id', $user->id)->get();
                return view('responsable.home' , compact('name' , 'allClients','data','task','donetask'));
            }
        }else{
            return redirect()->back();
        }
    }
}
