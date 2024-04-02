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
                    <h1 class="page-header">Add Customer</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
				
				
	

		<?php

if($_POST)
{

$fullname = $_POST["fullname"];
$address = $_POST["address"];
$phonenumber = $_POST["phonenumber"];
$sex = $_POST["sex"];
$email = $_POST["email"];
$city = $_POST["city"];
$comment = $_POST["comment"];

$res = $pdo->exec("INSERT INTO customer SET fullname='".$fullname."', address='".$address."', phonenumber='".$phonenumber."', sex='".$sex."',`email`='".$email."',`city`='".$city."',`comment`='".$comment."'");
$cid = $pdo->lastInsertId();
if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Customer Added Successfully!

</div>
<meta http-equiv='refresh' content='2; url=addmeasurement.php?id=$cid' /> 
";


}



} 
	?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
				
				
				
				
				    <form action="customeradd.php" method="post">
		
                    
                <div class="form-group">
					
					<label>Full Name</label><br/>
                 	<input type="text" name="fullname" style="width:200px; height: 40px;" /><br/><br/>
				</div>  
                
                <div class="form-group">
					
					<label>Address</label><br/>
                 	<input type="text" name="address" style="width:200px; height: 40px;" /><br/><br/>
				</div>    
                
                <div class="form-group">
					
					<label>Phone Number</label><br/>
                 	<input type="text" name="phonenumber" style="width:200px; height: 40px;" /><br/><br/>
				</div>
				
				<div class="form-group">
					
					<label>City</label><br/>
                 	<input type="text" name="city" style="width:200px; height: 40px;" /><br/><br/>
				</div>
				
				<div class="form-group">
					
					<label>Email</label><br/>
                 	<input type="text" name="email" style="width:200px; height: 40px;" /><br/><br/>
				</div>
                
				<div class="form-group">
				  <label class="col-sm-3 control-label">Comment</label><br/><br/>
				  <div class="col-sm-6"><textarea rows="4" cols="50" name="comment" class="form-control" type="text" /></textarea></div>
				</div>
                
                <div class="form-group">
					
					<label>Sex</label><br/>
					
					<select name="sex" class="form-control">
					<option value="0">Male</option>
                    <option value="1">Female</option></select><br/><br/>
				</div>
                
					<input type="submit" class="btn btn-lg btn-success btn-block" value="ADD">
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