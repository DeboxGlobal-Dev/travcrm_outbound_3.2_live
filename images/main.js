$(document).mouseup(function(e) 
{
    var container = $(".downarrow"); 
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#menudropdown').hide(); 
		$('.downarrow').removeClass('active');
    } else {
		$('#menudropdown').show();
		$('.downarrow').addClass('active');
	}
	
	
	 var container = $(".addmod"); 
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#menudropdownadd').hide(); 
		$('.addmod').removeClass('active');
    } else {
		$('#menudropdownadd').show();
		$('.addmod').addClass('active');
	}
	
	 var container = $(".settingmod"); 
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#menudropdownsetting').hide(); 
		$('.settingmod').removeClass('active');
    } else {
		$('#menudropdownsetting').show();
		$('.settingmod').addClass('active');
	}
	
	var container = $("#datepicker"); 
	if (!container.is(e.target) && container.has(e.target).length === 0) 
    {  
		$('#datepicker').removeClass('active');
    } else { 
		$('#datepicker').addClass('active');
	}
	
	
});



function comtabopenclose(closeclass,openid){
	$('.'+closeclass).slideUp();
	$('#'+openid).slideDown();
}


function checkallbox(){ 
  if ($("#checkAll").is(':checked')) { 
            $(".chk").prop("checked", true); 
        } else { 
            $(".chk").prop("checked", false); 
        }	 

}





$('input:checkbox.chk').each(function () { 
       var sThisVal = (this.checked ? $(this).val() : ""); 
	   
  });
 


function setupbox(url){
startloading();
window.location.href=url;	
}


function submitfieldfrm(frmname){
startloading();
$('#'+frmname).submit();
}



function alertspopupopen(filename,width,height){
$('#alertnotificationsmainbox').show();
$('#alertswhitebox').css('height',height);
$('#alertswhitebox').css('width',width);
$('#alertswhitebox').load('loadalertbox.php?'+filename);
}

function alertspopupopenClose(){
$('#alertnotificationsmainbox').hide();
}

function startloading(){
$('#pageloading').show();	
$('#pageloader').show();	
$("#pageloader").animate({top:'53px'}, 120)	
}

 
function permissiononoff(id,modid){
var userid = $('#id').val(); 
var classb = $('#'+id).attr('class');
 

if(classb=='switchouter switchouteron'){
$('#'+id).removeClass('switchouteron');
$('#'+id).addClass('switchouteroff');
}

if(classb=='switchouter switchouteroff'){
$('#'+id).removeClass('switchouteroff');
$('#'+id).addClass('switchouteron');
}

}





















