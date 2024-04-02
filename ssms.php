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
                    <h1 class="page-header">Send SMS</h1>
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
$smss = $pdo->query("SELECT sms FROM general_setting");
$smss = $smss->fetch(PDO::FETCH_ASSOC);
$sms = $smss['sms'];
$phone = $_POST["phone"];

$message = urlencode($message);
$url1=str_replace("[TO]",$phone,$sms);
$url=str_replace("[MESSAGE]",$message,$url1);
$ch = curl_init();
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt( $ch, CURLOPT_URL, $url ); 
$content = curl_exec( $ch );
$response = curl_getinfo( $ch );
curl_close ( $ch );
$date = date('Y-m-d');
$message = $_POST["message"]; 
$res = $pdo->exec("INSERT INTO `sms`(`customer`, `message`, `date`) VALUES ('$customer','$message','$date')");

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
				
				
				
				
				
				    <form action="ssms.php" method="post">
		
                    <div class="form-group">
					
					<label>Name of Recipient</label>
					
					<input name="customer" id='customer' class="form-control"><br/>

					</div>
					
					<div class="form-group">
					
					<label>Phone Number</label>
					
					<input name="phone" value='+2347XXXXXXXXX' class="form-control"><br/>

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