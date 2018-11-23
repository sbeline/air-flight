<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Flight;

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

        preg_match("/\(([^\]]*)\)/", Input::get('arrival'), $arrival);
        preg_match("/\(([^\]]*)\)/", Input::get('departure'), $departure);

        echo ($arrival[1]);
        echo ($departure[1]);

        $resarrival = $client->request('GET', 'https://aviation-edge.com/v2/public/autocomplete', [
                'query' => [
                    'key' => '1a1b9d-7e7e05',
                    'city' => $arrival[0],
            ]
        ]);

		$resdeparture = $client->request('GET', 'https://aviation-edge.com/v2/public/autocomplete', [
				'query' => [
					'key' => '1a1b9d-7e7e05',
					'city' => $departure[0],
			]
		]);

	   $arrival = json_decode($resarrival->getBody() , true);
       $departure = json_decode($resdeparture->getBody() , true);

       foreach ($arrival['cities'] as $value) {
           echo $value['codeIataCity'];
           if ($limit_query++ == 4) break;
       }
	   var_dump($departure);
       var_dump($arrival);

       return view('flight.flight_list');
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
				$output .= '<li class="'.$name.'" ><a href="#" class="'.$name.'">'.'('.$value['codeIataCity'].')'.$value['nameCity'].'</a></li>';
				if ($limit_query++ == 4) break;
			}
			$output .= '</ul>';
			echo $output;
		}
	}
}
