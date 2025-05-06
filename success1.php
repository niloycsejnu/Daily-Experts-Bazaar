

<?php 
    include 'includes/session.php';
    include 'includes/header.php';
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
               
                    <div class="col-md-8 d-flex" style="text-align:center">
                        <h3 class="mb-3" style="text-align:center">Order Complete</h3>
                        <a href="index.php" class="btn btn-success btn-block">Back to Home</a>
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