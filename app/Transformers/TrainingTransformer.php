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
			'top' => isset($item->top) ? $item->top : 0,
			'left' => isset($item->left) ? $item->left : 0,
		];
	}
	
}