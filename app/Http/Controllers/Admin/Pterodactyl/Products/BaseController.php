<?php

namespace App\Http\Controllers\Admin\Pterodactyl\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PterodactylProducts;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
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
    public function index()
    {
        $products = PterodactylProducts::all();

        return view('admin.pterodactyl.products.base', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:191',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'memory' => 'required|numeric|min:0',
            'cpu' => 'required|numeric|min:0',
            'swap' => 'required|numeric|min:-1',
            'disk' => 'required|numeric|min:0',
            'databases' => 'nullable|integer|min:0',
            'backups' => 'nullable|integer|min:0',
            'allocations' => 'sometimes|nullable|integer|min:0',
            'nest' => 'required|integer|min:0',
            'egg' => 'required|integer|min:0',
            'node' => 'required|bail|integer|exists:pterodactyl_nodes,id',
            'visibility' => 'required|bail|string|in:public,private',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.pterodactyl.products'))
                    ->withErrors($validator)
                    ->withInput();
        }

        PterodactylProducts::create($request->all());

        return redirect(route('admin.pterodactyl.products'))->with('success', 'Produit crée');
    }

    public function update($id, Request $request)
    {
        if (PterodactylProducts::where('id', $id)->count() == '0') {
            throw new NotFoundHttpException();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:191',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'memory' => 'required|numeric|min:0',
            'cpu' => 'required|numeric|min:0',
            'swap' => 'required|numeric|min:-1',
            'disk' => 'required|numeric|min:0',
            'databases' => 'nullable|integer|min:0',
            'backups' => 'nullable|integer|min:0',
            'allocations' => 'sometimes|nullable|integer|min:0',
            'nest' => 'required|integer|min:0',
            'egg' => 'required|integer|min:0',
            'node' => 'required|bail|integer|exists:pterodactyl_nodes,id',
            'visibility' => 'required|bail|string|in:public,private',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.pterodactyl.products'))->with('danger', $validator->errors());
        }

        $product = PterodactylProducts::find($id);
        
        $product->update($request->all());

        return redirect(route('admin.pterodactyl.products'))->with('success', 'Produit édité');
    }

    public function delete($id)
    {

        PterodactylNodes::where('id', $id)->delete();

        return redirect(route('admin.pterodactyl.products'))->with('success', 'Node supprimé');
    }
}
