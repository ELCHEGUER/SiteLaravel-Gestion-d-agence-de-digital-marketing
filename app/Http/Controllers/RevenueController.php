<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Income;


class RevenueController extends Controller
{
    public function home(){
        return view('admin.home');
    }

    public function index(){
        $revenues= Income::select(
            'id',
            'name' ,
            'price' ,
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('DAY(date) as day')
        )->orderBy('date')->get();

        // Calculate average price for each month
        $averagePrices = Income::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(price) as avg_price')
        )->groupBy('year', 'month')->get();

        return view('admin.gestion.revenue.index' ,compact('revenues', 'averagePrices'));
    }

    public function create(){
        return view('admin.gestion.revenue.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required'],
            'price'=>['required'],
        ]);
        $insert=new Income();

        $insert->name=$request->name;
        $insert->price=$request->price;
        $insert->date=now();

        $insert->save();
        return redirect('admin/gestion/revenue')->with('success','Add Income successsfully.');
    }

    public function destroy($id)
    {
        try {
            $data = Income::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Charge deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the charge.');
        }
    }
}
