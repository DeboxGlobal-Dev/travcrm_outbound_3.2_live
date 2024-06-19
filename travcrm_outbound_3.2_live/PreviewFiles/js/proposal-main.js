function proposal_alertspopupopen(filename,width,height){
	$('#proposal_alertswhitebox').html('<div class="lds-css ng-scope"><div style="width:100%;height:100%" class="lds-ripple"><div></div> <div></div></div>');
	$('#proposal_alertbox').show();
	$("#proposal_alertswhitebox").animate({width:""+width+""},400);
	$("#proposal_alertswhitebox").animate({height:""+height+""},400); 
	$('#proposal_alertswhitebox').load('proposal_loadalertbox.php?'+filename);
	$('body').css('overflow','hidden');
}


function proposal_alertspopupClose(){
	$('#proposal_alertbox').hide();
	$('#proposal_alertswhitebox').html('');
	$('body').css('overflow','visible');
}


function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
	parent.location.reload();
    return false;
}


function Export2Word(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    
    var content = document.getElementById(element).innerHTML;

    var html = preHtml+content+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';	
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
} 

function copyToClipboard(elementId) {

  // Create a "hidden" input
  var aux = document.createElement("input");

  aux.setAttribute("value", document.getElementById(elementId).href);
  // Append it to the body
  document.body.appendChild(aux);
  // Highlight its content
  aux.select();
  // Copy the highlighted text
  document.execCommand("copy");
  // Remove it from the body
  document.body.removeChild(aux);

  alert('Link Copied');

  return true;
}

function getFormate(propType){
    // var maxwidth = 0;
    // var maxheight = 0;
    // if(propType==1){
    //     maxwidth = 800;
    //     maxheight = 300;
    // }
    // if(propType==2){
    //     maxwidth = 800;
    //     maxheight = 300;
    // }
    // if(propType==3){
    //     maxwidth = 800;
    //     maxheight = 300;
    // }
    // if(propType==4){
    //     maxwidth = 800;
    //     maxheight = 300;
    // }
    // if(propType==6){
    //     maxwidth = 800;
    //     maxheight = 750;
    // }
    $('#loadPropTypeBox').load('proposal_loadalertbox.php?action=loadFormatSize&proposalType='+propType);
      
}

function upload_quotBanner(ele,previewDiv,previewImgID){

    var file = ele.files[0];
    var fsize = file.size || file.fileSize;
    // alert(fsize/1024);

    var name = ele.files[0].name;
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['png','jpg','jpeg']) == -1)  {
        alert("Failed, Supported file type is (JPG, PNG and JPEG)");
        return false;
    } 

    if(fsize > 1000000) {
        alert("You have selected a large file "+(fsize/1024) + ", please select less than 1 MB.");
        return false;
    }

    var _URL = window.URL || window.webkitURL;

    image = new Image();

    var imgwidth = 0;
    var imgheight = 0;

    var maxwidth = $('#maxwidth').val();
    var maxheight = $('#maxheight').val();
    if(maxwidth>0 && maxheight>0){

        image.src = _URL.createObjectURL(file);
        image.onload = function() {
            imgwidth = this.width;
            imgheight = this.height;
            imgsrc = this.src;
            if(imgwidth == maxwidth && imgheight == maxheight){
                $('#'+previewImgID).attr("src", imgsrc);
                $('#'+previewDiv).show();
                return true;
            }else {
                alert("You have selected Invalid dimensions "+imgwidth+"X"+imgheight);
                return false;
            }
        };
        image.onerror = function() {
            alert("Failed, Supported file type is (JPG, PNG and JPEG)");
            return false;
        }
    }else{
        alert("Failed, Please select the proposal photo size in 'Proposal Setting Master'");
        return false;
    }

}