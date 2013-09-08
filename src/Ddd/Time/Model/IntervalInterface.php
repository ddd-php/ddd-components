<?php

namespace Ddd\Time\Model;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface IntervalInterface
{
    public function getBegin();
    public function getEnd();
    public function isBefore(IntervalInterface $interval);
    public function isAfter(IntervalInterface $interval);
    public function isDuring(IntervalInterface $interval);
    public function isInclude(IntervalInterface $interval);
    public function isPartiallyBefore(IntervalInterface $interval);
    public function isPartiallyAfter(IntervalInterface $interval);
}
