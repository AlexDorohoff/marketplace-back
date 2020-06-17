<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	public function applyOffsetAndLimit(Request $request, Builder $query)
	{
		if($request->has(['offset', 'limit'])) {
	        $validated = $this->validate($request, [
    	        'offset' => 'integer',
        	    'limit' => 'integer',
	        ]);

			if($validated['limit'] > 0) {
				return $query
				->offset($validated['offset'])
				->limit($validated['limit']);
			}
		}
		return $query;
	}
}
