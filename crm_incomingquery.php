 
<?php  
$select='*';  
$where='email="'.$_SESSION['username'].'"';  
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);  
$countmail = mysqli_num_rows($rs); 
while($emailsetting=mysqli_fetch_array($rs)){   
	$email=clean($emailsetting['email']);  
	$password=clean($emailsetting['password']);     
}
?>
<iframe style="width:100%; height:100%; border:0px; margin-top:55px;" frameborder="0" scrolling="auto" src="inbox/" id="mailfrm"></iframe>

<script type="text/javascript"> 
//  	var counter=0;
//  	window.setInterval(function(){ 
// 	    var iframe = document.getElementById('mailfrm');
//         var doc = iframe.contentDocument || iframe.contentWindow.document;  
//         doc.getElementsByClassName('message-fixed-button-toolbar')[0].style.display = 'none'; 
//         doc.getElementsByClassName('message-fixed-button-toolbar')[0].style.display = 'none';
// 		 	$(document).ready(function() {
//     	var iframeBody = $("#mailfrm").contents().find(".messageItemHeader");
// 		   	if(counter<=0){
// 	        var styleTag = iframeBody.append('<div id="converttoquerybtn" style="position: absolute; right: 13px; top: 40px;"><input type="button" name="Submit" style="background-color: #34ae4a; color: #fff; font-size: 12px; border: 1px solid #34ae4a; padding: 2px 12px; border-radius: 2px;z-index: 9999;" value="Convert to query" class="bluembutton" onclick="parent.converttoquery();"></div>');
// 	        counter++;
// 	    	}
// 		})
// 	}, 5000);
    
        var counter=0;
	 	window.setInterval(function(){ 
        	var iframe = document.getElementById('mailfrm');
            var doc = iframe.contentDocument || iframe.contentWindow.document;
          	doc.getElementsByClassName('btn-toolbar')[0].style.display = 'none'; 
        	// doc.getElementsByClassName('btn-group-last')[0].style.display = 'none'; 
        			 
            doc.getElementsByClassName('message-fixed-button-toolbar')[0].style.display = 'none'; 
            doc.getElementsByClassName('message-fixed-button-toolbar')[0].style.display = 'none';
    		$(document).ready(function() {
            	var iframeBody = $("#mailfrm").contents().find(".messageItemHeader");
    		   	if(counter<=0){
        	        var styleTag = iframeBody.append('<div id="converttoquerybtn" style="position: absolute; right: 13px; top: 40px;"><input type="button" name="Submit" style="background-color: #34ae4a; color: #fff; font-size: 12px; border: 1px solid #34ae4a; padding: 2px 12px; border-radius: 2px;z-index: 9999;" value="Convert to query" class="bluembutton" onclick="parent.converttoquery();"></div>');
        	        counter++;
    	    	}
    		})
		}, 5000);
		
     	
    function extractEmails ( text ){
    	return text.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
    }
    	
    function converttoquery(){
    	var iframe = document.getElementById('mailfrm');
    	var doc = iframe.contentDocument || iframe.contentWindow.document;
    	var bodydata = doc.getElementsByClassName('bodyText')[0].innerHTML;  
    	 
    	var subjectdata = doc.querySelector(".messageItemHeader").querySelector(".subject").innerText;
    	var to = doc.querySelector(".messageItemHeader").querySelector(".from").getAttribute('title');
    // 	var to = doc.getElementsByClassName('from')[0].getAttribute('title');   
    // 	alert(to);
      // alert(doc.innerHTML);
    	$("#to").val(extractEmails(to)); 
    
    	$('#subjectdata').val('');
    	$('#bodydata').val('');
    
    	$('#subjectdata').val(subjectdata);
    	$('#allhtml').html(bodydata);
    
    	$('#allhtml div').each(function(i, obj) {
        if ( $(obj).css('display') == 'none' ){
            $(obj).remove();
        	}
        });
    
         var bodydata = ($('#allhtml').html());
         $('#bodydata').val(bodydata); 
         $('#converttoqueryfrm').submit();
    }
</script>
<style type="text/css"> 
	.b-toolbar.btn-toolbar.hide-on-mobile{
		display: none!important;
	}
</style>
<div id="allhtml" style="display:none;"></div>
<form method="post" action="showpage.crm?module=query&add=yes" target="_blank" id="converttoqueryfrm" style="display:none;">
<input name="incomingid" type="hidden" value="1" />
<input name="email" id="to" type="hidden"  />
<input name="subjectdata" id="subjectdata" type="hidden"  />
<textarea name="bodydata" id="bodydata" ></textarea> 
</form>