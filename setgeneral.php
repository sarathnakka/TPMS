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




    <div class="pageheader">
      <h2><i class="fa fa-cog"></i> General Setting </h2>
    </div>

    <div class="contentpanel">

      <div class="row">
        <div class="col-md-12">
      <div class="panel panel-default">
        <!--div class="panel-heading">
          <div class="panel-btns">
            <a href="#" class="panel-close">×</a>
            <a href="#" class="minimize">−</a>
          </div>      
        </div-->
        <div style="display: block;" class="panel-body panel-body-nopadding">
          
          <form action="" method="post" class="form-horizontal form-bordered">
         
		<?php

if($_POST)
{

$sitename = $_POST["sitename"];
$mobile = $_POST["mobile"];
$email = $_POST["email"];
$currency = $_POST["currency"];
$sms = $_POST["sms"];

$res = $pdo->exec("UPDATE general_setting SET sitename='".$sitename."', mobile='".$mobile."', sms='".$sms."', email='".$email."', currency='".$currency."' WHERE id='1'");
if($res){
	echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Updated Successfully!

</div>";
}else{
	echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}

}



$data = $pdo->query("SELECT sitename, mobile, email, currency, sms FROM general_setting WHERE id='1'");
$data = $data->fetch(PDO::FETCH_ASSOC);
?>
			
			
            <div class="form-group">
              <label class="col-sm-3 control-label">COMPANY NAME</label>
              <div class="col-sm-6"><input name="sitename" value="<?php echo $data['sitename']; ?>" class="form-control" type="text"></div>
            </div>
                
            
                        
            <div class="form-group">
              <label class="col-sm-3 control-label">Mobile</label>
              <div class="col-sm-6"><input name="mobile" value="<?php echo $data['mobile']; ?>" class="form-control" type="text"></div>
            </div>
                
            
                        
            <div class="form-group">
              <label class="col-sm-3 control-label">Email</label>
              <div class="col-sm-6"><input name="email" value="<?php echo $data['email']; ?>" class="form-control" type="text"></div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label">Currency Symbol</label>
              <div class="col-sm-6"><input name="currency" value="<?php echo $data['currency']; ?>" class="form-control" type="text"></div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label">SMS API</label>
              <div class="col-sm-6"><textarea rows="4" cols="50" name="sms" class="form-control" type="text"><?php echo $data['sms']; ?></textarea></div>
              </div>
            
            <div class="form-group" style="margin: 5%;">
			<p>This script can use any SMS Gate Way. Just Paste the code from your sms api. The same code you would have typed in the browser</p>
			<p>There are two things you must replace for it to work</p><p>
			1) The Recipient phone number with <strong>[TO]</strong></p><p>
			2) The Message with <strong>[MESSAGE]</strong></p>
			
              <label class="col-sm-12">Sample: &nbsp;&nbsp;&nbsp; http://sms.marketnaija.com//API/?action=compose&username=mamama&api_key=aaaaaa999999ddddd&sender=sarutech&to=[TO]&message=[MESSAGE] </label>
              <label class="col-sm-12">Just Fill Up the full text from your sms api service with replace message with[MESSAGE] and To-Phonenumber with [TO] </label>
            </div>
                
            

            
            
        </div><!-- panel-body -->
        
        <div style="display: block;" class="panel-footer">
			 <div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				  <button class="btn btn-primary">Submit</button>
				</div>
			 </div>
			 
			 
          </form>
          
			 
		  </div><!-- panel-footer -->
        
      </div><!-- panel -->
      
     
      
     
      
      


	  
       

               </div><!-- col-md-12 -->
      
      </div><!-- row -->

      
      
      
    </div><!-- contentpanel -->



 




<?php
 include ('footer.php');
 ?>
 
 	
</body>
</html>