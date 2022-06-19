<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct() {
        $this->middleware('role:admin|user')->only('index');
        $this->middleware('role:admin')->only('create', 'store', 'edit', 'update', 'destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(4);

        return view('admin.client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'company' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'address' => 'required|min:10',
        ]);
        $validated['password'] = bcrypt('password');
        $validated['active'] = 1;

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|string',
            'company' => 'required|min:3|string',
            'email' => 'required|email',
            'phone' => 'required|min:10|string',
            'address' => 'required|min:10|string',
            'active' => 'required|boolean',
            'password' => 'nullable|min:6|confirmed',
        ]);
        if($validated['password'] == null){
            $validated['password'] = $client->password;
        }else{
            $validated['password'] = bcrypt($validated['password']);
        }

        $client->update($validated);
        
        return redirect()->route('clients.index')->with('success', 'Client Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client Deleted Successfully');
    }
}
