<?php namespace GSVnet\Users\ValueObjects;
      use Carbon\Carbon;

class MembershipPeriod {
    private Carbon|null $inaugurationDate;
    private Carbon|null $resignationDate;

    public function __construct(
        string|null $inaugurationDate, 
        string|null $resignationDate
    ) {
        if (is_string($inaugurationDate))
            $inaugurationDate = Carbon::parse($inaugurationDate);
        if (is_string($resignationDate))
            $resignationDate = Carbon::parse($resignationDate);

        $this->inaugurationDate = $inaugurationDate;
        $this->resignationDate = $resignationDate;
    }

    public function getInaugurationDate(): Carbon|null
    {
        return $this->inaugurationDate;
    }

    public function getresignationDate(): Carbon|null
    {
        return $this->resignationDate;
    }
}