<?php
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
});
</script>
