<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Carbon\Carbon;

class PlanFilters extends QueryFilter{

	public function newest()
	{
		return $this->builder->orderBy('created_at', 'DESC');
	}

	public function oldest()
	{
		return $this->builder->orderBy('created_at');		
	}

	public function heart()
	{
		return $this->builder;
	}

	public function price()
	{
		return $this->builder->orderBy('price');
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