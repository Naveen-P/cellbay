<?php
if(isset($_GET['module'])){
include("includes/functions.php");
include("admin/class.products.php");
include("includes/class.users.php");
$module=$_GET['module'];
switch($module){
case 'getPhoneBrand': $brand=$_POST['brand'];
											$where="ProductBrand='".$brand."'";
											$query=frameQuery("products","*",$where);
											$num=numRows(mysql_query($query));
											echo "<div class='row'>";
											if($num>1){
												$row=select("products","*",$where);
												for($i=0;$i<$num;$i++){
												echo "<div class='span-one-third'>
												<h2>".$row[$i]['ProductName']."</h2>
             						 <ul class='media-grid'>
										    <li>
									    <a href='subui.php?module=myphone&pid=".$row[$i]['ProductID']."' rel='facebox'>
										   <img class='thumbnail' src='".$uploads."/".$row[$i]['ProductImage']."' width='250' height='150' alt='".$row[$i]['ProductID']."'>
								    </a>
									    </li>
							    </ul>
    
				        </div>";
				        }
											}
											else if($num==1){
												$row=select("products","*",$where);
												echo "<div class='span-one-third'>
												<h2>".$row['ProductName']."</h2>
             						 <ul class='media-grid'>
										    <li>
									    <a href='subui.php?module=myphone&pid=".$row['ProductID']."' rel='facebox'>
										   <img class='thumbnail' alt='".$row['ProductID']."' src='".$uploads."/".$row['ProductImage']."' width='250' ' height='120' alt='".$row['ProductID']."'>
								    </a>
									    </li>
							    </ul>
    
				        </div>";
											}
											else{
											echo "<center><h1><br>There are no phones that are availbale for this brand</h1></center>";
											}
											echo "</div>";
											break;
 ?>



<?php
break;

case 'addtocart': $pid=$_POST['pid'];
									$uid=$_POST['uid'];
									$date=date("Y-m-d");
									$fields=array("ProductID","UserID","OrderDate");
									$values=array("$pid","$uid","$date");
									echo insert("orders",$fields,$values);
									break;
									
case 'viewcart': ?>
<div style='width: 500px;'>
	<div class="modal-header">
<h3>View Cart</h3>
</div>
<div class="modal-body" style='overflow: auto;'>
<?php
if(checkSession('loggedin')){
		$where="UserID=$_SESSION[uid] AND OrderStatus=0";
		$query=frameQuery("orders","*",$where);
		$num=mysql_num_rows(mysql_query($query));
		$row=select("orders","*",$where);
		echo "<table>";
		echo "<tr>
						<th>Order ID</th>
						<th>Product</th>
						<th>Action</th>
					</tr>";
		$pobj=new products();
		if($num>1){
			for($i=0;$i<$num;$i++){
				$pobj->view($row[$i]['ProductID']);
			echo "<tr id='row".$row[$i]['OrderID']."'>
							 <td>".$row[$i]['OrderID'].
							"<td>".$pobj->getBrand()." ".$pobj->getName().
							"<td><a href='#".$row[$i]['OrderID']."' title='Confirm Order' class='check'><img src='images/check.png' width='20' height='20'/></a>&nbsp;&nbsp<a title='Cancel Order' href='#".$row[$i]['OrderID']."' class='cross'><img src='images/cross.png' width='20' height='20'/></a>";
			}	
		}
		else if($num==1){
			$pobj->view($row['ProductID']);
			echo "<tr id='row".$row['OrderID']."'>
							 <td>".$row['OrderID'].
							"<td>".$pobj->getBrand()." ".$pobj->getName().
							"<td><a title='Confirm Order' class='check' href='#".$row['OrderID']."'><img src='images/check.png' width='20' height='20'/></a>&nbsp;&nbsp<a title='Cancel Order' class='cross' href='#".$row['OrderID']."'><img src='images/cross.png' width='20' height='20'/></a>"
							;
		}
		
		else{
			echo "<center><h3>Your Cart is empty</h3></center>";
		}
		echo "</table>";
	}
?>
</div>
</div>
<?php
break;

case 'settings': $uobj=new users(); 
								 $uobj->view($_SESSION['uid']);
?>
<div id='respMsg'></div>		
	<h4>Account Settings</h4>
	<table style='font-size: 14px;'>
		<tr>
			<td>User ID: 
			<td><?php echo $uobj->getUEmail(); ?>
			<td>
		</tr>
		<tr>
			<td>Old Password: 
			<td><input type='password' id='oldPassword'/>
			<td>
		</tr>
		<tr>
			<td>New Password: 
			<td><input type='password' id='newPassword'/>
			<td>
		</tr>
		<tr>
			<td><td>
			<td><button id='saveAccount' class='btn success'>Save Settings</button>
		</tr>
			</table>


<?php
break;

case 'profile': $uobj=new users();
								$uobj->view($_SESSION['uid']);
?>
<h3>My Profile</h3>
<div id='msg'></div>
<table>
<tr>
	<td><b>My Name: </b>
	<td><?php echo $uobj->getUName(); ?>
	<td>
	<td>
	<td>
	<td>
	<td>
</tr>
<tr>
	<td><b>My Email: </b>
	<td><input type='text' value="<?php echo $uobj->getUEmail(); ?>" id='myEmail'/>
	<td>
	<td>
	<td>
	<td>
	<td>
</tr>
<tr>
	<td><b>Gender: </b>
	<td>
		<select id='myGender' style='background-color: #fff;'>
		<?php
			$g=$uobj->getUGender();
			if($g=='Male'){
				echo "<option value='$g' selected='selected'>$g</option>";
				echo "<option value='Female'>Female</option>";
			}
			else if($g=='Female'){
				echo "<option value='$g' selected='selected'>$g</option>";
				echo "<option value='Male'>Male</option>";
			}
			else{
				echo "<option value='' selected='selected'>-Select-</option>";
				echo "<option value='Male'>Male</option>";
				echo "<option value=''>Female</option>";
			}
		?>
		</select>
	</td>
	<td>
	<td>
	<td>
	<td>
	<td>
</tr>
<tr>
	<td><b>My Date of Birth: </b>
	<?php
		$dob=$uobj->getUDOB();
		if($dob=='0000-00-00'){
			echo "<td><input type='text' value='' placeholder='YYYY-MM-DD'/>";
		}else{
	?>
	<td><input type='text' value="<?php echo $uobj->getUDOB(); ?>" id='myDOB'/> <?php } ?>
	<td>
	<td>
	<td>
	<td>
	<td>
</tr>
<tr>
	<td><b>Member Since: </b>
	<td><?php echo $uobj->getUJDate(); ?>
	<td><input type='hidden' id='uid' value="<?php echo $_SESSION['uid']; ?>"/>
	<td>
	<td>
	<td>
	<td>
</tr>
<tr>
	<td>
	<td>
	<td>
	<td>
	<td>
	<td><button id='saveProfile' class='btn success'>Update</button>
</tr>
</table>
<?php
break;
}
}
?>
<div id="modal-from-dom2"  class="modal hide fade in" style="display: none;border: 8px solid #ccc;">

