<?php


use App\Models\User;
use App\Models\User\UserRepository;
use Laracasts\TestDummy\Factory as TestDummy;

class UserRepositoryTest extends \Codeception\TestCase\Test
{
    public $repo;
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected function _before()
    {
        $this->repo = $this->tester->grabService(UserRepository::class);
    }


    /**
     * @test
     */
    public function it_gets_all_users()
    {
        factory(User::class, 2)->create()->each(function ($u) {
            $u->attachRole(2);
        });
        $this->tester->checkUsersCount(2, $this);
    }

}