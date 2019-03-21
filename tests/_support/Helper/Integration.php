<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Integration extends \Codeception\Module
{
    /**
     * Checks if amoiunt of users equals given value
     * @param $count
     */
    public function checkUsersCount($count, $cept)
    {
        $params['sortBy'] = 'name';
        $params['direction'] = 'ASC';
        $params['perPage'] = 10;
        $cept->assertCount($count, $cept->repo->getAll($params));
    }


}
