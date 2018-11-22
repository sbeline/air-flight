<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class FlightController extends Controller
{

	/**
     * Search flight
     *
	 * @param Illuminate\Http\Request $request
     * @return  Illuminate\Http\Response
     */
    public  function searchFlight(Request $request)
    {
		$client = new Client();

		$res = $client->request('GET', 'https://aviation-edge.com/v2/public/autocomplete', [
					'query' => [
						'key' => '1a1b9d-7e7e05',
						'city' => Input::get('departure'),
					]
				]);



	   $data = json_decode($res->getBody() , true);
	   var_dump($data);

	   // {"type":"User"...'

	/*	if ($request->isMethod('post'))
		{
			$input = Input::all();
			var_dump ($input);
		}*/
    }

	/**
	* Autocompletion
	*
	* @param Illuminate\Http\Request $request
	* @return  Illuminate\Http\Response
	*/
	public function autocompletion(Request $request)
	{
		if ( $request->get('query') ) {
			$query = $request->get('query');
			$name = $request->get('name');

			$client = new Client();

			$res = $client->request('GET', 'https://aviation-edge.com/v2/public/autocomplete', [
						'query' => [
							'key' => '1a1b9d-7e7e05',
							'city' => $query,
						]
			]);
 			$data = json_decode($res->getBody() , true);
			$output = '<ul class="dropdown-menu"
				style="display:block;
				position:relative"';

			// limit call result can't limit with api provide
			$limit_query = 0;
			foreach ($data['cities'] as $value) {
				$output .= '<li ><a href="#" class="'.$name.'">'.'('.$value['codeIataCity'].')'.$value['nameCity'].'</a></li>';
				if ($limit_query++ == 4) break;
			}
			$output .= '</ul>';
			echo $output;
		}
	}
}
