<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Carbon\Carbon;

class SubscriptionFilters extends QueryFilter{

	public function active()
	{
		return $this->builder->where('begin_date', '<=', Carbon::today())
                  ->where('end_date', '>=', Carbon::today());
	}

	public function club($clubId)
	{
		return $this->builder->where('subscriptions.club_id', $clubId);
	}
}