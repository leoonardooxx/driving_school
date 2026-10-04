<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    private function getAllUsers()
    {
        return User::paginate(min(max((int) request()->cookie('per_page', 10), 1), 100));
    }
    private function fieldsLabel()
    {
        return [
            'id' => ['label' => 'ID', 'show_on_table' => false],
            'image_url' => ['label' => 'Image', 'component' => 'table.image', 'rounded' => true, 'show_on_table' => true],
            'username' => ['label' => 'Username', 'show_on_table' => false],
            'name' => ['label' => 'Name', 'show_on_table' => true],
            'last_name' => ['label' => 'Surname', 'show_on_table' => true],
            'nif' => ['label' => 'NIF', 'show_on_table' => false],
            'profile' => ['label' => 'Profile', 'show_on_table' => false],
            'email' => ['label' => 'Email', 'show_on_table' => false],
            'email_verified_at' => ['label' => 'Email verified at', 'show_on_table' => false],
            'active' => ['label' => 'Active', 'component' => 'switch', 'show_on_table' => true],
            'created_at' => ['label' => 'Created at', 'show_on_table' => true],
            'updated_at' => ['label' => 'Updated at', 'show_on_table' => true],
        ];
    }
    /**
     * Layout of the create/edit form, also used by the details panel.
     * 'column' is the table column the value is read from when it differs from 'name';
     * 'beside' fields stack next to an avatar; 'create_only' fields are hidden while editing.
     */
    private function formLayout()
    {
        return [
            ['name' => 'image', 'label' => 'Image', 'type' => 'avatar', 'column' => 'image_url', 'beside' => [
                ['name' => 'name', 'label' => 'Name'],
                ['name' => 'last_name', 'label' => 'Surname'],
            ]],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'nif', 'label' => 'NIF'],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'create_only' => true],
            ['name' => 'password_confirmation', 'label' => 'Confirm password', 'type' => 'password', 'create_only' => true],
            ['name' => 'profile', 'label' => 'Profile', 'type' => 'select', 'value' => 'student', 'options' => ['student' => 'Student', 'instructor' => 'Instructor', 'admin' => 'Admin']],
            ['name' => 'active', 'label' => 'Active', 'type' => 'switch', 'value' => true],
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header = self::fieldsLabel();
        $form = self::formLayout();
        $users = self::getAllUsers();
        return view('users.index', ['header' => $header, 'form' => $form, 'users' => $users]);
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
    public function store(StoreUserRequest $request)
    {
        $data = [...$request->validated(), 'active' => $request->boolean('active')];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('users.index');
    }

    /**
     * Serve the user's profile picture with long-lived browser caching.
     */
    public function avatar(User $user)
    {
        abort_unless($user->image && Storage::disk('public')->exists($user->image), 404);

        return Storage::disk('public')->response($user->image, null, [
            'Cache-Control' => 'private, max-age=31536000, immutable',
        ]);
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
    public function update(UpdateUserRequest $request, User $user)
    {
        // A blank password on the edit form keeps the current one.
        $data = [...array_filter($request->validated(), fn ($value) => $value !== null), 'active' => $request->boolean('active')];

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
