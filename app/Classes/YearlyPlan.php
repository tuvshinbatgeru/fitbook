<?php 

namespace App\Classes;

class YearlyPlan extends PlanType {

	public function calcEndDate($beginDate, $length)
	{
		return $beginDate;
	}
	
}