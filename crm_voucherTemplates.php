

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .container{
        padding: 10px;
       height: 100%;
    }

    .containerBox{
        width: 49.5%;
        display: inline-block;
    }

    .leftContainer{
        width: 67%;
        display: inline-block;
        padding-right: 10px;
    }

    .rightContainer{
        width: 30%;
        display: inline-block;
    }
    .con_first{
        background-color:#4a7b8352;
        position: relative;
        z-index: 9999999999;
    }
    /* f00e  */
    .con_first::after{
        content: '\f00e';
        font-family: 'FontAwesome';
        position:absolute; 
        top:1px;
        left:0;
        right: 0;
        bottom: 0;
        width: 25px;
        height: 29px;
        margin: auto;
        font-size: 31px;
        background-color: #fff;
        color: #233A49;
        border-radius: 3px;
        display: block !important;

    }
    .con_second::after{
        content: '\f010';
        font-family: 'FontAwesome';
        position:fixed; 
        top:0;
        left:0;
        right: 0;
        bottom: 0;
        width: 25px;
        height: 29px;
        margin: auto;
        font-size: 31px;
        background-color: #fff;
        color: #233A49;
        border-radius: 3px;
        display: block !important;
    }

    .viewFullScreen{
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        width: 98.5%;
        margin: auto;
        overflow: auto;
        z-index: 99999;
        background-color: rgba(50, 61, 76, 0.91);
        background-image: url("images/bgpop.png"); background-repeat: repeat;
    }

    .subContainer{
        width: 55%;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        z-index: 99999;
        margin-top: 80px;
        margin-bottom: 20px;
    }
    .showPreprint{
        display: block !important;
    }
    .defaulbtn{
        width: 100%;

    }
    .defaulbtn a{
     width: 151px;
    background: #4CAF50;
    color: #ffffff !important;
    display: block;
    padding: 10px;
    margin: 20px auto;
    font-size: 14px;
    text-align: center;
    border-radius: 3px;
    }
    .textStyle_tSEC{
        text-align: right;
        margin-top: 0px;
        padding-top: 0px;
    }
    .firstconclass{
        position: absolute;
         top:0;
         left:0;
         right:0;
         bottom:0;
         width: 100%;
         margin: auto;
        z-index: 99999;
    }
    .img_stycl{
        width: 700px;
        margin: 50px auto 50px auto;
        position: absolute;
        top: 50px;
        left: 0;
        right: 0;
        /* bottom: 50px; */
        padding-bottom: 50px;
    }
    .temp_hight{
        height: 354px;
        overflow:hidden;
    }
</style>
<body>
    <?php 
    
    $rs = GetPageRecord('setDefaultTemplate','voucherSettingMaster','id=1');
    $voucherData = mysqli_fetch_assoc($rs);
    $setDefaultTemplate = $voucherData['setDefaultTemplate'];
    
    ?>
    
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader" style="margin-top: 48px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="font-weight:500;
    font-size: 20px;"><span id="topheadingmain"> Update <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
            <td style="padding-right:20px;">&nbsp; </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="addeditfrm"  id="addeditfrm">
 
<div class="addeditpagebox" style="padding: 30px;">
<div id="containerBoxId" class="containerBox">
 <div id="section_first" class="container"  onmouseout="mouseOut();">
    <img align="center" id="imageTemplate_1" src="<?php echo $fullurl; ?>images/template_1.jpeg" alt="" width="500px" height="354" style="z-index:-1;">
 

 </div>
 <div class="defaulbtn"><a href="#" onclick="selectTemplate('1');"><?php if($setDefaultTemplate==1){ echo 'Current Template - 1'; }else{ echo 'Set Default Template - 1';} ?></a></div>
 </div>

  <!-- Second Template ends -->
  <div class="containerBox">
 <div id="section_third" class="container temp_hight" onmouseout="mouseOutthird();">
    <!-- <div id="templateSection_3"> -->
    <img align="center" id="imageTemplate_3" src="<?php echo $fullurl; ?>images/template_3.jpg" alt="" width="500px">
    <!-- </div> -->
 </div>
 <div class="defaulbtn"><a href="#" onclick="selectTemplate('2');"><?php if($setDefaultTemplate==2){ echo 'Current Template - 2'; }else{ echo 'Set Default Template - 2'; } ?></a></div>
 </div>

 <!-- third template end -->

 <div class="containerBox">
 <div id="section_second" class="container"  onmouseout="mouseOutsec();">
 
 <img align="center" id="imageTemplate_2" src="<?php echo $fullurl; ?>images/template_2.jpeg" alt="" width="500px">

 </div>
 <div class="defaulbtn"><a href="#" onclick="selectTemplate('3');"><?php if($setDefaultTemplate==3){ echo 'Current Template - 3'; }else{ echo 'Set Default Template - 3';} ?></a></div>
 </div>

