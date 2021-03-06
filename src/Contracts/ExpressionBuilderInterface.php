<?php
namespace Mistletoe\Contracts;
use Cron\CronExpression;
use Mistletoe\TaskBag;

/**
 * Class ExpressionBuilderInterface
 * @package Mistletoe
 */
interface ExpressionBuilderInterface
{
    /**
     * Builds an expression from the bag
     * @param TaskBag|null $bag
     * @return CronExpression
     */
    public function build(TaskBag $bag = null);

    /**
     * Builds an expression from the string
     * @param $string
     * @return CronExpression
     */
    public function buildFrom($string);

    /**
     * Sets TaskBag
     * @param TaskBag $bag
     * @return $this
     */
    public function setTaskBag(TaskBag $bag);

    /**
     * Returns TaskBag
     * @return TaskBag
     */
    public function getTaskBag();
}
