<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Address;

class CurrencyController extends Controller
{
	public function get_Currency() {
		
		$data['currency'] = 'INR';
		$data['currency_symbol'] = '₹';
		
		return $data;
	}
	
    

   
}
