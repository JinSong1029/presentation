<?php

use App\Models\Slide;
use App\Models\User;
use Laracasts\TestDummy\Factory as TestDummy;

class FromLaracastsTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected function _before()
    {
//        $this->repo = new UserRepository;
    }


    /** @test */
    public function testMe()
    {
//        $users = TestDummy::times(2)->create(User::class);
//
//        TestDummy::times(2)->create(Slide::class, [
//            'user_id' => $users[0]->id
//        ]);
//        TestDummy::times(2)->create(Slide::class, [
//            'user_id' => $users[1]->id
//        ]);
    }
}