<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showInvoicingData()
    {
        return view('entities.users.show-invoicing-data', [
            'user' => Auth::user()
        ]);
    }

    public function editInvoicingData()
    {
        return view('entities.users.edit-invoicing-data', [
            'user' => Auth::user()
        ]);
    }

    public function updateInvoicingData(Request $request)
    {
        //$user = Auth::user();
        $user = User::find(auth()->user()->id);
        $user->update([
            'identification' => $request->get('identification'),
            'commercial_name' => $request->get('commercial_name'),
            'address' => $request->get('address'),
            'certificate' => $request->file('certificate')->get(),
            'certificate_password' => $request->get('certificate_password')
        ]);
        return redirect()->route('users.show-invoicing-data');
    }
}
