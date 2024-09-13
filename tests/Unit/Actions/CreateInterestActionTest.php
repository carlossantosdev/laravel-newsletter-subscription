<?php

namespace Tests\Unit\Actions;

use App\Actions\CreateInterestAction;
use App\Models\Interest;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateInterestActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldCreateInterestWithAllData(): void
    {
        $data = ['name' => fake()->firstName()];

        $action = new CreateInterestAction($data);
        $this->assertInstanceOf(Interest::class, $action->execute());
        $this->assertDatabaseHas('interests', $data);
    }

    /**
     * @test
     */
    public function shouldThrownUniqueConstrainViolationExceptionWhenNameAlreadyExists(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(UniqueConstraintViolationException::class);

        $data = ['name' => fake()->firstName()];

        $action = new CreateInterestAction($data);
        $action->execute();
        $action->execute();
    }
}
