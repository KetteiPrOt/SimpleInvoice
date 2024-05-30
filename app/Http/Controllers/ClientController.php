<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|min:2|max:255'
        ], attributes: ['search' => 'buscar']);
        if($validator->fails()){
            return redirect()
                ->route('clients.index')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $query = Client::where(
            'user_id',
            Auth::user()->id
        );
        if(array_key_exists('search', $validated)){
            $search = '%' . $validated['search'] . '%';
            $query->whereRaw("name LIKE ?", [$search]);
        }
        $clients = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('entities.clients.index', [
            'clients' => $clients
        ]);
    }

    public function create()
    {
        return view('entities.clients.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'identification' => ['required', 'string', 'size:13', 'regex:/^[0987654321]{13}$/'],
            'email' => 'required|string|email|lowercase|max:255'
        ], attributes: [
            'name' => 'nombre',
            'identification' => 'identificación',
            'email' => 'correo electrónico'
        ]);
        if($validator->fails()){
            return redirect()
                ->route('clients.create')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $client = Client::create([
            'name' => $validated['name'],
            'identification' => $validated['identification'],
            'email' => $validated['email'],
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('clients.show', $client->id);
    }

    public function show(Client $client)
    {
        $this->authorize($client);
        return view('entities.clients.show', [
            'client' => $client
        ]);
    }

    public function edit(Client $client)
    {
        $this->authorize($client);
        return view('entities.clients.edit', [
            'client' => $client
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize($client);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'identification' => ['required', 'string', 'size:13', 'regex:/^[0987654321]{13}$/'],
            'email' => 'required|string|email|lowercase|max:255'
        ], attributes: [
            'name' => 'nombre',
            'identification' => 'identificación',
            'email' => 'correo electrónico'
        ]);
        if($validator->fails()){
            return redirect()
                ->route('clients.edit', $client->id)
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $client->update([
            'name' => $validated['name'],
            'identification' => $validated['identification'],
            'email' => $validated['email']
        ]);
        return redirect()->route('clients.show', $client->id);
    }

    public function destroy(Client $client)
    {
        $this->authorize($client);
        $client->delete();
        return redirect()->route('clients.index');
    }

    private function authorize(Client $client): void
    {
        if($client->user_id !== Auth::user()->id){
            abort(403);
        }
    }
}
