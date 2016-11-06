<?php 

namespace App\Transformers;

use Carbon\Carbon;

class PlanTransformer extends Transformer {

	public function transform($item)
	{
		return [
			'id' => isset($item->id) ? $item->id : 0,
			'name' => $item->name,
			'club_id' => $item->club_id,
			'description' => stripslashes($item->description),
			'trainerless' => ((boolean) $item->trainerless) ? 'Y' : 'N',
			'trainer_count' =>  ((boolean) $item->trainerless) ? $item->trainerCount : 0,
			'isPrimary' => (boolean) $item->isPrimary,
			'price' => $item->price,
			'discount' => $item->discount,
			'is_active' => 'Y',
			'length' => $item->length,
			'frequency_type' => $item->freq,
			'top' => isset($item->top) ? $item->top : 0,
			'left' => isset($item->left) ? $item->left : 0,
			'start_date' => isset($item->startDate) ? Carbon::createFromFormat('d/m/Y', $item->startDate) : Carbon::now(),
			'finish_date' => isset($item->finish_date) ? Carbon::createFromFormat('d/m/Y', $item->finishDate) : Carbon::now(),
		];
	}
	
}