<?php
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-18 at 13:26:11.
 */
App::uses('Count', 'Model');
class CountTest extends PHPUnit_Framework_TestCase
{
    protected $count;

    protected function setUp()
    {
        $this->count = new Count;
    }

    protected function tearDown()
    {
    }

    /**
     * @covers Count::ball
     * @todo   Implement testBall().
     */
    public function testBall()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Count::strike
     * @todo   Implement testStrike().
     */
    public function testStrike()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testOut()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    public function testGetBall()
    {
        $this->count->ball();
        $this->count->ball();

        $this->assertEquals(2, $this->count->getBall());
    }

    public function testGetStrike()
    {
        $this->count->strike();
        $this->count->strike();

        $this->assertEquals(2, $this->count->getStrike());
    }

    public function testGetOut()
    {
        $this->count->out();
        $this->count->out();

        $this->assertEquals(2, $this->count->getOut());
    }

    public function testGetCount()
    {
        $this->count->resetCount();
        $this->count->ball();
        $this->count->strike();
        $this->count->ball();
        $this->count->out();

        $this->assertEquals(array(2,1,1), $this->count->getCount());
    }

    public function testResetBSCount()
    {
        $this->count->strike();
        $this->count->ball();
        $this->count->out();
        $this->count->resetBSCount();
        $this->count->ball();
        $this->count->strike();
        $this->count->out();

        $this->assertEquals(array(1,1,2), $this->count->getCount());
    }

    public function testResetCount()
    {
        $this->count->strike();
        $this->count->ball();
        $this->count->out();
        $this->count->resetCount();
        $this->count->ball();
        $this->count->strike();
        $this->count->out();

        $this->assertEquals(array(1,1,1), $this->count->getCount());
    }
}