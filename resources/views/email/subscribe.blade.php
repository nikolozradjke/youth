<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>subscribe</title>
	<style type="text/css">
		*{
			box-sizing: border-box;
			margin: 0;
			padding: 0;
			text-decoration: none;
		}
		body{
			max-width: 1920px;
			margin:auto;
			background: rgba(244, 244, 244, 1.0);
		}
	  tr, tbody{
			width: 100%;
			border-collapse: collapse;
		}
    table{
			border-collapse: separate;
  		border-spacing: 10px;
      margin: auto;
		}
		.card{
      display: inline-block;
      max-width: 342px;
			min-width: 300px;
			border-radius: 18px;
			overflow: hidden;
			box-shadow: 0px 2px 16px rgba(170, 170, 170, 0.12);
			background: #FDFDFD;
			margin-bottom: 24px;
			margin-left: 5px;
			margin-right: 5px;
		}
		.card img{
			width: 100%;
			height: 113px;
			object-fit: cover;
		}
		.card .bottom{
			padding: 23px 22px ;
		}
		.card  h4{
			font-family: 'FiraGO', sans-serif;
			font-style: normal;
			font-weight: 400;
			font-size: 14px;
			line-height: 17px;
			font-feature-settings: 'case' on;
			color: #000000;
		}
		.unsubscribe{
			background: #FEC210;
			box-shadow: 0px 4px 7px rgba(197, 197, 197, 0.15);
			border-radius: 38px;
			display:block;
			margin:40px auto ;
			padding: 18px;
			max-width: 342px;
			width: 100%;
			font-family: 'FiraGO', sans-serif;
			font-style: normal;
			font-weight: 400;
			font-size: 13px;
			line-height: 16px;
			text-align: center;
			font-feature-settings: 'case' on;
			color: rgba(0, 0, 0, 0.9) !important;
		}
	    @media(max-width:1024px){
	      .card{
	        width: 100%;
	        max-width: unset;
	        min-width: unset;
	      }
	    }
	</style>
</head>
<body >

	<table  >
		<tbody>
			<tr class="cards-grid">
                @foreach($oportunities as $opportunity)
				<td  class="card">
					<a href="{{ route('opportunity', ['id' => $opportunity->id]) }}" target="_blank">
						<img src="{{ asset('/storage/' . $opportunity->getImagePath()) }}">

						<h4 class="bottom">{{ $opportunity->name }} </h4>
					</a>
				</td>
                @endforeach
			</tr>
		</tbody>
	</table>

	<a href="{{ route('unsubscribe', $token) }}"  class="unsubscribe" >
			გამოწერის გაუქმება
	</a>
</body>
</html>
