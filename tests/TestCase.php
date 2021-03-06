<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

       // dd(env('APP_ENV'));
    }

    protected function signIn($user = null)
    {
        return $this->actingAs( $user ?: factory(User::class)->create());
    }
}
