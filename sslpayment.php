<?php include 'includes/session.php'; ?>
<?php 
    include 'includes/header.php';
    
        if(isset($_GET['pay'])){
            $payid = $_GET['pay'];
        }
    ?>

<style>

    .input-group{
        display:none;
    }    
    .btn-danger{
        display:none;
    }
     .centered-column {
        display: flex;
        justify-content: center;
    }

</style>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="content-wrapper" >
            <div class="container">
                <!-- Main content -->
                <div class="row centered-column" style="margin-top:15px;">    
               
                    <div class="col-md-8 d-flex">
                        <h2 class="mb-3">Pay with SSL COMMERZ</h2>
                        <h4 class="mb-3">Billing address</h4>
                        <form action="sales.php" method="POST" class="form-group">
                            <input type="hidden" name="pay" value="<?php echo $payid; ?>"> 
                            <input type="hidden" name="amount" id="amount"> 
                            <div class="form-group">
                                <label for="firstName">Full name</label>
                                <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="number" name="customer_mobile" class="form-control" id="mobile" placeholder="Mobile" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" name="customer_email" class="form-control" id="email" placeholder="you@example.com"  required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="1234 Main St"value="93 B, New Eskaton Road" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to Payment</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
	       				<div class="box box-solid"> 
		       				<div class="box-body prod-body" style="margin-top:50px;">
                               <h4 class="mb-3">Your Cart Total</h4>
                               <table class="table table-bordered">
                                    <thead>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
var total = 0;
$(function(){
	
	getDetails();
	getTotal();

});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'payment_cart_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
		}
	});
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
            $('#amount').val(total);
		}
	});
}
</script>

</body>
</html>