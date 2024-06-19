<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>
.col-md-6 {  display: none !important;}
#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}
body{overflow-x:hidden !important;}
.header{font-weight: 500 !important; font-size: 13px !important;}
#mainsectiontable .fa-pencil-square{cursor: pointer;
    font-size: 20px;
    color: #ff5c00;
	}

.buttonlists a {
    padding: 5px 10px;
    float: left;
    margin-right: 10px;
    border: 1px solid #2ca1cc;
    font-size: 14px;
    font-weight: 500;
    color: #fff !important;
    background-color: #2ca1cc;
    cursor: pointer;
    border-radius: 4px;
} 
</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">CRM Rates</span></div></td>
		<td style="float: right; margin-right: 20px;"><input type="button" name="Submit22" value="Back" class="whitembutton" onclick="window.location.href='showpage.crm?module=query'"/></td>
      </tr>
    </tbody>
  </table>
</div>

 
<div id="pagelisterouter"> 
<div class="rates-block" style="padding:10px;">
<div class="buttonlists" style="display:inline-block;">
<a onclick="loadcrmrates('1');" id="ratedicon1" class="ratediconclass">+ Hotel</a> 
<a onclick="loadcrmrates('2');" id="ratedicon2" class="ratediconclass">+ Entrance</a> 
<a onclick="loadcrmrates('3');" id="ratedicon3" class="ratediconclass">+ Transfer</a> 
<a onclick="loadcrmrates('4');" id="ratedicon4" class="ratediconclass">+ Transportation</a>
<a onclick="loadcrmrates('5');" id="ratedicon5" class="ratediconclass">+ Activity</a>
<div id="loadcrmrates" style="width: 100%; margin: 40px 0px;"></div> 
</div>
</div>  
<script>  
function loadcrmrates(id){
$('#loadcrmrates').load('loadcrmrates.php?id='+id);
$('.ratediconclass').removeClass('new-hover-color');
$('#ratedicon'+id).addClass('new-hover-color');
}
loadcrmrates('1');
</script> 
<style>
.new-hover-color{
    background:#f8c721 !important; 
     border: 1px solid #f8c721 !important; 
}
</style>