<?php 

namespace App\Transformers;

class TrainingTransformer extends Transformer {

	public function transform($item)
	{
		return [
			'id' => $item->id,
			'name' => $item->name,
			'club_id' => $item->club_id,
			'description' => stripslashes($item->description),
		];
	}
	
}