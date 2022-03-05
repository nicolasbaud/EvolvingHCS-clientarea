<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $user = User::find($id);

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'tel' => 'required|numeric',
            'address' => 'required',
            'city' => 'required',
            'postalcode' => 'required',
            'region' => 'required',
            'country' => 'required',
        ]);
        User::where('id', $id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'tel' => $request->tel,
            'address' => $request->address,
            'city' => $request->city,
            'postalcode' => $request->postalcode,
            'region' => $request->region,
            'country' => $request->country,
        ]);

        return redirect(route('admin.user.edit', ['id' => $id]))->with('success', 'Utilisateur édité');
    }

    public function verify($id, Request $request)
    {
        if ($request->verify == 'true') {
            User::where('id', $id)->update([
                'email_verified_at' => now(),
            ]);
            return redirect(route('user.edit', ['id' => $id]))->with('success', 'Vérification forcé');
        } else {
            User::where('id', $id)->update([
                'email_verified_at' => NULL,
            ]);
            return redirect(route('admin.user.edit', ['id' => $id]))->with('success', 'Vérification annulé');
        }
    }

    public function changePassword($id, Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm' => 'required|same:password',
        ]);
        User::where('id', $id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('user.edit', ['id' => $id]))->with('success', 'Mot de passe édité');
    }

    public function balance($id, Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric',
        ]);
        User::where('id', $id)->update([
            'balance' => $request->balance,
        ]);

        return redirect(route('admin.user.edit', ['id' => $id]))->with('success', 'Balance édité');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return redirect(route('admin.users'))->with('success', 'Utilisateur supprimé');
    }
}
