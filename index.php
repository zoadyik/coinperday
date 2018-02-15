<?php header('Access-Control-Allow-Origin: *');?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Coin Per Day</title>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

      .space-right {
        padding-right: 10px;
      }
      .space-bottom{
        padding-bottom: 20px !important;
      }
      input, label {
            float:left;
      }

      label {
      width:180px;
      clear:left;
      text-align:right;
      padding-right:10px;
      }

      .width-ghs{
        width: 50px;
        padding-left: 10px;
      }

      .text-center{
        text-align: center;
      }

    </style>
    </head>
     <body>
<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #e3f2fd;">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">CoinPerDay</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>

  </div>
</nav>
      <div class="container">
        <div class="text-center">
        <h1> My Hashrate </h1>
        </div>
            <form class="form-inline">
      <div class="form-group col-sm-6 space-bottom" >
        <label for="inputdefault" class="space-right" >My Hashrate Skein </label>
      <input class="form-control space-right" id="myHasrateSkein" type="text">
      <label for="inputdefault" class="width-ghs"> GH/s</label>
</div>
      <div class="form-group col-sm-6 space-bottom">
      <label for="inputdefault" class="space-right" >My Hashrate C11 </label>
      <input class="form-control space-right" id="myHasrateC11" type="text">
      <label for="inputdefault" class="width-ghs"> GH/s</label>

</div>

      <div class="form-group col-sm-6 space-bottom">
      <label for="inputdefault" class="space-right" >My Hashrate Xevan </label>
      <input class="form-control space-right" id="myHasrateXevan" type="text">
      <label for="inputdefault" class="width-ghs"> GH/s</label>

</div>
                        <input type="hidden" id="btc">

</form>
      <h1 class="text-center"> Proto Pool Coin Per Day </h1>
      <div class="table-responsive">
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
    <th>coin per btc</th>
    <th>THB per day</th>
      </tr>
    </thead>
        <tbody id='tbody'>

  </tbody>
  </table>
</div>

      <h1 class="text-center"> Phiphi Pool Coin Per Day </h1>
      <div class="table-responsive">
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
    <th>coin per btc</th>
    <th>THB per day</th>
      </tr>
    </thead>
        <tbody id='phiphiTable'>

  </tbody>
  </table>
