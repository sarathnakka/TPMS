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
                    <h1 class="page-header">Send EMAIL</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
				
				
	

		<?php

if($_POST)
{

$customer = $_POST["customer"];
$message = $_POST["message"];
$emails = $pdo->query("SELECT email FROM general_setting");
$emails = $emails->fetch(PDO::FETCH_ASSOC);
$email = $emails['email'];
$result = $pdo->query("SELECT email FROM customer WHERE fullname='$customer'");
$result = $result->fetch(PDO::FETCH_ASSOC);
$toemail = $result['email'];

$message = wordwrap($message,70);

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: $email" . "\r\n" .
"Reply-To: $email" . "\r\n" .
"X-Mailer: PHP/" . phpversion();
mail($toemail,$dd['sitename'],$message,$headers);
$date = date('Y-m-d'); 
$res = $pdo->exec("INSERT INTO `email`(`customer`, `message`, `date`) VALUES ('$customer','$message','$date')");

if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Message Sent Successfully!

</div>";


} else {
	
	
	
}



} 
	?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
				
				
				
				
				    <form action="email.php" method="post">
		
                    <div class="form-group">
					
					<label>Select Customer</label>
					
					<select name="customer" id='customer' class="form-control">
					<option value="0">Please Select a Customer</option>
					<?php

$ddaa = $pdo->query("SELECT id, fullname FROM customer ORDER BY id");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		if(isset($_GET['id']) && $data['id'] == $_GET["id"])
		{
			echo "<option value='$data[fullname]' selected='selected'>$data[fullname]</option>";
		}
		else
		{
 			echo "<option value='$data[fullname]'>$data[fullname]</option>";
		}
	}
?>
					
					</select><br/>

</div>


<div class="form-group">
					
					<label>Select a Template</label>
					
					<select name="template" id ='template' class="form-control">
					<option value="0">Please Select a Template</option>
					<?php

$ddaa = $pdo->query("SELECT id, title, msg FROM template ORDER BY id");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		echo "<option value='$data[msg]'>$data[title]</option>";
	}
?>
					
					</select><br/>

</div>
                
                <div class="form-group">
					
					<label>Message</label><br/>
                 	<textarea rows="4" cols="50" name="message" id='message' class="form-control" type="text"></textarea><br/><br/>
				</div>  
					<input type="submit" class="btn btn-lg btn-success btn-block" value="SEND">
			    	</form>
                </div>
				
				
				<script>
						document.getElementById("template").onchange = function () {

						document.getElementById("message").value = 'Dear ' + document.getElementById("customer").value + ','+ '\n' + this.value;
				
					};
				</script>
						
						
						
						
						
						
						
				
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