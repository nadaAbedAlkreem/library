<!DOCTYPE html>

<html lang="en">

<head> 
		<title>email reset password </title>
		<meta charset="utf-8" />
		<meta name="description" content="reset your  password "/>
	</head>
     <body>
	   <h1>{{ $data['title'] }}</h1>
       <p> {{ $data['body'] }} </p>
	   <?php   ?>
	   <a href="{{route('newPassword' , ['token' => $data['token']])}}"  class="btn btn-lg btn-light-primary fw-bolder">reset my password </a>

    </body>
 
</html>
