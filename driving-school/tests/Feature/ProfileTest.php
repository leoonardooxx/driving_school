<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

function profileUser(array $attributes = []): User
{
    return User::factory()->create($attributes + ['username' => 'ana', 'name' => 'Ana', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'student', 'active' => true]);
}

test('guests are sent to the login page', function () {
    $this->get('/profile')->assertRedirect('/login');
});

test('profile page shows the logged-in user and is linked from the user menu', function () {
    $user = profileUser();

    $this->actingAs($user)->get('/profile')
        ->assertOk()
        ->assertSee('Ana Silva')
        ->assertSee('@ana')
        ->assertSee($user->email)
        ->assertSee('Student');

    $this->get('/dashboard')->assertSee(route('profile.index'))->assertSee('Perfil');
});

test('personal information is updated', function () {
    $user = profileUser();

    $this->actingAs($user)
        ->put('/profile', ['name' => 'Maria', 'last_name' => 'Costa', 'email' => 'maria@example.com', 'nif' => '987654321'])
        ->assertRedirect('/profile');

    expect($user->fresh())->name->toBe('Maria')->last_name->toBe('Costa')->email->toBe('maria@example.com')->nif->toBe('987654321');
});

test('role and active cannot be changed from the profile', function () {
    $user = profileUser();

    $this->actingAs($user)->put('/profile', ['name' => 'Ana', 'profile' => 'admin', 'active' => false]);

    expect($user->fresh())->profile->toBe('student')->active->toBeTruthy();
});

test('email and nif must be unique but may stay the same', function () {
    $other = User::factory()->create(['email' => 'taken@example.com', 'nif' => '111111111']);
    $user = profileUser();
    $same = ['name' => 'Ana', 'last_name' => 'Silva', 'email' => $user->email, 'nif' => $user->nif];

    $this->actingAs($user)->put('/profile', $same)->assertSessionHasNoErrors();

    $this->from('/profile')->put('/profile', ['email' => $other->email, 'nif' => $other->nif] + $same)
        ->assertRedirect('/profile')
        ->assertSessionHasErrors(['email', 'nif']);
});

test('profile picture is stored and replaced', function () {
    Storage::fake('public');
    $user = profileUser();

    $this->actingAs($user)->put('/profile', ['image' => UploadedFile::fake()->image('a.jpg')])->assertRedirect('/profile');
    $old = $user->fresh()->image;
    Storage::disk('public')->assertExists($old);

    $this->put('/profile', ['image' => UploadedFile::fake()->image('b.jpg')]);
    Storage::disk('public')->assertMissing($old);
    Storage::disk('public')->assertExists($user->fresh()->image);

    $this->get('/profile')->assertOk()->assertSee($user->fresh()->image_url, false);

    $this->from('/profile')->put('/profile', ['image' => UploadedFile::fake()->create('a.pdf', 10)])->assertSessionHasErrors('image');
});

test('password is changed only with the current password', function () {
    $user = profileUser(['password' => 'old-password']);

    $this->actingAs($user)->from('/profile')
        ->put('/profile/password', ['current_password' => 'wrong', 'password' => 'new-password', 'password_confirmation' => 'new-password'])
        ->assertSessionHasErrors('current_password');
    expect(Hash::check('old-password', $user->fresh()->password))->toBeTrue();

    $this->put('/profile/password', ['current_password' => 'old-password', 'password' => 'new-password', 'password_confirmation' => 'other'])
        ->assertSessionHasErrors('password');

    $this->put('/profile/password', ['current_password' => 'old-password', 'password' => 'new-password', 'password_confirmation' => 'new-password'])
        ->assertRedirect('/profile')
        ->assertSessionHasNoErrors();
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});
