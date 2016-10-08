<?php 

namespace App\Transformers;

use Carbon\Carbon;

class PlanTransformer extends Transformer {

	public function transform($item)
	{
		return [
			'id' => $item->id,
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
			'start_date' => $item->startDate,
			'finish_date' => $item->finishDate,
		];
	}
	
}