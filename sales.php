<?php
	include 'includes/session.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once(__DIR__ . "/lib/SslCommerzNotification.php");

	use SslCommerz\SslCommerzNotification;

	
	

	if(isset($_POST['pay'])){


		$post_data = array();

		$post_data['total_amount'] = $_POST['amount'];
		$post_data['currency'] = "BDT";
		$post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
	
		# CUSTOMER INFORMATION
		$post_data['cus_name'] = isset($_POST['customer_name']) ? $_POST['customer_name'] : "John Doe";
		$post_data['cus_email'] = isset($_POST['customer_email']) ? $_POST['customer_email'] : "john.doe@email.com";
		$post_data['cus_add1'] = "Dhaka";
		$post_data['cus_add2'] = "Dhaka";
		$post_data['cus_city'] = "Dhaka";
		$post_data['cus_state'] = "Dhaka";
		$post_data['cus_postcode'] = "1000";
		$post_data['cus_country'] = "Bangladesh";
		$post_data['cus_phone'] = isset($_POST['customer_mobile']) ? $_POST['customer_mobile'] : "01711111111";
		$post_data['cus_fax'] = "01711111111";
	
		# SHIPMENT INFORMATION
		$post_data["shipping_method"] = "YES";
		$post_data['ship_name'] = "Store Test";
		$post_data['ship_add1'] = "Dhaka";
		$post_data['ship_add2'] = "Dhaka";
		$post_data['ship_city'] = "Dhaka";
		$post_data['ship_state'] = "Dhaka";
		$post_data['ship_postcode'] = "1000";
		$post_data['ship_phone'] = "";
		$post_data['ship_country'] = "Bangladesh";
	
		$post_data['emi_option'] = "1";
		$post_data["product_category"] = "Electronic";
		$post_data["product_profile"] = "general";
		$post_data["product_name"] = "Computer";
		$post_data["num_of_item"] = "1";

	
		$payid = $_POST['pay'];
		$date = date('Y-m-d');

		$conn = $pdo->open();

		try{
			
			$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
			$stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date]);
			$salesid = $conn->lastInsertId();
			
			try{
				$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				foreach($stmt as $row){
					$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
					$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
				}

				$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);
					//api calling time
				$sslcomz = new SslCommerzNotification();
				$sslcomz->makePayment($post_data, 'hosted');

				$_SESSION['success'] = 'Transaction successful. Thank you.';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
		
	
	
	}
	
	header('location: profile.php');
	
?>