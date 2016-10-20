<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Carbon\Carbon;

class PlanFilters extends QueryFilter{

	public function date($order = 'desc')
	{	
		return $this->builder->orderBy('created_at', $order);
	}

	public function heart($order = 'desc')
	{
		return $this->builder->orderBy('hearts_actions_count', $order);
	}

	public function price($order = 'desc')
	{
		return $this->builder->orderBy('price', $order);
	}

	public function subscription($order = 'desc')
	{
		return $this->builder->orderBy('subscriptions_count', $order);	
	}

	public function freq($value)
	{
		$freq = 0;

		switch ($value) {
			case 'dayly':
				$freq = 1;
				break;
			case 'weekly':
				$freq = 2;
				break;
			case 'monthly': 
				$freq = 3;
			    break;
			case 'yearly':
				$freq = 4;
				break;
			default:
				break;
		}

		return $this->builder->where('frequency_type', $freq);
	}
}