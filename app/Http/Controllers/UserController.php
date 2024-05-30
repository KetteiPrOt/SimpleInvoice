<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|min:2|max:255'
        ], attributes: ['search' => 'buscar']);
        if($validator->fails()){
            return redirect()
                ->route('users.index')
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $query = User::orderBy('name');
        if(array_key_exists('search', $validated)){
            $search = '%' . $validated['search'] . '%';
            $query->whereRaw("name LIKE ?", [$search]);
        }
        return view('entities.users.index', [
            'users' => $query->paginate(15)->withQueryString()
        ]);
    }

    public function create()
    {
        return view('entities.users.create');
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return redirect()->route('users.show', $user->id);
    }

    public function show(User $user)
    {
        return view('entities.users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        if($user->hasRole('Administrador')){
            abort(403);
        }
        return view('entities.users.edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        if($user->hasRole('Administrador')){
            abort(403);
        }
        $user->delete();
        return redirect()->route('users.index');
    }
}
