<?php  
	if (isset($_SESSION["u_id"])) {
		header("location: index.php");
	}else{
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Wellis Igényfelmérés</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<meta name="theme-color" content="#563d7c">
	<link rel="stylesheet" type="text/css" href="admin/css/style.css">
	    
</head>
<body class="text-center">
    <form class="form-signin" action="php/mainLogin.php" method="POST">
	  <img class="mb-4" src="wellislogo.png" alt="" style="background-color: black"  height="72">
	  <h1 class="h3 mb-3 font-weight-normal">Kérlek jelentkezz be.</h1>
	  <label for="inputEmail" class="sr-only">Felhasználónév</label>
	  <input type="text" id="uname" name="uname" class="form-control" placeholder="Felhasználónév" required="" autofocus="">
	  <label for="inputPassword" class="sr-only">Jelszó</label>
	  <input type="password" id="pword" name="pword" class="form-control" placeholder="Jelszó" required="">
	  <button class="btn btn-lg btn-primary btn-block" type="submit" id="login">Bejelentkezés</button>
	  <p class="mt-5 mb-3 text-muted">© 2020-2021</p>
	</form>
	<style>
		.tb_button {
			padding:1px;
			cursor:pointer;
			border-right: 1px solid #8b8b8b;
			border-left: 1px solid #FFF;
			border-bottom: 1px solid #fff;
			}
		.tb_button.hover {
			borer:2px outset #def;
			 background-color: #f8f8f8 !important;
			 }
		.ws_toolbar {
			z-index:100000
			} 
		.ws_toolbar .ws_tb_btn {
			cursor:pointer;
			border:1px solid #555;
			padding:3px
			}   
		.tb_highlight{
			background-color:yellow
			} 
		.tb_hide {
			visibility:hidden
			} 
		.ws_toolbar img {
			padding:2px;
			margin:0px
		}
	</style>
</body>
</html>
<?php } ?>