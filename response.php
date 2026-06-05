<!DOCTYPE html>
<html>
<head>
	<title>Cashfree - PG Response Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 align="center">Payment Page</h1>	

	<?php  
		$secretkey = "cfsk_ma_test_9ddc7854159df014b1d40b47c4fb39e2_467f0e4a";
		$orderId = $_POST["orderId"];
		$orderAmount = $_POST["orderAmount"];
		$referenceId = $_POST["referenceId"];
		$txStatus = $_POST["txStatus"];
		$paymentMode = $_POST["paymentMode"];
		$txMsg = $_POST["txMsg"];
		$txTime = $_POST["txTime"];
		$signature = $_POST["signature"];
		$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
		$hash_hmac = hash_hmac('sha256', $data, $secretkey, true);
		$computedSignature = base64_encode($hash_hmac);

		if ($signature == $computedSignature) {
	?>
	<div class="container"> 
		<div class="panel panel-success">
		  <div class="panel-heading">Signature Verification Successful</div>
		  <div class="panel-body">
			<table class="table table-hover">
			    <tbody>
			      <tr>
			        <td>Order ID</td>
			        <td><?php echo $orderId; ?></td>
			      </tr>
			      <tr>
			        <td>Order Amount</td>
			        <td><?php echo $orderAmount; ?></td>
			      </tr>
			      <tr>
			        <td>Reference ID</td>
			        <td><?php echo $referenceId; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Status</td>
			        <td><?php echo $txStatus; ?></td>
			      </tr>
			      <tr>
			        <td>Payment Mode </td>
			        <td><?php echo $paymentMode; ?></td>
			      </tr>
			      <tr>
			        <td>Message</td>
			        <td><?php echo $txMsg; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Time</td>
			        <td><?php echo $txTime; ?></td>
			      </tr>
			    </tbody>
			</table>
			<!-- Download Ticket button if payment is successful -->
			<?php if ($txStatus == "SUCCESS") { ?>
				<a href="success.php?orderId=<?php echo $orderId; ?>&amount=<?php echo $orderAmount; ?>" class="btn btn-primary">Go To Download</a>
			<?php } else { ?>
				<!-- Show Go to Home button if payment failed -->
				<a href="index.php" class="btn btn-warning">Go to Home</a>
			<?php } ?>
		  </div>
		</div>
	</div>

	<?php   
		} else {
	?>
	<div class="container"> 
		<div class="panel panel-danger">
		  <div class="panel-heading">Signature Verification failed</div>
		  <div class="panel-body">
			<table class="table table-hover">
			    <tbody>
			      <tr>
			        <td>Order ID</td>
			        <td><?php echo $orderId; ?></td>
			      </tr>
			      <tr>
			        <td>Order Amount</td>
			        <td><?php echo $orderAmount; ?></td>
			      </tr>
			      <tr>
			        <td>Reference ID</td>
			        <td><?php echo $referenceId; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Status</td>
			        <td><?php echo $txStatus; ?></td>
			      </tr>
			      <tr>
			        <td>Payment Mode </td>
			        <td><?php echo $paymentMode; ?></td>
			      </tr>
			      <tr>
			        <td>Message</td>
			        <td><?php echo $txMsg; ?></td>
			      </tr>
			      <tr>
			        <td>Transaction Time</td>
			        <td><?php echo $txTime; ?></td>
			      </tr>
			    </tbody>
			</table>
			<!-- Button to go back to home if signature verification fails -->
			<a href="index.php" class="btn btn-warning">Go to Home</a>
		  </div>
		</div>
	</div>

	<?php	
		}
	?>

</body>
</html>
