<?php
require_once('function.php');
dbconnect();
session_start();

if (!is_user()) {
	redirect('index.php');
}

?>

		

<?php
 $user = $_SESSION['username'];
$usid = $pdo->query("SELECT id FROM users WHERE username='".$user."'");
$usid = $usid->fetch(PDO::FETCH_ASSOC);
 $uid = $usid['id'];
 include ('header.php');
 ?>



 
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Customer</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
				
				
	

		<?php
$eid = $_GET["id"];

if($_POST)
{

$address = $_POST["address"];
$fullname = $_POST["fullname"];
$phonenumber = $_POST["phonenumber"];
$sex = $_POST["sex"];
$email = $_POST["email"];
$city = $_POST["city"];
$comment = $_POST["comment"];

///////////////////////-------------------->> Catid  ki 0??
$error = 0;

 

$res = $pdo->exec("UPDATE `customer` SET `fullname`='".$fullname."',`phonenumber`='".$phonenumber."',`address`='".$address."',`sex`='".$sex."',`email`='".$email."',`city`='".$city."',`comment`='".$comment."' WHERE id='".$eid."'");

	if($res){
		echo "<div class='alert alert-success alert-dismissable'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	
	
	UPDATED Successfully!
	<meta http-equiv='refresh' content='2; url=customerview.php' />
	
	</div>";
	}else{
		echo "<div class='alert alert-danger alert-dismissable'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	
	
	Some Problem Occurs, Please Try Again. 
	
	</div>";
	}
 
}
?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
<?php
$oldd = $pdo->query("SELECT * FROM customer WHERE id='".$eid."'");
$old = $oldd->fetch(PDO::FETCH_ASSOC)
?>								
				
				
				
				    <form action="customeredit.php?id=<?php echo $eid ?>" method="post">
		
                    
                <div class="form-group">
					
					<label>Full Name</label><br/>
                 	<input type="text" name="fullname" style="width:200px; height: 40px;" value="<?php echo($old['fullname']) ?>" /><br/><br/>
				</div> 
                
                <div class="form-group">
					
					<label>Address</label><br/>
                 	<input type="text" name="address" style="width:200px; height: 40px;" value="<?php echo($old['address']) ?>" /><br/><br/>
				</div>  
                   
                
                <div class="form-group">
					
					<label>City</label><br/>
                 	<input type="text" name="city" style="width:200px; height: 40px;" value="<?php echo($old['city']) ?>" /><br/><br/>
				</div>
				
				<div class="form-group">
					
					<label>Phone Number</label><br/>
                 	<input type="text" name="phonenumber" style="width:200px; height: 40px;" value="<?php echo($old['phonenumber']) ?>" /><br/><br/>
				</div>
				
				<div class="form-group">
					
					<label>Email</label><br/>
                 	<input type="text" name="email" style="width:200px; height: 40px;" value="<?php echo($old['email']) ?>" /><br/><br/>
				</div>
                
				<div class="form-group">
				  <label class="col-sm-3 control-label">Comment</label><br/><br/>
				  <div class="col-sm-6"><textarea rows="4" cols="50" name="comment" class="form-control" type="text"><?php echo $old['comment']; ?></textarea></div>
				</div>
				
                <div class="form-group">
					
					<label>Sex</label>
					
					<select name="sex" class="form-control">
                        <option value="0" <?php if($old['sex']== 0) echo('selected = "selected"'); ?>>Male</option>
                        <option value="1"<?php if($old['sex']== 1) echo('selected = "selected"'); ?>>Female</option>
					</select><br/>
                
                
					<input type="submit" class="btn btn-lg btn-success btn-block" value="Update">
			    	</form>
                </div>
						
						
						
						
						
				
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
	    



<script src="js/bootstrap-timepicker.min.js"></script>


<script>
jQuery(document).ready(function(){
    
  
  jQuery("#ssn").mask("999-99-9999");
  
  // Time Picker
  jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

  
});
</script>







<?php
 include ('footer.php');
 ?>