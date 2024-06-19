function formValidation(frmid,submitbutton,saven){
var returnflag='y';
$('#'+frmid+' .validate').each(function(i, obj) { 
var elem = $(this); 
var ID = elem.attr('id');
var ATTR = elem.attr('name'); 
var TYPE = elem.attr('type');
var DISPLAYNAME = elem.attr('displayname');
var FIELDMINLENGTH = elem.attr('field_min_length');
var FIELDVALUE = $("#"+ID).val(); 


//alert(ID);
//alert(ATTR);
//alert(TYPE);
//alert(DISPLAYNAME);
//alert(FIELDMINLENGTH);
//alert(FIELDVALUE);


//----------------Special Characters Validation----------------

 

if(TYPE!='email'){
/*if(/^[a-z@A-Z0-9- ]*$/.test(FIELDVALUE) == false) { 
var msg='Special characters not allowed in '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
}*/ }
 
//----------------Email Validation----------------

if(TYPE=='email'){
if(this.value==''){ 
var msg='Please enter valid email address';
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
}

if(this.value!=''){
var regEmail = /^([-a-zA-Z0-9._]+@[-a-zA-Z0-9.]+(\.[-a-zA-Z0-9]+)+)$/;
if(!this.value.match(regEmail)){ 
var msg='Please enter valid email address';
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false; 
} } }


if(TYPE=='phone'){
if(this.value==''){ 
var msg='Please enter valid '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
} }

if(TYPE=='text'){
if(this.value==''){ 
var msg='Please enter '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false; 
} }


if(TYPE=='password'){
if(this.value==''){ 
var msg='Please enter '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false; 
} }

 

//----------------Select Field Validation----------------

if(TYPE!='password' || TYPE!='text' || TYPE!='phone' || TYPE!='email'){
	
if(FIELDVALUE==0){ 
var msg='Please select '+DISPLAYNAME+'';
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
}
}
 
 
 //----------------Length Validation----------------
 

/*if($(this).val().length<FIELDMINLENGTH){ 
var msg='Please enter minimum '+FIELDMINLENGTH+' character in '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
}*/

  
});


if(returnflag=='y'){
startloading();
$("#savenew").val(saven);
$("#"+frmid).submit();
//$("."+submitbutton).val('Save'); 
//$(':input[type="button"]').prop('disabled', false);

} 
}


function alertbox(header,content){ 

	swal('System Alert!', content, 'warning');

	//$("#alertvalidation").show(); 
	//document.getElementById('alertvalidationheader').innerHTML=header; 
	//document.getElementById('alertvalidationcontent').innerHTML=content; 
}

function closeanydiv(divid){
	$("#"+divid).hide();
}



