<?php

use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('dropdown button is active on its routes', function () {
    $user = User::factory()->create(['username' => 'ana', 'name' => 'Ana', 'last_name' => 'Silva', 'nif' => '123456789', 'profile' => 'admin']);

    foreach (['/categories'] as $url) {
        $html = $this->actingAs($user)->get($url)->getContent();
        preg_match('/<button[^>]*popovertarget="dropdown-[^"]*"[^>]*>/', $html, $m);
        expect($m[0] ?? '')->toContain('bg-black text-white');
        expect($html)->toMatch('#<div class="[^"]*bg-black! text-white! border-black!"[^>]*id="dropdown-#');
    }

    $html = $this->get('/dashboard')->getContent();
    preg_match('/<button[^>]*popovertarget="dropdown-[^"]*"[^>]*>/', $html, $m);
    expect($m[0])->not->toContain('bg-black text-white');
});
