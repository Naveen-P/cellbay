<?php
include("../includes/functions.php");
if(isset($_GET['ui'])){
$ui=$_GET['ui'];
switch($ui){
case 'addproduct': ?>
<div id="msg"></div>
<h3>Add Product</h3>
<form>
<table>
<tr>
<td><label>Product Brand: 
<td><input type="text" id="pBrand"/>
</tr>
<tr>
<td><label>Product Name: 
<td><input type="text" id="pName"/>
</tr>
<tr>
<td><label>Product Price: 
<td><input type="text" id="pPrice"/>
</tr>
<tr>
<td><label>Manufactured Year: 
<td><input type="text" id="pYear"/>
</tr>
<tr>
<td><label>Product Visibility: 
<td>
<select id="pVisible" style="background-color: #fff;">
<option value="1" selected="selected">Public</option>
<option value="0">Private</option>
</select>
</td>
</tr>
<tr>
<td>
<td>
</tr>
</table>
<div style="margin-top: -20px;">
<input style="margin-left: 40px;" id="newProduct" type="button" class="btn success" value="Submit"/>
<input style="margin-left: 10px;" class="btn danger" type=reset value="Reset"/>
</div>
</form>
<?php
break;

case 'viewproduct': $row=select("products","*");
										$count=count($row);
										if($count>1){
										echo "<div class='row'>";
										for($i=0;$i<$count;$i++){
										echo "<div class='span3'>";
										echo "<h5>".$row[$i]['ProductBrand']." ".$row[$i]['ProductName']."</h5><ul class='media-grid'><li><a class='productDetail' href='#".$row[$i]['ProductID']."'><img class='thumbnail' src='#' width='150' height='120' alt=''></a></li></ul>";
										echo "</div>";
										}
										echo "</div>";
										}
?>

<?php
break;
}
}
?>
<script type="text/javascript">
$(document).ready(function(){
$("#newProduct").click(function(){
var pName=$("#pName").val();
var pBrand=$("#pBrand").val();
var pPrice=$("#pPrice").val();
var pYear=$("#pYear").val();
var pVisible=$("#pVisible").val();
if(pName=='' || pBrand=='' || pPrice=='' || pYear=='' || pVisible==''){
$("#msg").hide();
$("#msg").html("<div class='alert-message danger'><p><strong>Fill all fields!</strong></p></div>").fadeIn(500);
}else{
$.post("response.php?module=addproduct",{pName: pName,pBrand: pBrand,pPrice: pPrice,pYear:pYear,pVisible:pVisible},
function(data){
$("div#msg").html("<div class='alert-message success'><p><strong>Product added successfully!</strong></p></div>").hide().fadeIn(500);
setTimeout(function(){
$("#msg").fadeOut(500);
},3000);
});
}
});
$(".productDetail").click(function(){
var id=$(this).attr("href");
id=id.substring(1);
alert(id);
});
});
</script>