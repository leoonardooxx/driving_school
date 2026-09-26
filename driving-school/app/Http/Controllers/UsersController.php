<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private function getAllUsers()
    {
        return User::paginate(min(max((int) request()->cookie('per_page', 10), 1), 100));
    }
    private function fieldsLabel()
    {
        return [
            'name' => ['label' => 'Name'],
            'last_name' => ['label' => 'Surname'],
            'active' => ['label' => 'Active', 'component' => 'switch'],
            'created_at' => ['label' => 'Created at'],
            'updated_at' => ['label' => 'Updated at'],
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header = self::fieldsLabel();
        $users = self::getAllUsers();
        return view('users.index', ['header' => $header, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
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
