<?php 

namespace App\Classes;

class MonthlyPlan extends PlanType {

	public function calcEndDate($beginDate, $length)
	{
		return $beginDate;
	}
	
}