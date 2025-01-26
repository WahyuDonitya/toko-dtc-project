<?php

namespace App\Http\Controllers;

use App\Models\BranchModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUser = User::with('permissions')->get();
        return view('users.index', compact([
            'dataUser'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->fullname,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('admin');
            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('danger', 'Gagal membuat user, hubungi IT!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatepermission(Request $request)
    {
        $userId = $request->input('user_id');
        $permission = $request->input('permission');
        $isChecked = $request->input('is_checked');

        $user = User::findOrFail($userId);

        if ($isChecked == "true") {
            $user->givePermissionTo($permission);
        } else {
            $user->revokePermissionTo($permission);
        }

        return response()->json(['success' => true]);
    }

    public function updateactivation(Request $request)
    {
        $userId = $request->input('user_id');
        $isChecked = $request->input('is_checked');

        $user = User::findOrFail($userId);

        if ($isChecked == "true") {
            $user->update([
                'is_active' => true
            ]);
        } else {
            $user->update([
                'is_active' => false
            ]);
        }

        return response()->json(['success' => true]);
    }
}
