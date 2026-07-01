<?php

use App\Models\User;

it('redirects guest to login', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('allows authenticated user into dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get('/dashboard')->assertOk();
});

it('prevents inactive users from authenticating', function () {
    $user = User::factory()->create([
        'active' => false,
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});
