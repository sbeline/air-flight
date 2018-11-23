<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>test-flight</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


		<script type="text/javascript" src="{{ URL::asset('js/autocompletion.js') }}"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="content">
                    <div class="title m-b-md">
                        Near's air-flight's
                    </div>
                    <p>Get the nearest, sonner flight</p>

					<form action="{{ route('flight.search') }}" method="post">
						{{ csrf_field() }}

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="get-departure">Departure</label>
								<input type="text" class="form-control input-lg get-country" name="departure" id="get-departure">
							</div>
							<div class="form-group col-md-6">
								<label for="get-arrival">Arrival</label>
								<input type="text"  class="form-control input-lg get-country" name="arrival" id="get-arrival">
								<div id="arrival"></div>
							</div>
						</div>
						<button type="submit" >Search</button>
            		</form>



            </div>
        </div>

    </body>

	<script>
	$(document).ready(function(){

		$(".get-country").keyup(function(){
			var query = $(this).val();
			var name = $(this).attr("name")
			if (query != '') {
				var _token = $(' input[name="_token"]').val();
				console.log($("#get-country").attr("name"));
				$.ajax({
					url: "{{ route('flight.autocompletion') }}",
					method:"POST",
					data:{query, _token:_token, name},
					success:function(data) {
						$('#countryList').fadeIn();
						$('div#'+name).html(data);
					}
				})
			}
		});
		$(document).on('click', 'li', function(){
			$("#get-"+$(this).attr("class")).val($(this).text());
			$('#'+$(this).attr("class")).fadeOut();
		});
	});

	</script>
</html>
