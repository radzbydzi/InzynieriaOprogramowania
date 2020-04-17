<?php
	require_once("config_scripts/db_connect.php");
	require_once("config_scripts/loginHelperFunctions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  </head>
  <body>
	<div class="jumbotron text-center" style="background-image: url('graphics/pizza_head.jpeg'); background-repeat: no-repeat; background-size: cover; background-position: center center; margin-bottom:0">
	<h1 style="color: white;">Pizzeria Studencka</h1>
	<p style="color: white;">Ulubiona Pizza w mieście</p>
	</div>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<ul class="navbar-nav" style="width: calc(100% - 120px)">
			
			<li class="nav-item active">
			<a class="nav-link" href="?page=index">O nas</a>
			</li>
			
			<li class="nav-item active">
			<a class="nav-link" href="?page=menu">Menu</a>
			</li>
			
			<li class="nav-item active">
			<a class="nav-link" href="?page=zamow">Zamów pizze</a>
			</li>
			
			<li class="nav-item active">
			<a class="nav-link" href="?page=promocje">Promocje</a>
			</li>
		</ul>
		
		<?php 
		if(getUserId()==null):
		?>
		<ul class="navbar-nav">
			<li class="nav-item active" >
			<a class="nav-link" href="?page=login" >Zaloguj</a>
			</li>
			<li class="nav-item active" >
			<a class="nav-link" href="?page=register" >Zarejestruj</a>
			</li>
		</ul>
		<?php
		else:
		?>
		<ul class="navbar-nav">
			<li class="nav-item active" >
			<a class="nav-link" href="?page=logout" >Wyloguj</a>
			</li>
			<li class="nav-item active" >
			<a class="nav-link" href="panel.php" >Panel użytkownika</a>
			</li>
		</ul>
		<?php
		endif;
		?>
	</nav>
	
	<div style="background-image: url('graphics/background.jpg'); background-size: cover; background-position: center center; margin-bottom:0; min-height: 300px;">
		<div class="container" style="width:70%; height:90%; background-color: white; float:center; margin-bottom:0; min-height: 300px;">
			<?php //script will generate interior of div depending on GET page
				if(!isset($_GET["page"]))
				{
					include("sites/index.php");
				}else
				{
					if(file_exists("sites/".htmlspecialchars($_GET["page"]).".php"))
					{
						include("sites/".htmlspecialchars($_GET["page"]).".php");
					}else
					{						
						include("site404.php");
					}
				}
			?>
		</div>
	
	
		
	</div>
	<div class="bg-dark" style="margin-bottom:0">
		<p style="color: white;">Pizzeria Studencka 2020
			<a href="#" data-toggle="popover" title="Autorzy: " data-content="Grabowski M., Obrębska I., Czarnecki R., Paczkowski M." style="float:right;">Autorzy</a>
		</p>
	</div>
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();
		});
</script>
  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  </body>
</html>