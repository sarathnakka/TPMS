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
 <style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the current printer page size */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        body 
        {
            background-color:#FFFFFF;        
            margin: 0px;  /* the margin on the content before printing */
			padding: 20px;
       }
	   b, strong {
    font-weight: 100 !important;
}
	   
    </style>
	
  <script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>

    <div class="pageheader">
      <h2><i class="fa fa-th-list"></i>Print Receipt</h2>
    </div>

    
    <div class="contentpanel">
	
		<div id="ass" class="col-md-8 col-md-offset-2" style="
    border-style: solid;
    border-color: #bbb; background-color: #fff;"><br/>
	
	
		
		<div style="text-align:center"><img src="img/logo.png" alt="" height="30px"></div>
				
<?php	

$id = $_GET["id"];

$order = $pdo->query("SELECT * FROM `order` WHERE id='".$id."'");
$order = $order->fetch(PDO::FETCH_ASSOC);

$customer = $pdo->query("SELECT fullname, phonenumber, address FROM customer WHERE id='".$order['customer']."'");
$customer = $customer->fetch(PDO::FETCH_ASSOC);
$staff = $pdo->query("SELECT fullname FROM staff WHERE id='".$order['received_by']."'");
$staff = $staff->fetch(PDO::FETCH_ASSOC);
?>			

<div class="row">
<div class="col-md-12">
<h3><u>ID: <?php echo $order['id']; ?></u></h3><b style="float:right; margin-top:40px;"> Date: &nbsp; &nbsp; <?php echo $order['date_collected']; ?> </b>

<b>NAME: &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $customer['fullname']; ?></b><br/>

<b>ADDRESS: &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $customer['address']; ?></b><br/>

<b>PHONE: &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $customer['phonenumber']; ?></b><br/>
<b>Served. By:</b> &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $staff['fullname']; ?><br/><br/>
</div>


<div class="col-md-6"></div>

	</div><!-- ROW-->			
				
				
				
<div class="table-responsive">
                <table class="table table-success mb30">
                    <thead>
                      <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>

                   

                     
                  
	
<?php
$balance = 	$order['amount'] - $order['paid'];
echo "   <tr><td>$order[description]</td><td>$currency $order[amount] </td><td> $currency$balance </td></tr>";

?>
      
  </tbody>
                </table>
                
                <div style='margin-left:40%;'><b>Staff Sign</b></div><br/><br/>
				<div style='margin-left:40%;'><b>Customer Sign</b></div>
                
            </div>
			
			
	<br/><br/><br/><br/>		
				<br/>
			
			
			
            </div>
			
		<div class="pull-right">
        <a href="" onClick="printContent('ass')" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
        </div>	
		

    </div><!-- contentpanel -->
    


  
</section>


<?php
 include ('footer.php');
 ?>

<script src="js/jquery.datatables.min.js"></script>
<script src="js/select2.min.js"></script>

<script>
  jQuery(document).ready(function() {
    
    "use strict";
    
    jQuery('#table1').dataTable();
    
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers"
    });
    
    // Select2
    jQuery('select').select2({
        minimumResultsForSearch: -1
    });
    
    jQuery('select').removeClass('form-control');
    
    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var c = confirm("Continue delete?");
      if(c)
        jQuery(this).closest('tr').fadeOut(function(){
          jQuery(this).remove();
        });
        
        return false;
    });
    
    // Show aciton upon row hover
    jQuery('.table-hidaction tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });
  
  
  });
</script>



</body>
</html>



