<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(){
        $Clients = Client::all();
        return view('admin.clients.index',compact('Clients'));
    }

    public function indexR(){
        $Clients = Client::all();
        return view('responsable.clients.index',compact('Clients'));
    }

    public function create(){
        return view('admin.clients.create');
    }

    public function createR(){
        return view('responsable.clients.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required'],
            'phone'=>['required'],
            'email'=>['required'],
            'company'=>['required'],
        ]);
        $insert=new Client();

        $insert->name_client=$request->name;
        $insert->phone_client=$request->phone;
        $insert->email_client=$request->email;
        $insert->company_client=$request->company;

        $insert->save();
        return redirect('/admin/clients')->with('success','Add Charge successsfully.');
    }

    public function storeR(Request $request){
        $request->validate([
            'name'=>['required'],
            'phone'=>['required'],
            'email'=>['required'],
            'company'=>['required'],
        ]);
        $insert=new Client();

        $insert->name_client=$request->name;
        $insert->phone_client=$request->phone;
        $insert->email_client=$request->email;
        $insert->company_client=$request->company;

        $insert->save();
        return redirect('/respo/clients')->with('success','Add Charge successsfully.');
    }
}