<!-- fourth template started -->
<div class="containerBox">
    <div id="section_second" class="container"  onmouseout="mouseOutsec();">
        <img align="center" id="imageTemplate_4" src="<?php echo $fullurl; ?>images/template_4.jpg" alt="" width="500px">
    </div>
    <div class="defaulbtn">
        <a href="#" onclick="selectTemplate('4');">
            <?php if($setDefaultTemplate==4){ echo 'Current Template - 4'; }else{ echo 'Set Default Template - 4';} ?>
        </a>
    </div>
 </div>
  <!-- fourth template ended -->
 

</div>
</form>
</div>

<div id="selectDefaultTemplate">Please Wait....</div>

<script>


  
    function selectTemplate(templateId){

        swal({
                title: "Are you sure?",
                text: "Once selected, this template will be applied to all vouchers!",
                icon: "warning",
                buttons: true,
                // dangerMode: false,
                buttons: ["No!", "Yes"],
                })
                .then((selected) => {
                if (selected){
                    $("#selectDefaultTemplate").load('final_frmaction.php?action=selectVoucherTemplates&templateNo='+templateId);
                }
                });
    }

    document.getElementById("section_first").addEventListener('mouseover',function(){
       let isClass = document.querySelector("#section_first").classList.contains('viewFullScreen');
       if(isClass==true){
        document.querySelector("#section_first").classList.add('con_second');
       }else{
        document.querySelector("#section_first").classList.add('con_first');
       }
    });

    function mouseOut(){
        document.querySelector("#section_first").classList.remove('con_second');
      
        document.querySelector("#section_first").classList.remove('con_first');   
    }

    
    document.getElementById("section_first").addEventListener('click', ZoomOut);

    function ZoomOut(){
        document.getElementById("section_first").classList.toggle("viewFullScreen");
        document.getElementById("imageTemplate_1").classList.toggle("img_stycl");
        document.getElementById("imageTemplate_1").removeAttribute("height");

    }


    // second template code

    document.getElementById("section_second").addEventListener('mouseover',function(){
       let isClass = document.querySelector("#section_second").classList.contains('viewFullScreen');
       if(isClass==true){
        document.querySelector("#section_second").classList.add('con_second');
       }else{
        document.querySelector("#section_second").classList.add('con_first');
       }
    });
    
    document.getElementById("section_second").addEventListener('click', ZoomOutsec);

function ZoomOutsec(){
    document.getElementById("section_second").classList.toggle("viewFullScreen");
    // document.getElementById("subSectionsecond").classList.toggle("subContainer");
    document.getElementById("imageTemplate_2").classList.toggle("img_stycl");
}



function mouseOutsec(){
       
        document.querySelector("#section_second").classList.remove('con_second');
        document.querySelector("#section_second").classList.remove('con_first');
       
    }

    // third Template code

    document.getElementById("section_third").addEventListener('mouseover',function(){
       let isClass = document.querySelector("#section_third").classList.contains('viewFullScreen');
       if(isClass==true){
        document.querySelector("#section_third").classList.add('con_second');
       }else{
        document.querySelector("#section_third").classList.add('con_first');
       }
    });
    
    document.getElementById("section_third").addEventListener('click', ZoomOutthird);

function ZoomOutthird(){
    document.getElementById("section_third").classList.toggle("viewFullScreen");
    document.getElementById("section_third").classList.remove("temp_hight");
  
    document.getElementById("imageTemplate_3").classList.toggle("img_stycl");

    document.getElementById("section_third").addEventListener('click', function(){
        document.getElementById("section_third").classList.add("temp_hight");
    });
}





function mouseOutthird(){
       
        document.querySelector("#section_third").classList.remove('con_second');
        document.querySelector("#section_third").classList.remove('con_first');
       
    }


    
</script>
</body>
</html>
