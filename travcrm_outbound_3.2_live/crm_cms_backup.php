<style>
.cmsouter{padding:30px; text-align:center; overflow:hidden;     padding-top: 70px;}
.cmsouter .iconbox {
display: inline-block;
text-align: center;
padding: 30px 15px;
width: 15%;
margin:36px;
border: 1px #ebeaea solid;
border-radius: 4px;
background-color: #f9f9f9;
box-shadow: 2px 2px 4px #25252514;
}
.cmsouter img{height:64px;}
.cmsouter .iconbox:hover{ background-color:#fcffe1;}
.cmsouter .text{margin-top:10px; font-size:16px; text-align:center; color:#0066CC; text-decoration:none;}
</style>
<?php 
    $datef=date("YmdHis");
    if($_REQUEST['page']==''){ ?>
        <div class="cmsouter">
            <a href="showpage.crm?module=cms&page=about"><div class="iconbox"><img src="images/aboutcmsicon.png" /><div class="text">About Us</div></div></a>
            <a href="showpage.crm?module=cms&page=contact"><div class="iconbox"><img src="images/contactcmsicon.png" /><div class="text">Contact Us</div></div></a>
            <a href="showpage.crm?module=cms&page=gallery"><div class="iconbox"><img src="images/gallerycmsicon.png" /><div class="text">Manage Gallery</div></div></a>
            <a href="showpage.crm?module=cms&page=blog"><div class="iconbox"><img src="images/blogcmsicon.png" /><div class="text">Manage Blog</div></div></a>
            <a href="showpage.crm?module=cms&page=banner"><div class="iconbox"><img src="images/bannercmsicon.png" /><div class="text">Manage Banner</div></div></a>
            <a href="showpage.crm?module=cms&page=review"><div class="iconbox"><img src="images/reviewcmsicon.png" /><div class="text">Manage Review</div></div></a>
            <a href="showpage.crm?module=cms&page=users"><div class="iconbox"><img src="images/usercmsicon.png" /><div class="text">Registered User</div></div></a>
            <a href="showpage.crm?module=cms&page=privacypolicy"><div class="iconbox"><img src="images/termscmsicon.png" /><div class="text">Privacy/Terms</div></div></a>
            <!--<a href="showpage.crm?module=cms&page=termsconditions"><div class="iconbox"><div class="text">Terms & Conditions</div></div></a>-->
        </div>
    <?php } ?>
        <?php if($_REQUEST['page']=='about'){include('cms_about.php');}?>
        <?php if($_REQUEST['page']=='contact'){include('cms_contact.php');}?>
        <?php if($_REQUEST['page']=='gallery'){include('cms_gallery.php');}?>
        <?php if($_REQUEST['page']=='add-gallery'){include('cms_add_gallery.php');}?>
        <?php if($_REQUEST['page']=='add-images'){include('cms_add_images.php');}?>
        <?php if($_REQUEST['page']=='blog'){include('cms_blog.php');}?>
        <?php if($_REQUEST['page']=='add-blog'){include('cms_add_blog.php');}?>
        <?php if($_REQUEST['page']=='blog-comment'){include('cms_blog_comment.php');}?>
        <?php if($_REQUEST['page']=='banner'){include('cms_banner.php');}?>
        <?php if($_REQUEST['page']=='review'){include('cms_review.php');}?>
        <?php if($_REQUEST['page']=='view-review'){include('cms_view_review.php');}?>
        <!--<?php if($_REQUEST['page']=='add-review'){include('cms_add_review.php');}?>-->
        <?php if($_REQUEST['page']=='users'){include('cms_users.php');}?>
        <?php if($_REQUEST['page']=='view-users'){include('cms_view_users.php');}?>
        <?php if($_REQUEST['page']=='users-wishlist'){include('cms_users_wishlist.php');}?>
        <?php if($_REQUEST['page']=='users-booklist'){include('cms_users_booklist.php');}?>
        <?php if($_REQUEST['page']=='privacypolicy'){include('cms_privacypolicy.php');}?>
        <?php if($_REQUEST['page']=='termsconditions'){include('cms_termsconditions.php');}?>