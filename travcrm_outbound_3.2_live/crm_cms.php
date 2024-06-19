<style>
    .cmsouter{
        text-align:center; 
        overflow:hidden;  
    }
    .cmsouter .iconbox {
        display: inline-block;
        text-align: center;
        padding: 10px;
        min-width: 150px;
        width: 19%;
        margin: 15px;
        border: 0px #4caf50 solid;
        border-radius: 5px;
        background-color: #233a49;
        box-shadow: 2px 2px 18px -1px #4caf50;
        color: white;
    }
    .cmsouter .iconbox img{
        height: 60px;
        padding: 10px 0;
        float: left;
    }
    .container_box .rightBox .rightsectionheader {
        background-color: #f8f8f8;
        border-bottom: 1px solid #eee;
        padding: 15px 25px 15px 36px!important;
        font-weight: 500;
        color: #333333;
        font-size: 22px;
        margin-top: 0;
        position: relative!important;
        width: auto;
        z-index: 999;
    }
    .container_box #pagelisterouter .addeditpagebox{
        padding: 0px!important;
    }
    .container_box .rightBox .headingm {
        text-align: left!important;
        margin: 0!important;
        padding:0!important;
    }
    .container_box .rightBox #topheadingmain a img{
        margin-right: 15px!important;
        margin-bottom: -3px!important;
        margin-left: 25px!important;
    }
    #pagelisterouter{
        padding-left: 0!important;
        margin-left: 25px;
        padding-top: 25px;
    }
    .cmsouter .iconbox:hover{ 
        background-color:#fcffe1;
    }
    .cmsouter .iconbox:hover .text{
        color:#0066CC; 
    }
    .cmsouter .text{
        margin-top:10px;
        font-size:16px;
        text-align:right;
        padding-right: 15px;
        color:#ffffff;
        text-decoration:none;
    }
    .container_box{
        padding-top: 56px;
        width: 100%;
        display: block;
        overflow: hidden;
    }
    .container_box .leftBox{
        float: left;
        width: 20%;
        display: inline-block;
        height: 100%;
        overflow: hidden;
        margin-left: -5px;
        border-right: 5px solid #4caf50;

    }
    .container_box .leftBox .iconbox{
        text-align: left;
        padding: 6px 10px 8px 35px;
        min-width: 100%;
        width: 100%;
        border-bottom: 2px #c5bfbf solid;
        border-radius: 0px;
        background-color: #233a49;
        display: table;
    }
    .container_box .leftBox .iconbox .text{
        display: inline-flex;
        vertical-align: middle;
        padding-left: 15px;
        color: white;
        font-size: 14px;
        font-family: 'Roboto', sans-serif;
    }
    .container_box .leftBox .iconbox img{
        height: auto;
        width: 30px;
        display: inline-flex;
        vertical-align: middle;
    }
    .container_box .leftBox .iconbox:hover{ 
        background-color:#ffffff;
    }
    .container_box .leftBox .iconbox:hover .text{
        color: #233a49;
        font-weight: 600;
    }
    .container_box .rightBox{
        float: right;
        display: inline-block;
        width: 80%;
    }
    .container_box  .cms_title{
        margin: 0 0px;
        text-align: left;
        padding: 15px;
        padding-left: 3%;
        font-size: 25px;
        color: #233a49;
        text-shadow: 1px 1px 2px white;
        box-shadow: 1px 1px 13px -3px #4caf50;
        background-color: #f2f2f287;
        margin-bottom: 15px;
    }
    .ExploreLogo{
        background-color: #233a49!important;
        margin-bottom: 0px!important;
        padding: 12px!important;
        padding-left: 8%!important;
    }
    .container_box .cmsouter #pagelisterouter{
        padding: 3%!important;
        padding-top: 0%!important;
        margin: 0!important;
    }
