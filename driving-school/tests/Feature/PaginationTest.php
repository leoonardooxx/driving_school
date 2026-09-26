<?php

use App\Models\Category;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('categories table is paginated', function () {
    $user = User::factory()->create(['username' => 'ana', 'name' => 'Ana', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'admin']);
    foreach (range(1, 12) as $i) {
        Category::create(['name' => "C$i", 'code' => "CODE$i", 'description' => 'D']);
    }

    $this->actingAs($user)->get('/categories')->assertSee('CODE10')->assertDontSee('CODE11')->assertSee('aria-label="Paginação"', false);
    $this->get('/categories?page=2')->assertSee('CODE11')->assertDontSee('CODE10');
    $this->get('/users')->assertOk();
});

test('per page comes from the per_page cookie', function () {
    $user = User::factory()->create(['username' => 'ana', 'name' => 'Ana', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'admin']);
    foreach (range(1, 5) as $i) {
        Category::create(['name' => "C$i", 'code' => "CODE$i", 'description' => 'D']);
    }

    $this->actingAs($user)->withUnencryptedCookie('per_page', '3')->get('/categories')->assertSee('CODE3')->assertDontSee('CODE4');
});
