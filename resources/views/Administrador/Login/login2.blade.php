<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		@import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
		@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

		body {
			margin: 0;
			padding: 0;
			background: #fff;

			color: #fff;
			font-family: Arial;
			font-size: 12px;
		}

		.body {
			position: absolute;
			top: -20px;
			left: -20px;
			right: -40px;
			bottom: -40px;
			width: auto;
			height: auto;
			background-image: url(https://scontent.fpvo2-1.fna.fbcdn.net/v/t39.30808-6/276295344_274079178226205_2971322136467781129_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=19026a&_nc_ohc=yJKvyxO6XNUAX8P6tCU&_nc_oc=AQlGSmPW2VwfTsgdNqi6niBKpuGI8-dfl_zQXkSiIrV-8AnHUUTV9MkJSPvJ8JgiP5g&_nc_ht=scontent.fpvo2-1.fna&oh=00_AT8fcxv7u_rVT7PXWy2iOGATL5YDctgQ83UD8wPNCbq5Dg&oe=635CD828);
			background-size: cover;
			-webkit-filter: blur(2px);
			z-index: 0;
		}

		.grad {
			position: absolute;
			top: -20px;
			left: -20px;
			right: -40px;
			bottom: -40px;
			width: auto;
			height: auto;
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(100%, rgba(0, 0, 0, 0.65)));
			/* Chrome,Safari4+ */
			z-index: 1;
			opacity: 0.7;
		}

		.header {
			position: absolute;
			top: calc(50% - 35px);
			left: calc(50% - 255px);
			z-index: 2;
		}

		.header div {
			float: left;
			color: #fff;
			font-family: 'Exo', sans-serif;
			font-size: 35px;
			font-weight: 200;
		}

		.header div span {
			color: #5379fa !important;
		}

		.login {
			position: absolute;
			top: calc(50% - 75px);
			left: calc(50% - 50px);
			height: 150px;
			width: 350px;
			padding: 10px;
			z-index: 2;
		}

		.login input[type=text] {
			width: 250px;
			height: 30px;
			background: transparent;
			border: 1px solid rgba(255, 255, 255, 0.6);
			border-radius: 2px;
			color: #fff;
			font-family: 'Exo', sans-serif;
			font-size: 16px;
			font-weight: 400;
			padding: 4px;
		}

		.login input[type=password] {
			width: 250px;
			height: 30px;
			background: transparent;
			border: 1px solid rgba(255, 255, 255, 0.6);
			border-radius: 2px;
			color: #fff;
			font-family: 'Exo', sans-serif;
			font-size: 16px;
			font-weight: 400;
			padding: 4px;
			margin-top: 10px;
		}

		.login input[type=button] {
			width: 260px;
			height: 35px;
			background: #fff;
			border: 1px solid #fff;
			cursor: pointer;
			border-radius: 2px;
			color: #a18d6c;
			font-family: 'Exo', sans-serif;
			font-size: 16px;
			font-weight: 400;
			padding: 6px;
			margin-top: 10px;
		}

		.login input[type=button]:hover {
			opacity: 0.8;
		}

		.login input[type=button]:active {
			opacity: 0.6;
		}

		.login input[type=text]:focus {
			outline: none;
			border: 1px solid rgba(255, 255, 255, 0.9);
		}

		.login input[type=password]:focus {
			outline: none;
			border: 1px solid rgba(255, 255, 255, 0.9);
		}

		.login input[type=button]:focus {
			outline: none;
		}

		::-webkit-input-placeholder {
			color: rgba(255, 255, 255, 0.6);
		}

		::-moz-input-placeholder {
			color: rgba(255, 255, 255, 0.6);
		}
	</style>
</head>

<body>
	<div class="body"></div>
	<div class="grad"></div>
	<div class="header">
		<div>SGI<span>Random</span></div>
	</div>
	<br>
	<div class="login">
		<input type="text" placeholder="username" name="user"><br>
		<input type="password" placeholder="password" name="pasHTsword"><br>
		<input type="button" value="Login">
	</div>
</body>

</html>