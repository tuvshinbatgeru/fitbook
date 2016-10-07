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

	public function search($value)
	{
		dd($this->builder);
		return $this->builder->orWhere('plan.name', 'LIKE', '%' . $value .'%');
	}

	public function max()
	{
		return $this->builder;	
	}
}