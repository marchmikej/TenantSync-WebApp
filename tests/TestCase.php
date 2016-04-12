<?php

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    use DatabaseTransactions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function it_logs_in_as($role)
    {
        Session::start();

        $user = factory(TenantSync\Models\User::class, $role)->create();

        $attempt = \Auth::attempt([
            'email' => $user->email,
            'password' => 'test'
        ]);

        $this->assertTrue($attempt);

        return $user;
    }
}