.style1 {color: #f41f06}
</style>
<?php 
$datef=date("YmdHis");
if ($_REQUEST['module'] == 'cms' ) {
?> 
<div class="container_box">
    <div class="leftBox">
        <h3 class="cms_title ExploreLogo"><img src="images/cms-icon.png" style="width: 105px;"></h3>
        <a href="showpage.crm?module=cms"><div class="iconbox"><img src="images/dashboard-icon.png" /><div class="text">Dashboard</div></div></a>
        <a href="showpage.crm?module=cms&page=cmspackagebuilder"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Package Builder</div></div></a>

        <a href="showpage.crm?module=cms&page=Destbanner"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Destination</div></div></a>

        <a href="showpage.crm?module=cms&page=hotdeal"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Hot Deals</div></div></a>
        
        
        <a href="showpage.crm?module=cms&page=banner"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Home Banner</div></div></a>
        <a href="showpage.crm?module=cms&page=core_values"><div class="iconbox"><img src="images/cms-social.png" /><div class="text">Our Core Values</div></div></a>
        <a href="showpage.crm?module=cms&page=about"><div class="iconbox"><img src="images/aboutcmsicon.png" /><div class="text">About Us</div></div></a>
        <a href="showpage.crm?module=cms&page=ourteam"><div class="iconbox"><img src="images/user_group.png" /><div class="text">Our Team</div></div></a>
        <a href="showpage.crm?module=cms&page=clients"><div class="iconbox"><img src="images/cms-clients.png" /><div class="text">Our Partners</div></div></a>
        <a href="showpage.crm?module=cms&page=awards"><div class="iconbox"><img src="images/cms-award.png" /><div class="text">Awards & Recog.</div></div></a>
        <a href="showpage.crm?module=cms&page=client_testimonials"><div class="iconbox"><img src="images/cms-msg.png" /><div class="text">Client Testimonials</div></div></a>
        <a href="showpage.crm?module=cms&page=blog"><div class="iconbox"><img src="images/blogcmsicon.png" /><div class="text">News/Articles</div></div></a>
        <a href="showpage.crm?module=cms&page=review"><div class="iconbox"><img src="images/cms-msg.png" /><div class="text">Manage Reviews</div></div></a>
        <a href="showpage.crm?module=cms&page=mice"><div class="iconbox"><img src="images/cms-mice.png" /><div class="text">MICE</div></div></a>
        <a href="showpage.crm?module=cms&page=social"><div class="iconbox"><img src="images/cms-social.png" /><div class="text">Contact Detail</div></div></a>
        <a href="showpage.crm?module=cms&page=otheroffices"><div class="iconbox"><img src="images/cms-offices.png" /><div class="text">Our offices</div></div></a>
        <a href="showpage.crm?module=cms&page=cont_enquiry"><div class="iconbox"><img src="images/cms-contactenq.png" /><div class="text">Contact Enquiries</div></div></a>
        <a href="showpage.crm?module=cms&page=hotel_enquiry"><div class="iconbox"><img src="images/cms-hotel-enq.png" /><div class="text">Hotel Enquiries</div></div></a>
        <a href="showpage.crm?module=cms&page=pack_enquiry"><div class="iconbox"><img src="images/cms-pack-enq.png" /><div class="text">Package Enquiries</div></div></a>
        <a href="showpage.crm?module=cms&page=subscribers"><div class="iconbox"><img src="images/cms-subscribers.png" /><div class="text">Subscribers</div></div></a>
        <a href="showpage.crm?module=cms&page=users"><div class="iconbox"><img src="images/usercmsicon.png" /><div class="text">Registered User</div></div></a>
        <a href="showpage.crm?module=cms&page=privacypolicy"><div class="iconbox"><img src="images/termscmsicon.png" /><div class="text">Privacy/Terms</div></div></a>
        <a href="showpage.crm?module=cms&page=other_info"><div class="iconbox"><img src="images/cms-pack-enq.png" /><div class="text">Other Information</div></div></a>
        <!-- <a href="showpage.crm?module=cms&page=gallery"><div class="iconbox"><img src="images/gallerycmsicon.png" /><div class="text">Manage Gallery</div></div></a> -->
        <!-- <a href="showpage.crm?module=cms&page=ourvideo"><div class="iconbox"><img src="images/ourvideo.png" /><div class="text">Videos</div></div></a> -->
    </div>
    <div class="rightBox cmsouter">
        <?php 
        if($_REQUEST['page']=='about'){ include('cms_about.php'); } 
        else if($_REQUEST['page']=='ourteam'){ include('cms_ourteam.php'); } //info listing
        else if($_REQUEST['page']=='our_team'){ include('cms_our_team.php'); } //edit infomation
        else if($_REQUEST['page']=='social'){ include('cms_social.php'); }
        else if($_REQUEST['page']=='otheroffices'){ include('cms_otheroffices.php'); } //info listing
        else if($_REQUEST['page']=='other_offices'){ include('cms_other_offices.php'); } //edit infomation
        // <!-- contact enquiry -->
        else if($_REQUEST['page']=='cont_enquiry'){ include('cms_cont_enquiry.php'); } 
        else if($_REQUEST['page']=='view_cont_enquiry'){ include('cms_view_cont_enquiry.php'); }
        // <!-- hotel enquiry -->
        else if($_REQUEST['page']=='hotel_enquiry'){ include('cms_hotel_enquiry.php'); } 
        else if($_REQUEST['page']=='view_hotel_enquiry'){ include('cms_view_hotel_enquiry.php'); }
        // <!-- package enquiry -->
        else if($_REQUEST['page']=='pack_enquiry'){ include('cms_pack_enquiry.php'); } 
        else if($_REQUEST['page']=='view_pack_enquiry'){ include('cms_view_pack_enquiry.php'); }
        // <!-- subscribers enquiry -->
        else if($_REQUEST['page']=='subscribers'){ include('cms_subscribers.php'); } 
        else if($_REQUEST['page']=='gallery'){ include('cms_gallery.php'); } 
        else if($_REQUEST['page']=='add-gallery'){ include('cms_add_gallery.php'); } 
        else if($_REQUEST['page']=='add-images'){ include('cms_add_images.php'); } 
        else if($_REQUEST['page']=='blog'){ include('cms_blog.php'); } 
        else if($_REQUEST['page']=='add-blog'){ include('cms_add_blog.php'); } 
        else if($_REQUEST['page']=='blog-comment'){ include('cms_blog_comment.php'); } 
        else if($_REQUEST['page']=='banner'){ include('cms_banner.php'); } 
        else if($_REQUEST['page']=='Destbanner'){ include('cms_Destbanner.php'); }
        

        else if($_REQUEST['page']=='hotdeal'){ include('cms_hoteDeals.php'); }
        
        else if($_REQUEST['page']=='clients'){ include('cms_clients.php'); } 
        else if($_REQUEST['page']=='awards'){ include('cms_awards.php'); } 
        else if($_REQUEST['page']=='review'){ include('cms_review.php'); } 
        else if($_REQUEST['page']=='client_testimonials'){ include('cms_client_testimonials.php'); } 
        else if($_REQUEST['page']=='review_comment'){ include('cms_review_comment.php'); }
        // <!-- <?php if($_REQUEST['page']=='view-review'){ include('cms_view_review.php'); } -->
        else if($_REQUEST['page']=='add-review'){ include('cms_add_review.php'); } 
        else if($_REQUEST['page']=='users'){ include('cms_users.php'); } 
        else if($_REQUEST['page']=='view-users'){ include('cms_view_users.php'); } 
        else if($_REQUEST['page']=='users-wishlist'){ include('cms_users_wishlist.php'); } 
        else if($_REQUEST['page']=='users-booklist'){ include('cms_users_booklist.php'); } 
        else if($_REQUEST['page']=='privacypolicy'){ include('cms_privacypolicy.php'); }
        else if($_REQUEST['page']=='other_info'){ include('cms_other_info.php'); }
        else if($_REQUEST['page']=='mice'){ include('cms_mice.php'); }
        else if($_REQUEST['page']=='cmspackagebuilder'){ include('cmspackagebuilder.php'); }
        else if($_REQUEST['page']=='addcmspackagebuilder'){ include('addcmspackagebuilder.php'); }
        else if($_REQUEST['page']=='core_values'){ include('cms_core_values.php'); }
        // <!-- <?php if($_REQUEST['page']=='ourvideo'){ include('cms_ourvideo.php'); }
        else { ?>
            <h3 class="cms_title">CMS Dashboard</h3>
            <div style="display:none;">
            <a href="showpage.crm?module=packagebuilder">
                <div class="iconbox">
                    <img src="images/package_icon.png" />
                    <div class="text">Domestic <span style="color: #f41f06;">14 </span></div>
                    <div class="text">International <span style="color: #f41f06;">55 </span></div>
                </div>
            </a>
            
                <div class="iconbox">
                    <a href="showpage.crm?module=packagebuilder"><img src="images/expired_icon.png" />
                    </a><div class="text"><a href="showpage.crm?module=packagebuilder"><span style="color: #f41f06;">52 </span>Package Expire </a></div>
                    <div class="text"><a href="showpage.crm?module=packagebuilder"> on<span class="style1"> <?php echo date('F'); ?> 2019 </span></a></div>
                </div>
            
            <a href="showpage.crm?module=packagebuilder">
                <div class="iconbox">
                    <img src="images/enquiry_icon.png" />
                    <div class="text">Package Enq. <span style="color: #f41f06;"> 62 </span></div>
                    <div class="text">Contact Enq. <span style="color: #f41f06;"> 70 </span></div>
                </div>
            </a>
            <a href="showpage.crm?module=packagebuilder">
                <div class="iconbox">
                    <img src="images/cms-subscribers.png" />
                    <div class="text">Regis. User <span style="color: #f41f06;"> 12 </span></div>
                    <div class="text">Subscribers <span style="color: #f41f06;"> 120 </span></div>
                </div>
            </a>
           <!--  <a href="showpage.crm?module=packagebuilder">
                <div class="iconbox">
                    <img src="images/payment_icon.png" />
                    <div class="text">Supplier : <span style="color: #f41f06;"> 52000/- </span></div>
                    <div class="text">Client : <span style="color: #f41f06;">150000/- </span></div>
                </div>
            </a>
 -->

            </div>
            <div class="cmslistBox">
                <div class="leftlistBox">

                </div>
                
                <div class="rightlistBox">

                </div>
            </div>

            <style type="text/css">
                .cmslistBox{
                    display: block;
                    position: relative;
                    width: 100%;
                    overflow: hidden;
                    height: 300px;
                    padding: 30px;
                }
                .leftlistBox{
                    position: relative;
                    display: inline-block;
                    float: left;
                    width: 46%;
                }
                .rightlistBox{
                    position: relative;
                    display: inline-block;
                    float: left;
                    width: 46%;
                }
                .cmslistBox_dsdsds{

                }
            </style>

            <!-- <a href="showpage.crm?module=cms&page=about"><div class="iconbox"><img src="images/aboutcmsicon.png" /><div class="text">About Us</div></div></a>   
            <a href="showpage.crm?module=cms&page=banner"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Home Banner</div></div></a>
            <a href="showpage.crm?module=cms&page=core_values"><div class="iconbox"><img src="images/cms-social.png" /><div class="text">Our Core Values</div></div></a>
            <a href="showpage.crm?module=cms&page=ourteam"><div class="iconbox"><img src="images/user_group.png" /><div class="text">Our Team</div></div></a>
            <a href="showpage.crm?module=cms&page=clients"><div class="iconbox"><img src="images/cms-clients.png" /><div class="text">Our Partners</div></div></a>
            <a href="showpage.crm?module=cms&page=awards"><div class="iconbox"><img src="images/cms-award.png" /><div class="text">Awards & Recog.</div></div></a>
            <a href="showpage.crm?module=cms&page=client_testimonials"><div class="iconbox"><img src="images/cms-msg.png"/><div class="text">Client Testimonials</div></div></a>
            <a href="showpage.crm?module=cms&page=blog"><div class="iconbox"><img src="images/blogcmsicon.png" /><div class="text">News/Articles</div></div></a>
            <a href="showpage.crm?module=cms&page=review"><div class="iconbox"><img src="images/cms-msg.png" /><div class="text">Manage Reviews</div></div></a>
            <a href="showpage.crm?module=cms&page=mice"><div class="iconbox"><img src="images/cms-mice.png" /><div class="text">MICE</div></div></a>
            <a href="showpage.crm?module=cms&page=social"><div class="iconbox"><img src="images/cms-social.png" /><div class="text">Contact Detail</div></div></a>
            <a href="showpage.crm?module=cms&page=otheroffices"><div class="iconbox"><img src="images/cms-offices.png" /><div class="text">Our offices</div></div></a>
            <a href="showpage.crm?module=cms&page=cont_enquiry"><div class="iconbox"><img src="images/cms-contactenq.png" /><div class="text">Contact Enquiries</div></div></a>
            <a href="showpage.crm?module=cms&page=hotel_enquiry"><div class="iconbox"><img src="images/cms-hotel-enq.png" /><div class="text">Hotel Enquiries</div></div></a>
            <a href="showpage.crm?module=cms&page=pack_enquiry"><div class="iconbox"><img src="images/cms-pack-enq.png" /><div class="text">Package Enquiries</div></div></a>
            <a href="showpage.crm?module=cms&page=subscribers"><div class="iconbox"><img src="images/cms-subscribers.png" /><div class="text">Subscribers</div></div></a>
            <a href="showpage.crm?module=cms&page=users"><div class="iconbox"><img src="images/usercmsicon.png" /><div class="text">Registered User</div></div></a>
            <a href="showpage.crm?module=cms&page=privacypolicy"><div class="iconbox"><img src="images/termscmsicon.png" /><div class="text">Privacy/Terms</div></div></a>
            <a href="showpage.crm?module=cms&page=other_info"><div class="iconbox"><img src="images/cms-pack-enq.png" /><div class="text">Other Information</div></div></a> -->
            <!-- <a href="showpage.crm?module=cms&page=gallery"><div class="iconbox"><img src="images/gallerycmsicon.png" /><div class="text">Manage Gallery</div></div></a> -->
            <!-- <a href="showpage.crm?module=cms&page=ourvideo"><div class="iconbox"><img src="images/ourvideo.png" /><div class="text">Videos</div></div></a> -->
            <?php 
        }
        ?>
    </div>
</div>
<?php 
} 
?>
