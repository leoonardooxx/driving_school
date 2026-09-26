<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('category image is stored and replaced', function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create(['username' => 'admin', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'admin']));
    $fields = ['name' => 'B', 'code' => 'B', 'description' => 'Ligeiros'];

    $this->post('/categories', $fields + ['image' => UploadedFile::fake()->image('a.jpg')])->assertRedirect('/categories');
    $category = Category::first();
    Storage::disk('public')->assertExists($category->image);
    $old = $category->image;

    $this->put("/categories/{$category->id}", $fields + ['image' => UploadedFile::fake()->image('b.jpg')]);
    Storage::disk('public')->assertMissing($old);
    Storage::disk('public')->assertExists($category->fresh()->image);

    $this->get('/categories')->assertOk()->assertSee(Storage::url($category->fresh()->image));
});

test('api category image is stored and replaced', function () {
    Storage::fake('public');
    $fields = ['name' => 'B', 'code' => 'B', 'description' => 'Ligeiros'];

    $this->post('/api/category', $fields + ['image' => UploadedFile::fake()->image('a.jpg')])->assertSuccessful();
    $category = Category::first();
    Storage::disk('public')->assertExists($category->image);
    $old = $category->image;

    $this->post("/api/category/{$category->id}", $fields + ['image' => UploadedFile::fake()->image('b.jpg')])->assertSuccessful();
    Storage::disk('public')->assertMissing($old);
    Storage::disk('public')->assertExists($category->fresh()->image);
});

test('api category is created inactive', function () {
    $this->postJson('/api/category', ['name' => 'B', 'code' => 'B', 'description' => 'Ligeiros', 'active' => true])
        ->assertSuccessful()
        ->assertJsonPath('active', false);
});

test('api category partial update returns the category', function () {
    $category = Category::create(['name' => 'B', 'code' => 'B', 'description' => 'Ligeiros']);

    $this->putJson("/api/category/{$category->id}", ['description' => 'Pesados'])
        ->assertOk()
        ->assertJsonPath('description', 'Pesados')
        ->assertJsonPath('name', 'B');

    $this->post("/api/category/{$category->id}", ['name' => 'C'], ['Accept' => 'application/json'])
        ->assertOk()
        ->assertJsonPath('name', 'C');
});
