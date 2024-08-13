<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\EmpresaIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use EmpresaIdTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'ativo' => 1,
            'empresaId' => 1,
        ]);

        return $this->sendResponse($user, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        $user = $user->where('id', $request->id)
            ->where('empresaId', $this->empresaId())
            ->get();

        return $this->sendResponse($user, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
