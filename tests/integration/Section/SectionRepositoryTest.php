<?php


use App\Models\Presentation\DefaultSections;
use App\Models\Section\SectionsRepository;

class SectionRepositoryTest extends \Codeception\TestCase\Test
{
    public $repo;
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected function _before()
    {
        $this->repo = $this->tester->grabService(SectionsRepository::class);
    }


    /** @test */
    public function it_should_copy_default_sections()
    {
        factory(DefaultSections::class,4)->create();
        $this->repo->copyDefaults();
        $sections =  $this->repo->getAll();

        $firstDefSection = DefaultSections::find(1);
        $lastDefSection = DefaultSections::find(4);

        $firstSection = $sections->first();
        $lastSection = $sections->last();

        $this->assertEquals($firstDefSection->name,$firstSection->name);
        $this->assertEquals($lastDefSection->name,$lastSection->name);





    }
}