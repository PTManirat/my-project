<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>  

<div class="w3-container">
	<style>
		.input-group{
			margin-top: 3px;
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
			font-family: "Roboto", sans-serif
		}
		/*div#back_result{
			display: none;
			background-color: #fff;
			width: 40%;
		}*/
	</style>
		<nav>
			<ul class="w3-navbar w3-card-4" style="background-color: /*#105170*/#6699AA;">
				<center><li style="width: 10%;"><a href="homepage.php" class="w3-text-white w3-hover-text-black w3-large">
						<i class="fa fa-home"></i> Home</a></li></center>
				<center><li style="width: 70%;">
							<div class="input-group" style="width: 40%;">
								<input type="text" id="searchUser" class="form-control" name="searchUser" 
								maxlength="10" placeholder="Search for Username...">
								<span class="input-group-addon" id="search1" onclick="sendParam()" onmouseover="this.style.cursor='pointer';">
								<i class="glyphicon glyphicon-search"></i></span>
							</div>
							<!--<div id="back_result"></div>-->
						</li></center>
				<center><li style="width: 20%;">
						<a href="#" class="w3-text-white w3-hover-text-black w3-large" onclick="openRightMenu()"><?php echo $_SESSION['user'];?></a></li></center>
			</ul>
		</nav>
	
	
	<nav id="rightMenu" class="w3-sidenav w3-white w3-card-2 w3-center w3-top w3-animate-right w3-large" 
		style="display:none; right:0; width:250px; font-weight: bold; z-index:3;">
		<div>
			<a href="javascript:void(0)" onclick="closeRightMenu()" class="w3-closenav w3-hover-text-red w3-xlarge" 
				style="float: right; margin-right: 10px; margin-top: 5px; padding-right: 18px;">&times;</a>
		</div>
		<div class="w3-padding-64">
			<a href="profilesetting.php" class="w3-padding">Profile Settings</a>
			<a href="sendFriendRequest.php" class="w3-padding">Add Friend</a>
			<a href="friends.php" class="w3-padding">Friends</a>
			<a href="friendRequest.php">Friend Requests</a>
			<a href="logout.php" class="w3-padding">Log Out</a>
		</div>
	</nav>
	
	<div id="myOverlay" class="w3-overlay w3-animate-opacity" 
		onclick="closeRightMenu()" title="close side menu">
	</div>	


	

	<!--<div class="imgAll w3-row"> 76C6DE
			<div class="w3-quarter">
				<img class="imgSmall" src="pic/Kannaja/IMG_0593.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0598.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0602.jpg" onclick="onClikPic(this)">
			</div>

			<div class="w3-quarter">
				<img class="imgSmall" src="pic/Kannaja/IMG_0635.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0851.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0858.jpg" onclick="onClikPic(this)">
			</div>

			<div class="w3-quarter">
				<img class="imgSmall" src="pic/Kannaja/IMG_0865.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0926.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_0931.jpg" onclick="onClikPic(this)">
			</div>

			<div class="w3-quarter">
				<img class="imgSmall" src="pic/Kannaja/IMG_0957.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_1112.jpg" onclick="onClikPic(this)">
				<img class="imgSmall" src="pic/Kannaja/IMG_1121.jpg" onclick="onClikPic(this)">
			</div>
		</div>

		<div id="modalPic" class="w3-modal w3-black w3-padding-0" onclick="this.style.display = 'none'">
			<span class="w3-closebtn w3-text-white w3-opacity w3-hover-opacity-off w3-xxlarge w3-container w3-display-topright">x</span>
			<div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
				<img id="img1" class="w3-image">
			</div>
		</div>
		

		<div class="w3-container">
			<center><button type="button" id="UploadPhoto" class="w3-btn w3-light-grey w3-round" style="margin-right: 100px;"><b>Upload Photo</b></button>
			<button type="button" id="sendBtn" class="w3-btn w3-light-grey w3-round" style="margin-left: 0px;"><b>send</b></button></center>
		</div>-->

<script>
	function openRightMenu(){
		document.getElementById("rightMenu").style.display = "block";
		document.getElementById("myOverlay").style.display = "block";
	}
	function closeRightMenu(){
		document.getElementById("rightMenu").style.display = "none";
		document.getElementById("myOverlay").style.display = "none";
	}
	function onClikPic(element){
		document.getElementById("img1").src = element.src;
		document.getElementById("modalPic").style.display = "block";
	}
	/*$(document).ready(function(){
		$("#searchUser").keyup(function(){
			var name = $("input:text").val();
			if (name != ''){
				$.post('get_users.php', { name:name }, function(data){
					$('div#back_result').css({'display':'block'});
					$('div#back_result').html(data);
				});
			}
		
		});
	});*/
	function sendParam(){
		var search_user = document.getElementById('searchUser').value;
		if(search_user.trim().length > 0){
			window.location.href = "searchUser.php?search_user=" + search_user;
		}
		else{
			window.alert("Please enter username.");
		}
	}
</script>

