<?php 

namespace App\Transformers;

class TrainingTransformer extends Transformer {

	public function transform($item)
	{
		return [
			'name' => $item->name,
			'club_id' => $item->club_id,
			'description' => $item->description,
		];
	}
	
}