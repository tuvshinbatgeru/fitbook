<?php 

namespace App\Transformers;

class PlanTransformer extends Transformer {

	public function transform($item)
	{
		return [
			'name' => $item->name,
			'club_id' => $item->club_id,
			'description' => $item->description,
			'trainerless' => ((boolean) $item->trainerless) ? 'Y' : 'N',
			'trainer_count' =>  ((boolean) $item->trainerless) ? $item->trainerCount : 0,
			'isPrimary' => (boolean) $item->isPrimary,
			'price' => $item->price,
			'discount' => $item->discount,
			'is_active' => 'Y',
			'length' => $item->length,
			'frequency_type' => $item->freq,
		];
	}
	
}