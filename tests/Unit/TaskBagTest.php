<?php namespace Mistletoe\Test\Unit;

/* The Getter and Setter methods are all tested in `TaskPlannerTest`. No need to duplicate */
use Cron\CronExpression;
use Mistletoe\TaskBag;
use Mistletoe\Test\Mocks\MockExpressionBuilder;
use PHPUnit_Framework_TestCase;

class TaskBagTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function TestConstructNewBagWithName()
    {
        $task = new TaskBag('Task');
        $this->assertEquals('Task', $task->getTask(), 'failed to set task name');
    }

    /* Appending Values */
    /** @test */
    public function TestAddMonth()
    {
        $task = new TaskBag('Task');
        $task->addMonth(1)->addMonth(2)->addMonth(3);

        $this->assertEquals('1,2,3', $task->getMonth(), 'failed to append months');
    }

    /** @test */
    public function TestAddDay()
    {
        $task = new TaskBag('Task');
        $task->addDay(1)->addDay(2)->addDay(3);

        $this->assertEquals('1,2,3', $task->getDay(), 'failed to append day');
    }

    /** @test */
    public function TestAddHour()
    {
        $task = new TaskBag('Task');
        $task->addHour(1)->addHour(2)->addHour(3);

        $this->assertEquals('1,2,3', $task->getHour(), 'failed to append hours');
    }

    /** @test */
    public function TestAddMintue()
    {
        $task = new TaskBag('Task');
        $task->addMinute(1)->addMinute(2)->addMinute(3);

        $this->assertEquals('1,2,3', $task->getMinute(), 'failed to append minutes');
    }

    /** @test */
    public function TestConstructNewBagWithParameters()
    {
        $task = new TaskBag([
            'task' => 'name',
            'environments' => ['env'],
            'followedBy' => ['one', 'two'],
            'interval' => 'int',
            'hour' => 'hour',
            'minute' => 'minute',
            'month' => 'month',
            'day' => 'day'
        ]);

        $this->assertEquals('name', $task->getTask(), 'failed to set task name');
        $this->assertEquals(['env'], $task->getEnvironments(), 'failed to set environments');
        $this->assertEquals(['one', 'two'], $task->getFollowedBy(), 'failed to set followed by');
        $this->assertEquals('int', $task->getInterval(), 'failed to set interval');
        $this->assertEquals('hour', $task->getHour(), 'failed to set hour');
        $this->assertEquals('minute', $task->getMinute(), 'failed to set minute');
        $this->assertEquals('month', $task->getMonth(), 'failed to set month');
        $this->assertEquals('day', $task->getDay(), 'failed to set day');
    }

    /** @test */
    public function TestSetCronExpression()
    {
        // From a string expression
        $task = new TaskBag('Task');
        $task->setCronExpression('1 1 1 1 1');
        $this->assertEquals(CronExpression::factory('1 1 1 1 1'), $task->getCronExpression(), 'failed to set cron expression from string');

        // From a CronExpression instance
        $task = new TaskBag('Task');
        $expression = CronExpression::factory('1 2 3 4 5');
        $task->setCronExpression($expression);
        $this->assertEquals(CronExpression::factory('1 2 3 4 5'), $task->getCronExpression(), 'failed to set cron expression from instance');

    }

    /** @test */
    // This builds a CronExpression object from a full bag. The ExpressionBuilder is mocked
    public function TestGetCronExpression()
    {
        // Just make sure it passes the bag through expression builder
        $task = new TaskBag('Task');
        $task->setExpressionBuilder(new MockExpressionBuilder('1 * * * *')); // for testing

        $this->assertEquals(CronExpression::factory('1 * * * *'), $task->getCronExpression(), 'failed to build an expression with the builder');
    }

    // Passed to CronExpression, not tested here: isDue(), getNextRunDate(), getPreviousRunDate()
}