</div>
<script type="text/javascript">
$(document).ready(function(){
$("#saveProfile").click(function(){
	var email=$("#myEmail").val();
	var gender=$("#myGender").val();
	var dob=$("#myDOB").val();
	$.post("response.php?misc=updateProfile",{email: email, gender: gender,dob: dob},
	function(data){
		if(data==1){
			$("div#msg").html("<div class='alert-message success'>Changes to your profile have been updated</div>").hide().fadeIn(500);
		}
	});
	setTimeout(function(){
			$("div#msg").fadeOut(500);
		},3000);
});
$("#saveAccount").click(function(){
	var newPassword=$("#newPassword").val();
	var oldPassword=$("#oldPassword").val();
	if(newPassword==''|| oldPassword==''){
		if(oldPassword=='' && newPassword==''){
			$("#oldPassword").css("border","1px solid red");
			$("#newPassword").css("border","1px solid red");
		}
		else if(newPassword==''){
			$("#newPassword").css("border","1px solid red");
		}
		else if(oldPassword==''){
			$("#oldPassword").css("border","1px solid red");
		}
	}
	else{
		if(newPassword!=''){
			$("#newPassword").css("border","1px solid #ccc");
		}
	if(oldPassword!=''){
			$("#oldPassword").css("border","1px solid #ccc");
		}
	}
		if(newPassword!='' && oldPassword!=''){
			$.post("response.php?misc=changePassword",{newPassword: newPassword},
	function(data){
		if(data==1){
			$("div#respMsg").html("<div class='alert-message success'><p><strong>Your account settings have been updated!</strong></p></div>").hide().fadeIn(500);
		}
		else{
			$("div#respMsg").html("<div class='alert-message danger'><p><strong>Error. Please try again later!</strong></p></div>").hide().fadeIn(500);
		}
	});
	setTimeout(function(){
		$("#respMsg").fadeOut(500);
	},3000);
		}
});
$("#oldPassword").change(function(){
	var old=$("#oldPassword").val();
	$.post("response.php?misc=checkPwd",{oldPassword: old},
	function(data){
		if(data==1){
			$("#oldPassword").css("border","1px solid #ccc");
			$("#saveAccount").html("Save Settings").hide().show();
			$("#saveAccount").attr("disabled",false);
		}
		else{
			$("#oldPassword").css("border","1px solid red");
			$("#saveAccount").html("Invalid Password").hide().show();
			$("#saveAccount").attr("disabled",true);
		}
});
});

});
</script>
<script type="text/javascript">
$('a[rel*=facebox]').facebox() ;
$(".thumbnail").click(function(){
var pid=$(this).attr("alt");
});
$(".check").click(function(){
	var oid=$(this).attr("href");
	oid=oid.substring("1");
	$.post("response.php?misc=confirmOrder",{oid: oid},
	function(data){
		if(data==1){
			$("#row"+oid).fadeOut(500);
		}
	});
});
$(".cross").click(function(){
	var oid=$(this).attr("href");
	oid=oid.substring("1");
	$.post("response.php?misc=cancelOrder",{oid: oid},
	function(data){
		if(data==1){
			$("#row"+oid).fadeOut(500);
		}
	});
});
</script>
