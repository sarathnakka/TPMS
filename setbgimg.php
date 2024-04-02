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
      <h2><i class="fa fa-cog"></i> Background Image </h2>
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
          

    <?php

// IMAGE UPLOAD //////////////////////////////////////////////////////////
	$folder = "../img/";
	$extention = strrchr($_FILES['bgimg']['name'], ".");
	$new_name = "bg";
	$bgimg = $new_name.'.jpg';
	$uploaddir = $folder . $bgimg;
	move_uploaded_file($_FILES['bgimg']['tmp_name'], $uploaddir);
//////////////////////////////////////////////////////////////////////////



?>
							 <form name="" id="" action="" method="post" enctype="multipart/form-data" >
<br/>
				  
            <div class="form-group">
              <label class="col-sm-3 control-label">Background Image</label>
              <div class="col-sm-6"><input name="bgimg" type="file" id="bgimg" /></div>
            </div>
                
            
            

            
            
        </div><!-- panel-body -->
        
        <div style="display: block;" class="panel-footer">
			 <div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				Demo Version!! You Cant Change!
				</div>
			 </div>
			 
			 
          </form>
          
			 
		  </div><!-- panel-footer -->
        
		
Current Image : <br/><img src="../img/bg.jpg" width="600px;" height="400px" alt="IMG">

<br/><br/><br/><br/>
		
		
      </div><!-- panel -->
      
     
      
     
      
      

     
     
    </div>
	  
	  
	  
       

       
      
      </div><!-- row -->

      
      
      
    </div><!-- contentpanel -->



 




<?php
 include ('footer.php');
 ?>
 	
</body>
</html>