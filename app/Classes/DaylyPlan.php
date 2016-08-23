<?php 

namespace App\Classes;

class DaylyPlan extends PlanType {

	public function calcEndDate($beginDate, $length)
	{
		return $beginDate;
	}
	
}