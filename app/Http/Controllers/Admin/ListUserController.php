<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListUserController extends Controller
{
    public function index()
{
    if (request()->ajax()) {
        $query = User::query();
        
        // Filter data berdasarkan role
        $query->where('roles', 'USER');
        
        return DataTables::of($query)
            ->addColumn('details', function ($item) {
                return '<a href="' .route('details-user',$item->id) . '" class="details-btn btn btn-primary">Details</a>';
            }) 
            ->rawColumns(['details'])
            ->make();
    }
    return view('pages.admin.list-users.index');
}

    public function details(string $id)
    {
        $item = User::findOrFail($id);
        // dd($item);
        if (request()->ajax()) {
            $list = Transaction::where('users_id', $id)->with(['user'])->get();
            return DataTables::of($list)
                ->make();
        }
        return view('pages.admin.list-users.details-user', [
            'item' => $item 
    ]);
    }

}
