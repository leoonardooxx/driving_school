<?php

use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user menu shows name and logs out', function () {
    $user = User::factory()->create(['username' => 'ana', 'name' => 'Ana', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'admin']);

    $this->actingAs($user)->get('/dashboard')->assertSee('Ana Silva')->assertSee('Terminar sessão');

    $this->post('/logout')->assertRedirect('/login');
    $this->assertGuest();
});
