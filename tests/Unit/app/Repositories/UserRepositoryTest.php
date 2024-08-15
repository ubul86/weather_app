<?php

namespace Tests\Unit;

use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\UserAuthenticationInterface;
use App\Repositories\Interfaces\UserRegistrationInterface;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRegistrationInterface $userRepository;
    protected UserAuthenticationInterface $authRepository;

    protected UserRegistrationInterface $userRegistrationRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
        $this->authRepository = new AuthRepository();
        $this->userRegistrationRepository = new UserRepository();
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ];

        $user = $this->userRegistrationRepository->register($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password123'
        ];

        JWTAuth::shouldReceive('attempt')->with($credentials)->andReturn('fake-jwt-token');
        $token = $this->authRepository->login($credentials);

        $this->assertEquals('fake-jwt-token', $token);
    }

    /** @test */
    public function it_fails_login_with_invalid_credentials()
    {
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword'
        ];

        JWTAuth::shouldReceive('attempt')->with($credentials)->andReturn(false);
        $response = $this->authRepository->login($credentials);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());

        $responseData = $response->getData(true);
        $this->assertEquals(['error' => 'invalid_credentials'], $responseData);
    }

    /** @test */
    public function it_can_get_authenticated_user()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        JWTAuth::shouldReceive('parseToken')->andReturnSelf();
        JWTAuth::shouldReceive('setToken')->with($token)->andReturnSelf();
        JWTAuth::shouldReceive('authenticate')->andReturn($user);

        $authenticatedUser = $this->userRepository->getUser();

        $this->assertInstanceOf(User::class, $authenticatedUser);
        $this->assertEquals($user->id, $authenticatedUser->id);
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $token = 'fake-jwt-token';

        JWTAuth::shouldReceive('setToken')->with($token)->andReturnSelf();
        JWTAuth::shouldReceive('invalidate')->andReturn(true);

        $result = $this->authRepository->logout($token);

        $this->assertTrue($result);
    }
}
