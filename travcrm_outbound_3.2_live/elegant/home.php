<?php 
$page='home';
include "header.php"; 
?>
<style>
     @media only screen and (max-width: 600px) {
        .center-mob-sec{
            height: 241px;
            margin-top: 200px;
        }
        .extra-space{
            display: none;
        }
        .squre-top{
            display: none;
        }
     }

    .anim-slider{background-color: #fff;}
    .anim-slide{opacity: 0;}
    .anim-slide-this{opacity: 1;}
   
    h1#looks{background-color:#fff;color:#34495e;}
    h1#amazing{background-color:#34495e;color:#fff;margin: 0px -5px;}
    h1#place{background-color:#3498db;color:#fff;}
 
    h1.T{top:20%;left:42%;}
    h1.r{top:20%;left: 44%;}
    h1.a{top:20%;left: 46%;}
    h1.v{top:20%;left: 48%;}
    h1.CRM{top:20%;left: 50%;}
    h1.mark{
        top:20%;
        left: 56%;
        transform: rotateY(0deg) rotate(0deg);
        transition: transform 2s;
    }
    .rotate45{ 
        transform: rotateY(0deg) rotate(-45deg)!important;
    }

    div#demo{text-align: center;}
    div#demo>a{display:inline-block;text-decoration: none;}
    div#demo>a>h4{padding: 5px 8px;margin: 20px;background-color: #225A86;color: #fff;box-shadow:inset 0 -2px 0 rgba(0,0,0,0.15);}
    p#credits{z-index:-1;position: fixed;bottom: 0px;width: 100%;text-align: center;font-size: 14px;}
    p#credits>a{font-weight: bold;color: #999;text-decoration: none;}
    img#github-logo{z-index:-1;position: fixed;bottom: -20px;right: 2%;opacity: 0.4;}
    .anim-slider{
        height: auto;
        min-height: 635px;
    }

    .wrapper{
        <?php 
        $rsb03='';
        $rsb03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="1" ) and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="800x300" order by id desc ) order by id desc');
        $resListingb3=mysqli_fetch_array($rsb03);
        $proposalPhotob3 = geDocFileSrc($resListingb3['fileId']);
        if($resListingb3['fileId']!=''){ ?>
            background-image: url("<?php echo $fullurl.$proposalPhotob3; ?>"); /* The image used */
        <?php }else{ ?> 
            background-image: url("<?php echo $fullurl;?>elegant/images/default1.jpg"); /* The image used */
        <?php } ?>
        background-color: #cccccc; /* Used if the image is unavailable */
        height: 500px; /* You must set a specified height */
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover; /* Resize the background image to cover the entire container */
    }
 </style>
<div class="wrapper">
    <div id="entrance" class="informationinoverlay bottom custom_overlay center-mob-sec">
        <div class="top-half">
            <div id="logo-header" class="top  no-logo extra-space" style="background-color:rgba(255,255,255,0.8)">
            </div>
            <div class="headline-info ">
                <div class="name">
                    <h1 class="inverted"><?php echo $quotationName; ?></h1>
                </div>
                <div class="duration ">
                    <p class="inverted"><?php echo $quotationNights; ?> Nights</p>
                </div>
            </div>
        </div>
        <div class="detail-info ">
            <div class="text-detail">
                <div class="destinations">
                    <p class="inverted"><?php echo $Destinations; ?></p>
                </div>
                <div class="enter-button"> 
                    <a class="custom_cta desktop" href="<?php echo $fullurl; ?>Elegant/Overview/<?php echo $_REQUEST['id']; ?>"><span>
                    Enter</span></a>
                    <a class="custom_cta mobile" href="<?php echo $fullurl; ?>Elegant/Overview/<?php echo $_REQUEST['id']; ?>"><span>
                    Enter</span></a>
                </div>
            </div>
        </div>
    </div> 
</div>
 <?php 
include "footer.php"; 
?>
