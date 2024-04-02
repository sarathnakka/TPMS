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
                    <h1 class="page-header">Update Order</h1>
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

$customer = $_POST["customer"];
$desc = $_POST["desc"];
$date_received = $_POST["date_received"];
$completed = $_POST["completed"];
$date_collected = $_POST["date_collected"];
$amount = $_POST["amount"];
$paid = $_POST["paid"];
$received_by = $_POST["received_by"];

$name = $pdo->query("SELECT fullname FROM customer WHERE id='".$customer."'");
$name = $name->fetch(PDO::FETCH_ASSOC);
$name = $name['fullname'].": ". substr($desc,0,100);

	if($completed == 'No'){
		$color = '#a00000';
	}
	else{
		$color = '#00a014';
	}

///////////////////////-------------------->> Catid  ki 0??
$error = 0;

 if($customer==0)
      {
$err1=1;
}
 if(isset($err1))
 $error = $err1;;


if (!isset($error) || $error == 0){
	
$res = $pdo->exec("UPDATE `order` SET `customer`='".$customer."',`description`='".$desc."',`received_by`='".$received_by."',`amount`='".$amount."',`paid`='".$paid."',`date_received`='".$date_received."',`completed`='".$completed."',`date_collected`='".$date_collected."' WHERE id='".$eid."'");
$res2 = $pdo->exec("UPDATE `calendar` SET `title`='".$name."', `description`='".$desc."', `start`='".$date_received."', `end`='".$date_collected."', `allDay`='true', `color`='".$color."', `url`='../orderedit.php?id=$eid', `category`='Orders', `user_id`='".$uid."' WHERE `order`='".$eid."'");

	if($res){
		echo "<div class='alert alert-success alert-dismissable'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	
	
	UPDATED Successfully!
	
	</div>";
	}else{
		echo "<div class='alert alert-danger alert-dismissable'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	
	
	Some Problem Occurs, Please Try Again. 
	
	</div>";
	}
} 
}
?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
<?php
$oldd = $pdo->query("SELECT * FROM `order` WHERE id='".$eid."'");
$old = $oldd->fetch(PDO::FETCH_ASSOC)
?>								
				
				
				
				    <form action="orderedit.php?id=<?php echo $eid ?>" method="post">
		
                    <div class="form-group">
					
					<label>Select Customer</label>
					
					<select name="customer" class="form-control">
                    <?php

$ddaa = $pdo->query("SELECT id, fullname FROM `customer` ORDER BY id");
    while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
    {
		if($old['customer'] == $data['id'])
		{									
 			echo "<option value='$data[id]' selected='selected'>$data[fullname]</option>";
		}
		else
		{
			echo "<option value='$data[id]'>$data[fullname]</option>";
		}
	}
?>
					
					</select><br/>

</div>
                
                <div class="form-group">
					<label>Description</label><br/>
                 	<input type="text" name="desc" style="width:200px; height: 40px;" value="<?php echo($old['description']) ?>" /><br/><br/>
				</div>
                
                <div class="form-group">
					
					<label>Received By</label>
					
					<select name="received_by" class="form-control">
					<?php
					$ddaa = $pdo->query("SELECT id, fullname FROM staff ORDER BY id");
						
						while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
						{
							if($old['received_by'] == $data['id'])
							{									
								echo "<option value='$data[id]' selected='selected'>$data[fullname]</option>";
							}
							else
							{
								echo "<option value='$data[id]'>$data[fullname]</option>";
							}
						}
					?>
					
					</select><br/>   
                
                <div class="form-group">
					
					<label>Amount</label><br/>
                 	<?php echo($currency);?> <input type="text" name="amount" style="width:200px; height: 40px;" value="<?php echo($old['amount']) ?>" /><br/><br/>
				</div>
                
                <div class="form-group">
					
					<label>Paid</label><br/>
                 	<?php echo($currency);?> <input type="text" name="paid" style="width:200px; height: 40px;" value="<?php echo($old['paid']) ?>" /><br/><br/>
				</div>
                
                <div class="form-group">
					
					<label>Date Received</label><br/>
                 	<input type="date" name="date_received" style="width:200px; height: 40px;" value="<?php echo($old['date_received']) ?>" /><br/><br/>
				</div>
                
                <div class="form-group">
					
					<label>Completed?</label><br/>
                 	<select name="completed" class="form-control">
						<option value='<?php echo($old['completed']) ?>'><?php echo($old['completed']) ?></option>
						<option value='No'>No</option>
						<option value='Yes'>Yes</option>
					
					</select>
					<br/><br/>
				</div>
                
                <div class="form-group">
					
					<label>Date to Collect</label><br/>
                 	<input type="date" name="date_collected" style="width:200px; height: 40px;" value="<?php echo($old['date_collected']) ?>" /><br/><br/>
				</div> 
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