<?php

namespace Tests\Unit\Actions;

use App\Actions\CreateUserAction;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldCreateUserWithAllData(): void
    {
        $data = [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'is_admin' => 0,
            'password' => bcrypt('User@123'),
        ];

        $action = new CreateUserAction($data);
        $newUser = $action->execute();
        $this->assertInstanceOf(User::class, $newUser);
        $this->assertDatabaseHas('users', $data);
        $this->assertNotNull($newUser->token);
    }

    /**
     * @test
     */
    public function shouldCreateUserWithTheProvidedToken(): void
    {
        $data = [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'token' => Str::random(16),
            'is_admin' => 0,
            'password' => bcrypt('User@123'),
        ];

        $action = new CreateUserAction($data);
        $this->assertInstanceOf(User::class, $action->execute());
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @test
     */
    public function shouldThrownUniqueConstrainViolationExceptionWhenEmailAlreadyExists(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UniqueConstraintViolationException::class);

        $data = [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'token' => Str::random(16),
            'is_admin' => 0,
            'password' => bcrypt('User@123'),
        ];

        $action = new CreateUserAction($data);
        $action->execute();
        $action->execute();
    }
}
