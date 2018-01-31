<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Proto Pool Coin Per Day</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  	<style type="text/css">
  		.try-center {
  			display:block;
			margin: 0 auto;
  		}

  		.small-input {
  			width: 50%;
  		}
  	</style>
  	</head>
  	 <body>
  	 	<div class="container">
  	 	<h1 class="text-center"> Proto Pool Coin Per Day </h1>
  	 	<table class="table table-bordered">
	<thead>
      <tr>
        <th>Coin Name</th>
        <th>Algo</th>
        <th>block reward</th>
        <th>pool hashrate (GH/s)</th>
        <th>24 hr blocks </th>
        <!-- <th>My hashrate (GH/s)</th> -->
		<th>coin per day</th>
		<th>THB per day</th>
      </tr>
    </thead>
        <tbody id='tbody'>

	</tbody>
  </table>
  <div class="try-center">
    <form class="form-inline">

    	<div class="form-group">
    		<div class="row">
    	 <label for="inputdefault" >My Hashrate Skein</label>
   	    <div class="input-group col-md-7">
      <input class="form-control" id="myHasrateSkein" type="text">
      <label for="inputdefault" class="col-md-5" >GH/s</label>
</div>
</div>
<div class="row">
         <label for="inputdefault" >My Hashrate C11</label>
   	    <div class="input-group col-md-7">
      <input class="form-control" id="myHasrateC11" type="text">
      <label for="inputdefault" class="col-md-5" >GH/s</label>
    </div>
</div>
</div>
                    	  <input type="hidden" id="btc">

</form>
  	 </div>
  	 </body>

</html>

<?php
/*$json = file_get_contents('http://protopool.net/api/currencies');
$obj = json_decode($json,true);
foreach($obj as $key => $val){
	//echo $val['name'];
}*/
?>

<script>
	var interval = 360000;  // 1000 = 1 second, 3000 = 3 seconds
	var eachRow = "";
	var i = 1;
function doAjax() {
    $.ajax({
            type: 'GET',
            url: 'protopool.php', //https://phi-phi-pool.net/api/currencies  'https://protopool.net/api/currencies'
            data: $(this).serialize(),
            dataType: 'json',
            async: false, 
            success: function (data, response) {
            	if ($.trim(data)){   
            	$('#tbody').empty();
                    $.each(data, function(key, value) { 
                    	if(value.name == "ArgoCoin" || value.name == "Bithold")
                    	{
                    			blockReward = (value.name == "ArgoCoin") ? "59.38" : "37"
                     			eachRow = "<tr>"
 								+ "<td>" + value.name + "</td>"
 								+ "<td>" + value.algo + "</td>"
 								+ "<td>  <span id='blockReward" + value.name + "'>" + blockReward + "</span> </td>"
 								+ "<td>  <span id='poolHashrate" + value.name + "'>" + value.hashrate/1000000000 + "</span> </td>"
 								+ "<td>  <span id='24h_blocks" + value.name + "'>" + value['24h_blocks']  + "</span> </td>"
 								+ "<td>  <span id='coinPerDay"+ value.name +"'> </span> </td>"
 								+ "<td>  <span id='thbPerDay"+ value.name +"'> </span> </td>"
 								+ "</tr>";
 								 $('#tbody').append(eachRow);
 								}
 								}); 

                   }

                   else
                   {
 					$('#test').text("NO DATA");
                   }

            },
            complete: function (data) {
                    // Schedule the next
                    setTimeout(doAjax, interval);
            }
    });
}
doAjax();
coinmarketcap();
setTimeout(doAjax, interval);

function coinmarketcap() {
    $.ajax({
            type: 'GET',
            url: 'coinmarketcap.php', //https://phi-phi-pool.net/api/currencies  'https://protopool.net/api/currencies'
            data: $(this).serialize(),
            dataType: 'json',
            async: false, 
            success: function (data, response) {
            	if ($.trim(data)){   
                    $.each(data, function(key, value) { 
                    	console.log(value.price_thb);
                    	$('#btc').val(value.price_thb);
 						}); 

                   }

                   else
                   {
 					$('#test').text("NO DATA");
                   }

            },
            complete: function (data) {
                    // Schedule the next
                    setTimeout(coinmarketcap, interval);
            }
    });
}
setTimeout(doAjax, interval);


$(document).ready(function(){

    $('#myHasrateSkein').keyup(function(){
    	var Argocoins = $('#blockRewardArgoCoin').text() * $('#24h_blocksArgoCoin').text() / ($('#poolHashrateArgoCoin').text() / $('#myHasrateSkein').val());
    	var ArgocoinsConvertThaiBaht = Argocoins * 0.0002 * $('#btc').val();
        $('#coinPerDayArgoCoin').text(Argocoins.toFixed(2));
        $('#thbPerDayArgoCoin').text(ArgocoinsConvertThaiBaht.toFixed(2));
    });
    $('#myHasrateC11').keyup(function(){
    	var bitHoldCoins = $('#blockRewardBithold').text() * $('#24h_blocksBithold').text() / ($('#poolHashrateBithold').text() / $('#myHasrateC11').val()).toFixed(2);
    	var bitHoldCoinsConvertThaiBaht = bitHoldCoins * 0.0000898 * $('#btc').val();
        $('#coinPerDayBithold').text(bitHoldCoins.toFixed(2));
        $('#thbPerDayBithold').text(bitHoldCoinsConvertThaiBaht.toFixed(2));
    });


});

</script>

