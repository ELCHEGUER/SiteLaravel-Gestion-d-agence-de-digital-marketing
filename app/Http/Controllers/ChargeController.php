<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChargeController extends Controller
{
    public function index(){
        $charges= Charge::select(
            'id',
            'name' ,
            'price' ,
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('DAY(date) as day')
        )->get();

        // Calculate average price for each month
        $averagePrices = Charge::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(price) as avg_price')
        )->groupBy('year', 'month')->get();

        return view('admin.gestion.charge.index' ,compact('charges', 'averagePrices'));
    }

    public function create(){
        return view('admin.gestion.charge.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required' ],
            'price'=>['required', 'numeric'],
        ]);
        $insert=new Charge();

        $insert->name = $request->name;
        $insert->price = $request->price;
        $insert->date = now();
        $insert->save();
        return redirect('admin/gestion/charge')->with('success', 'Add  Charge successfully.');
    }

    public function destroy($id)
    {
        try {
            $data = Charge::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Charge deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the charge.');
        }
    }

}
