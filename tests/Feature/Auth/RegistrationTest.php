<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'photo' => 'photo',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
