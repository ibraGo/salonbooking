<?php

class SLN_Helper_TimeInterval
{
    /** @var SLN_Time $from */
    private $from;
    /** @var SLN_Time $to */
    private $to;

    public function __construct(SLN_Time $from, SLN_Time $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function isOvernight()
    {
        return $this->to->isLte($this->from);
    }

    public function containsTime(SLN_Time $time)
    {
        return $this->from->isLte($time) && $this->to->isGte($time);
    }

    public function containsInterval(SLN_Helper_TimeInterval $time)
    {
        if($time->isOvernight() && !$this->isOvernight()) return $this->to->isLte($time->getFrom()) && $this->from->isGte($time->getTo());
        else return $this->from->isLte($time->getFrom()) && $this->to->isGte($time->getTo());
    }

    /**
     * @return SLN_Time
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return SLN_Time
     */
    public function getTo()
    {
        return $this->to;
    }
}