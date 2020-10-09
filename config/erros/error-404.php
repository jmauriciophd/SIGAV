<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
body {color: #fff; margin: 0;background: url(/sigav/config/erros/img/texture.png) repeat;}
.container {width: 960px;margin:50px auto; text-align: center; font: 13px/22px "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;color: #000;}

.box {
	background: url(/sigav/config/erros/img/404.png) no-repeat 0 0;
	border-bottom: 5px solid #000;
	height: 343px;
	margin-bottom: 25px;
 	padding-bottom: 50px;
}

.cover_pan{
	background: #fff url(/sigav/config/erros/img/covers.jpg) repeat 1055px bottom;
	height: 343px;
	margin-left:1px; 
	overflow: hidden;
	position: relative;
	width:99.5%;
	z-index: -1;
	
	-moz-animation-name: pan;
	-moz-animation-duration:40s;
	-moz-animation-iteration-count: infinite;
	-moz-animation-timing-function: linear;
	
	-webkit-animation-name: pan;
	-webkit-animation-duration:40s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: linear;
}

@-moz-keyframes pan {
	0% {
		background-position: 1338px bottom;
	}
	100% {
		background-position: left bottom;
	}
}

@-webkit-keyframes pan {
	0% {
		background-position: 1338px bottom;
	}
	100% {
		background-position: left bottom;
	}
}
</style>
<title>Erro 404</title>
</head>
<body>

<div class="container">
<h3 style="color:red;">Erro 404! A página (<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>) solicitada não foi encontrada.</h3>
	<div class="box">
			<div class="cover_pan"></div>
	</div>
</div>

</body>
</html>
