<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('entities.clients.index', [
            'clients' => Client::all()
        ]);
    }

    public function create()
    {
        return view('entities.clients.create');
    }

    public function store(Request $request)
    {
        $client = Client::create([
            'name' => $request->get('name'),
            'identification' => $request->get('identification'),
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('clients.show', $client->id);
    }

    public function show(Client $client)
    {
        return view('entities.clients.show', [
            'client' => $client
        ]);
    }

    public function edit(Client $client)
    {
        return view('entities.clients.edit', [
            'client' => $client
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $client->update([
            'name' => $request->get('name'),
            'identification' => $request->get('identification')
        ]);
        return redirect()->route('clients.show', $client->id);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index');
    }
}
