<?php

namespace App\Classes;

abstract class PlanType {
	public abstract function calcEndDate($beginDate, $length);
}