</div>

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
                      if(value.name == "ArgoCoin" || value.name == "Bithold" || value.name == "Stipend")
                      {
                          blockReward = 
                          (value.name == "ArgoCoin") ? "56.907" : 
                          (value.name == "Bithold" ? "37" : "15");
                          eachRow = "<tr>"
                + "<td>" + value.name + "</td>"
                + "<td>" + value.algo + "</td>"
                + "<td>  <span id='blockReward" + value.name + "'>" + blockReward + "</span> </td>"
                + "<td>  <span id='poolHashrate" + value.name + "'>" + value.hashrate/1000000000 + "</span> </td>"
                + "<td>  <span id='24h_blocks" + value.name + "'>" + value['24h_blocks']  + "</span> </td>"
                + "<td>  <span id='coinPerDay"+ value.name +"'> </span> </td>"
                + "<td>  <span id='coinPerBtc"+ value.name +"'> </span> </td>"
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

function doAjaxPhi() {
    $.ajax({
            type: 'GET',
            url: 'phiphipool.php', //https://phi-phi-pool.net/api/currencies  'https://protopool.net/api/currencies'
            data: $(this).serialize(),
            dataType: 'json',
            async: false,
            success: function (data, response) {
              if ($.trim(data)){
              $('#phiphiTable').empty();
                    $.each(data, function(key, value) {
                      if(value.name == "Vsync" || value.name == "Solaris")
                      {
                          blockReward = (value.name == "Vsync") ? "40" : "1"
                          eachRow = "<tr>"
                + "<td>" + value.name + "</td>"
                + "<td>" + value.algo + "</td>"
                + "<td>  <span id='blockReward" + value.name + "'>" + blockReward + "</span> </td>"
                + "<td>  <span id='poolHashrate" + value.name + "'>" + value.hashrate/1000000000 + "</span> </td>"
                + "<td>  <span id='24h_blocks" + value.name + "'>" + value['24h_blocks']  + "</span> </td>"
                + "<td>  <span id='coinPerDay"+ value.name +"'> </span> </td>"
                + "<td>  <span id='coinPerBtc"+ value.name +"'> </span> </td>"
                + "<td>  <span id='thbPerDay"+ value.name +"'> </span> </td>"
                + "</tr>";
                 $('#phiphiTable').append(eachRow);
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
                    setTimeout(doAjaxPhi, interval);
            }
    });
}

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
                    //console.log(value);
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

function coinexchange() {
    $.ajax({
            type: 'GET',
            url: 'coinexchange.php', //https://phi-phi-pool.net/api/currencies  'https://protopool.net/api/currencies'
            data: $(this).serialize(),
            dataType: 'json',
            async: false,
            success: function (data) {
              if ($.trim(data)){
                  //  $('#coinexchange').text(data.result[0].LastPrice);
                    $.each(data.result, function(k,v) {
                   // console.log(v.LastPrice);
                    if(v.MarketID == '467') //vsx
                     $('#coinPerBtcVsync').text(v.LastPrice);
                    if(v.MarketID == '297') //slr
                    $('#coinPerBtcSolaris').text(v.LastPrice);

                  $('#coinPerBtcArgoCoin').text('0.00019990');
                 });

                   }

                   else
                   {
          $('#test').text("NO DATA");
                   }

            },
            complete: function (data) {
                    // Schedule the next
                    setTimeout(coinexchange, interval);
            }
    });
}

function getSouthxchangePrice() {
    $.ajax({
            type: 'GET',
            url: 'https://www.southxchange.com/api/prices', //https://phi-phi-pool.net/api/currencies  'https://protopool.net/api/currencies'
            data: $(this).serialize(),
            dataType: 'json',
            async: false,
            success: function (data) {
              if ($.trim(data)){
                  //  $('#coinexchange').text(data.result[0].LastPrice);
                    $.each(data, function(k,v) {
                    if(v.Market == 'BHD/BTC')
                     $('#coinPerBtcBithold').text(v.Bid);

                 });

                   }

                   else
                   {
        //  $('#test').text("NO DATA");
                   }

            },
            complete: function (data) {
                    // Schedule the next
                    setTimeout(getSouthxchangePrice, interval);
            }
    });
}
doAjax();
coinmarketcap();
doAjaxPhi();
coinexchange();
getSouthxchangePrice();
setTimeout(doAjax, interval);
setTimeout(coinmarketcap, interval);
setTimeout(doAjaxPhi, interval);

//$('#coinPerBtcBithold').text('0.0000898');

function totalCoins(coins, percentage){
  coins = coins - coins * percentage;
  return coins;
}

$(document).ready(function(){

    $('#myHasrateSkein').keyup(function(){
      var Argocoins = $('#blockRewardArgoCoin').text() * $('#24h_blocksArgoCoin').text() / ($('#poolHashrateArgoCoin').text() / $('#myHasrateSkein').val()).toFixed(2);
      Argocoins =  totalCoins(Argocoins, 0.24);
      var ArgocoinsConvertThaiBaht = Argocoins * $('#coinPerBtcArgoCoin').text() * $('#btc').val();
        $('#coinPerDayArgoCoin').text(Argocoins.toFixed(2));
        $('#thbPerDayArgoCoin').text(ArgocoinsConvertThaiBaht.toFixed(2));
    });
    $('#myHasrateC11').keyup(function(){
      var bitHoldCoins = $('#blockRewardBithold').text() * $('#24h_blocksBithold').text() / ($('#poolHashrateBithold').text() / $('#myHasrateC11').val()).toFixed(2);
      var bitHoldCoinsConvertThaiBaht = bitHoldCoins * $('#coinPerBtcBithold').text() * $('#btc').val();
      bitHoldCoins = totalCoins(bitHoldCoins, 0.24);
        $('#coinPerDayBithold').text(bitHoldCoins.toFixed(2));
        $('#thbPerDayBithold').text(bitHoldCoinsConvertThaiBaht.toFixed(2));
    });
        $('#myHasrateXevan').keyup(function(){
      var vsxCoins = $('#blockRewardVsync').text() * $('#24h_blocksVsync').text() / ($('#poolHashrateVsync').text() / $('#myHasrateXevan').val()).toFixed(2);
      var vsxCoinsConvertThaiBaht = vsxCoins * $('#coinPerBtcVsync').text() * $('#btc').val();
        $('#coinPerDayVsync').text(vsxCoins.toFixed(2));
        $('#thbPerDayVsync').text(vsxCoinsConvertThaiBaht.toFixed(2));
    });
                $('#myHasrateXevan').keyup(function(){
      var SolarisCoins = $('#blockRewardSolaris').text() * $('#24h_blocksSolaris').text() / ($('#poolHashrateSolaris').text() / $('#myHasrateXevan').val()).toFixed(2);
      var SolarisCoinsConvertThaiBaht = SolarisCoins * $('#coinPerBtcSolaris').text() * $('#btc').val();
        $('#coinPerDaySolaris').text(SolarisCoins.toFixed(2));
        $('#thbPerDaySolaris').text(SolarisCoinsConvertThaiBaht.toFixed(2));
    });


});
var http = require("http");
setInterval(function() {
    http.get("http://stark-fjord-52435.herokuapp.com");
}, 300000); // every 5 minutes (300000)

</script>

