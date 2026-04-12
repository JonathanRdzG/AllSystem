<?php

use App\Models\User;

it('redirects guest to login', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('allows authenticated user into dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get('/dashboard')->assertOk();
});
