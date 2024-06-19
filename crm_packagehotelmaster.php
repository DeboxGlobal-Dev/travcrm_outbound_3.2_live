<?php include 'tableSorting.php'; ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['supplier']=='' && $_REQUEST['page']=='addGallery' && $_REQUEST['hotelId']!='' ) {
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td width="91%" align="left" valign="top">
        <form id="listform" name="listform" method="get">
            <div class="rightsectionheader">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="headingm" style="margin-left:10px;">
                                    <a name="addnewuserbtn"
                                        href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input
                                    type="button" name="Submit22" value="Back" class="whitembutton"> </a>
                                    <span id="topheadingmain"><?php 
                                    if($_REQUEST['hotelId']!=''){  
                                        $hotelQuery=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.($_REQUEST['hotelId']).'"'); 
                                        $hotelData2=mysqli_fetch_array($hotelQuery);
                                        echo $hotelData2['hotelName'];
                                    }
                                    ?></span>
                                    <div id="deactivatebtn" style="display:none;left: 90px;">
                                        <?php if($deletepermission==1){ ?>
                                        <input name="deactivate" type="button" class="redmbutton" id="deactivate"
                                        value="Deactivate"
                                        onclick="masters_alertspopupopen('action=deleteGalleryPhoto&name=Hotel','600px','auto');" />
                                        <?php } ?>
                                    </div>
                            </div>
                        </td>
                        <td align="right">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td></td>
                                        <?php if($addpermission==1){ ?>
                                        <td style="padding-right:20px;">
                                            <a href=""></a>
                                        </td>
                                        <?php } ?>
                                        <?php if($importpermission==1){ ?>
                                        <input type="button" name="Submit" value="Import" class="whitembutton"
                                        style="display: none;" />
                                        <?php } ?>
                                        <td>
                                        </td>
                                        <!-- load alert box for destination -->
                                        <?php if($addpermission==1){ ?>
                                        <td style="padding-right:20px;">
                                            <input name="addnewuserbtn" type="button" class="bluembutton"
                                            id="addnewuserbtn" value="+ Add Images"
                                            onclick="masters_alertspopupopen('action=addeditGallery&galleryType=hotel&parentId=<?php echo $_REQUEST['hotelId'];?>&module=<?php echo $_REQUEST['module'];?><?php echo ($_REQUEST['page']!='')? '&page='.$_REQUEST['page']:'';?>','800px','auto');" />
                                        </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="pagelisterouter" style="padding-left:20px;">
                <input name="action" id="action" type="hidden" value="deleteGalleryPhoto" />
                <input name="backpage" id="backpage" type="hidden"
                value="<?php echo $_GET['module'];echo ($_GET['hotelId'] !='')?'&page=addGallery&hotelId='.$_GET['hotelId']:''; ?>" />
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered " id="loadDocFilesList">
                    <thead>
                        <tr>
                            <th width="2%" align="center" valign="middle" class="header">
                                <?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"
                                name="checkedAll" onclick="checkallbox();" /><?php } ?>
                                <label for="checkAll"><span></span>&nbsp;</label>
                            </th>
                            <th width="20%" align="left" class="header">Name </th>
                            <th width="15%" align="left" class="header">Image</th>
                            <th width="20%" align="left" class="header">Created On</th>
                            <th align="left" class="header">Created By</th>
                            <th align="left" class="header">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        $select='*';
                        $where='';
                        $rs='';
                        $wheresearch='';
                        $limit=clean($_GET['records']);
                        
                        $where='where parentId = "'.$_REQUEST['hotelId'].'" and galleryType="hotel" and deleteStatus=0  order by id desc';
                        $page=$_GET['page'];
                        
                        $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
                        $rs=GetRecordList($select,'imageGallery',$where,$limit,$page,$targetpage);
                        $totalentry=$rs[1];
                        $paging=$rs[2];
                        while($resultlists=mysqli_fetch_array($rs[0])){
                        ?>
                        <tr>
                            <td align="center" valign="middle"><?php if($editpermission==1){ ?><input
                                type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"
                                value="<?php echo encode($resultlists['id']); ?>" />
                                <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>
                            </td>
                            <td align="left">
                                <?php echo geDocFileName($resultlists['fileId']); ?>
                            </td>
                            <td align="left">
                                <?php 
                                if($resultlists['fileId']!='0'){ ?>
                                <a href="<?php echo geDocFileSrc($resultlists['fileId']); ?>" target="_blank" >
                                <img src="<?php echo geDocFileSrc($resultlists['fileId']); ?>" width="75" height="58"/>
                                </a>
                                <?php }else{
                                echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>";
                                }
                                ?>
                            </td>
                            <td valign="middle" align="left" ><?php if($resultlists['dateAdded']!=0){ echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat); } else{ echo '--'; }?></td>
                            <td align="left" ><?php echo getUserName($resultlists['addedBy']); ?></td>
                            <td align="left" ><?php echo ($resultlists['deletestatus']==1)?'Inactive':'Active'; ?></td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                <?php if($no==1){ ?>
                <div class="norec">No <?php echo $pageName; ?></div>
                <?php } ?>
                <script type="text/javascript">
                    window.setInterval(function() {
                        checked = $("#loadDocFilesList td input[type=checkbox]:checked").length;
                        if (!checked) {
                            $("#deactivatebtn").hide();
                            $("#topheadingmain").show();
                        } else {
                            $("#deactivatebtn").show();
                            $("#topheadingmain").hide();
                        }
                    }, 100);
                    $(document).ready(function() {
                        $('#loadDocFilesList').DataTable({
                        "paging": false,
                        "ordering": true,
                        "info": false,
                        "searching": true,
                        "order": [
                            [3, 'desc']
                        ]
                        });
                    });
                </script>
                <div class="pagingdiv">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
                                            <td><select name="records" id="records" onchange="this.form.submit();"
                                                class="lightgrayfield">
                                                <option value="25" <?php if($_GET['records']=='25'){ ?>
                                                selected="selected" <?php } ?>>25 Records Per Page</option>
                                                <option value="50" <?php if($_GET['records']=='50'){ ?>
                                                selected="selected" <?php } ?>>50 Records Per Page</option>
                                                <option value="100" <?php if($_GET['records']=='100'){ ?>
                                                selected="selected" <?php } ?>>100 Records Per Page</option>
                                                <option value="200" <?php if($_GET['records']=='200'){ ?>
                                                selected="selected" <?php } ?>>200 Records Per Page</option>
                                                <option value="300" <?php if($_GET['records']=='300'){ ?>
                                                selected="selected" <?php } ?>>300 Records Per Page</option>
                                            </select></td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="right">
                                    <div class="pagingnumbers"><?php echo $paging; ?></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </td>
</tr>
</table>
<?php
} else { ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td width="91%" align="left" valign="top">
        <form id="listform" name="listform" method="get">
            <div class="rightsectionheader">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="7%" align="left">
                            <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster"><input type="button"
                            name="Submit22" value="Back" class="whitembutton"> </a>
                        </td>
                        
                        <td>
                            <div class="headingm p-name" style="margin-left:30px;"><span
                            id="topheadingmain" style="font-size: 18px; padding-left: 20px;"><?php echo $pageName; ?></span>
                            <div id="deactivatebtn" style="display:none;">
                                <?php if($deletepermission==1){ ?>
                                <!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
                                <?php } ?>
                            </div>
                            
                            </div>
                        </td>
                        <!-- new added hotels options related code (all hotels  destination category stars) started -->
                        <!-- <td width="5%"><div class="griddiv hotal-name-des"> 
                            <span style="font-size: 15px;margin-left: 37px;">&nbsp;Hotels</span>
                            <label class="h-name-des">
                               
                            <select id="hotelName" name="hotelName" class="select2 gridfield select-op-des" autocomplete="off">
                            <option value="">All Hotels</option>
                                    <?php  
                                        $hotelNameDataq=GetPageRecord('id,hotelName',_PACKAGE_BUILDER_HOTEL_MASTER_,' 1 and hotelName!="" and status=1 and id in ( select serviceid from '._DMC_ROOM_TARIFF_MASTER_.' ) order by hotelName'); 
                                        while($hotelNameData=mysqli_fetch_array($hotelNameDataq)){  
                                        ?>
                                <option value="<?php echo ($hotelNameData['id']); ?>" <?php if($_REQUEST['hotelName']==$hotelNameData['id']){ ?> selected="selected" <?php } ?>><?php echo ($hotelNameData['hotelName']); ?></option>
                                <?php } ?>
                            </select> 
                            </label>
                            </div>
                        </td>
                        <td width="5%"><div class="griddiv dest-name-des">
                        <span style="font-size: 15px;margin-left: 7px;">&nbsp;Destinations</span>
                            <label class="h-dest-des">
                            <select id="destinationId" name="destinationId" class="select2 gridfield select-op-des" autocomplete="off">
                               
                                <?php 
                            $select=''; 
                            $where=''; 
                            $rs='';  
                            $select='*';    
                            $where=' 1 and deletestatus = 0 order by name asc';  
                            $rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
                            while($resListing=mysqli_fetch_array($rs)){  
                            ?>
                                <option value="<?php echo ($resListing['name']); ?>" <?php if($_REQUEST['destinationId']==$resListing['name']){ ?> selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
                                <?php } ?>
                            </select>
                            </label>
                            </div>
                        </td> -->
                        <!-- <td width="5%"><div class="griddiv star-sec-des">
                        <span style="font-size: 15px;margin-left: -2px;">&nbsp;Category</span>
                            <label>
                            <select id="starRating" name="starRating" class="select2 gridfield select-op-des">
                                
                                <?php
                                                    $hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'  deletestatus=0 and status=1  order by hotelCategory asc');
                                                    while($hotelCategoryData=mysqli_fetch_array($hotelCatQuery)){
                                                    ?>
                                <option value="<?php echo strip($hotelCategoryData['id']); ?>" <?php if($_REQUEST['starRating']==$hotelCategoryData['id']){ ?> selected="selected" <?php } ?>><?php echo strip($hotelCategoryData['hotelCategory']); ?> Star</option>
                                <?php } ?>
                            </select>
                            </label>
                            </div>
                        </td> -->

                        <!-- new added hotels options related code ended -->
                    
                    <td align="right">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                            <tr>
                                <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword"
                                    style="width:150px;" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword']; } ?>" size="100" maxlength="100"
                                placeholder="Keyword"></td>
                                <td><input type="submit" name="Submit" value="Search" class="searchbtnmain">
                            </td>
                            <td><a 
                            <?php if($hotelImportFormatType == 2){ ?>
                                href="<?php echo $fullurl; ?>travrmimports/hotel-import-format-d.xls?t=<?php echo time(); ?>"
                            <?php }else{ ?>
                                href="<?php echo $fullurl; ?>travrmimports/hotel-import-format-i.xls?t=<?php echo time(); ?>"
                            <?php } ?>
                                class="bluembutton"
                                style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i
                            class="fa fa-download" aria-hidden="true"></i> Download Format</a>
                        </td>
                        <td>
                            <div class="bluembutton" id="importbutton"><i class="fa fa-upload"
                            aria-hidden="true"></i> Import Excel</div>
                        </td>

                        <td><a href="#" onclick="$('#downloadMainData').toggle()" class="bluembutton ">
                        <i class="fa fa-download" aria-hidden="true"></i> Download Data</a>

                        <div class="downloadMainData" id="downloadMainData" style="display: none;">
                            <div class="donwlArrowBox"> </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="hotelChain" id="hotelChain" class="topsearchfiledmainselect" style="width:150px; ">
                                            <option value="">All</option>
                                                <?php
                                                $rs='';
                                                $rs=GetPageRecord('*','chainhotelmaster',' deletestatus=0 and status=1 and name!="" order by name asc');
                                                while($hotelChainD=mysqli_fetch_array($rs)){
                                                // if($hotelChainD['name'] == "None"){ $selected = "selected"; }else{ $selected = ""; }
                                                ?>
                                                <option value="<?php echo strip($hotelChainD['id']); ?>" <?php echo $selected; ?>><?php echo strip($hotelChainD['name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="hotelName" type="text"
                                            class="topsearchfiledmain" id="hotelName"
                                        style="width:170px;" value="" placeholder="Enter Hotel Name" ></td>
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="withRate" id="withRate" class="topsearchfiledmainselect" style="width:120px; ">
                                                <option value="1" >With Rate</option>
                                                <option value="2" >Without Rate</option>
                                            </select>
                                        </td>
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="seasonName" id="seasonName" class="topsearchfiledmainselect" style="width:120px; ">
                                                <option value="" >All Season</option>
                                                <option value="1" >Summer</option>
                                                <option value="2" >Winter</option>
                                            </select>
                                        </td>
                                        <td style="padding:0px 0px 0px 5px;">
                                            <?php
                                            $starting_year  = 2020;
                                            $ending_year    = 2040;
                                            for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                            if($starting_year == date('Y')){ $selected = "selected"; }else{ $selected = ""; }
                                            $years[] = '<option value="'.$starting_year.'" '.$selected.'>'.$starting_year.'</option>';
                                            }
                                            ?>
                                            <select name="seasonYear" id="seasonYear" class="topsearchfiledmainselect" style="width:130px; ">
                                                <?php echo implode("\n\r", $years);  ?>
                                            </select>
                                        </td>
                                        <td style="padding:0px 0px 0px 5px;">
                                            <select name="hotelDestination" id="hotelDestination" class="topsearchfiledmainselect" style="width:150px; ">
                                                <option value="" > All Destination</option>
                                                <?php
                                                $rs='';
                                                $rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 and name!="" order by name asc');
                                                while($destData=mysqli_fetch_array($rs)){
                                                ?>
                                                <option value="<?php echo strip($destData['name']); ?>" ><?php echo strip($destData['name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="action" id="action" type="hidden" value="downloadHotelData">
                                            <input type="button" name="button" value="Search Records" class="searchbtnmain" onclick="generateHotelData()">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6"><div id="downloadBtn" style="display:none;">
                                            <div id="cntRows"></div>
                                            <!-- <input name="action" id="action" type="hidden" value="downloadHotelData"> -->
                                            <a href="#" target="_blank" id="donwloadLink" class="bluembutton " ><i class="fa fa-download" aria-hidden="true"></i> Click to Download </a>
                                            <!-- <input type="submit" name="Submit" value="Download" class="searchbtnmain"> -->
                                            <div style="display: none;" id="loadHotelData"></div>
                                            <script type="text/javascript">
                                            function generateHotelData(){
                                            var hotelName = $('#hotelName').val();
                                            var hotelChain = $('#hotelChain').val();
                                            var seasonName = $('#seasonName').val();
                                            var seasonYear = $('#seasonYear').val();
                                            var withRate = $('#withRate').val();
                                            var hotelDestination = $('#hotelDestination').val();
                                            $('#loadHotelData').load('downloadHotelData.php?action=searchHotelData&hotelName='+encodeURI(hotelName)+'&hotelChain='+encodeURI(hotelChain)+'&seasonName='+encodeURI(seasonName)+'&seasonYear='+encodeURI(seasonYear)+'&hotelDestination='+encodeURI(hotelDestination)+'&withRate='+encodeURI(withRate));
                                            }
                                            </script>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <style>
                .downloadMainData {
                width: 80%;
                height: auto;
                position: absolute;
                background-color: #f8f8f8;
                border: 1px solid #233a49;
                top: 74px;
                right: 10%;
                padding: 10px;
                }
                #cntRows{
                font-size: 14px;
                padding: 0 0 20px 0;
                } #downloadBtn{
                margin-top: 15px;
                text-align: center;
                border-top: 1px dashed;
                padding: 10px 0;
                }
                .donwlArrowBox{
                width: 20px;
                height: 20px;
                border: 0px;
                border-top: 1px solid #233a49;
                border-left: 1px solid #233a49;
                position: absolute;
                right: 15%;
                top: -12px;
                transform: rotate(
                45deg);
                background-color: #f8f8f8;
                }
                .dropbtn {
                background-color: #67b069;
                color: white;
                padding: 9px;
                font-size: 12px;
                border: none;
                margin-left: 7px;
                border-radius: 13px;
                cursor: pointer;
                }
                .dropdown {
                position: relative;
                display: inline-block;
                float: right;
                cursor: pointer;
                }
                .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
                font-size: 12px;
                right: 0;
                overflow: visible;
                text-align: left;
                width: fit-content;
                }
                .dropdown-content a {
                color: black;
                padding: 10px 26px 10px 10px;
                text-decoration: none;
                display: block;
                float: left;
                text-align: left;
                width: 200px;
                background-color: #FFFFFF;
                border-bottom: 1px solid #cccccc30;
                }
                .dropdown-content a:hover {
                background-color: #ddd;
                }
                .dropdown:hover .dropdown-content {
                display: block;
                overflow: auto;
                height: 200px;
                }
                .dropdown:hover .dropbtn {
                background-color: #3e8e41;
                }

                /* new added hotels options related css */
                .p-name{
                    margin-left: -23px!important;
                }
                .select-op-des{
                    width: 108%!important;
                    height: 35px!important;
                    border-radius: 7px!important;
                    /* text-align: center!important; */
                }

                .hotal-name-des{
                    margin-right: 19px;
                    margin-left: -35px;
                    margin-top: -19px;
                }
                .h-name-des{
                    margin-left: 38px;
                }
                .h-dest-des{
                    margin-left: 13px;
                }
                .dest-name-des{
                    margin-left: 15px;
                    margin-top: -19px;
                    width: 81px;
                }
                .star-sec-des{
                    margin-left: 24px;
                    width: 63px;
                    margin-top: -19px;
                }
                </style>
                <td style="padding-right:20px;">
                    <div class="dropdown">
                        <button class="dropbtn" type="button"><i class="fa fa-bug"
                        aria-hidden="true"></i> View Logs</button>
                        <div class="dropdown-content">
                            <?php
                            $dirname =  'log_hotel/';
                            $images = scandir($dirname);
                            krsort($images);
                            foreach (array_slice($images, 0, 25) as $file) {
                            if (substr($file, -4) == ".log" ) {
                            ?>
                            <a href="<?php echo $fullurl; ?>log_hotel/<?php echo $file; ?>"
                            target="_blank"><?php echo $file; ?></a>
                            <?php
                            }
                            }
                            ?>
                        </div>
                    </div>
                </td>
                <td style="padding-right:20px;"><input name="addnewuserbtn" type="button"
                    class="bluembutton" id="addnewuserbtn" value="+ Add Hotel"
                    onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','1200px','auto');" />
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0"
class="table table-striped table-bordered" id="mainsectiontable">
<thead>
    <tr>
        <th width="10%" align="center" class="header">Hotel Code</th>
        <th width="10%" align="center" class="header">Image</th>
        <th width="9%" align="left" class="header">Hotel&nbsp;Chain</th>
        <th width="17%" align="left" class="header">Hotel&nbsp;Name&nbsp;</th>
        <!--<th align="left" class="header" >GSTN </th>-->
        <th width="11%" align="left" class="header">Destination / Locality</th>
        <th width="12%" align="left" class="header">Contact&nbsp;Person</th>
        <th width="10%" align="left" class="header">Category</th>
        <th width="10%" align="left" class="header">Status</th>
        <th width="9%" align="left" class="header">Room&nbsp;Type</th>
        <th width="10%" align="left" class="header">Gallery</th>
        <th width="12%" align="center" class="header">Rate&nbsp;Sheet</th>
    </tr>
</thead>
<tbody>
    <?php
    $no=1;
    $select='*';
    $where='';
    $rs='';
    $wheresearch='';
    $limit=clean($_GET['records']);
    if($_GET['keyword']!=''){
    $wheresearch=' hotelName like "%'.$_GET['keyword'].'%" or  hotelCity like "%'.$_GET['keyword'].'%" or  hotelAddress like "%'.$_GET['keyword'].'%"  ';
    }else{
    $wheresearch=' hotelName!="" ';
    }
    $where='where '.$wheresearch.' order by id desc';
    $page=$_GET['page'];
    $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&';
    $rs=GetRecordList($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where,$limit,$page,$targetpage);
    $totalentry=$rs[1];
    $paging=$rs[2];

    while($resultlists=mysqli_fetch_array($rs[0])){
        $dateAdded=clean($resultlists['dateAdded']);
        $modifyDate=clean($resultlists['modifyDate']);
        $rsHotel=GetPageRecord('*','chainhotelmaster',' id="'.$resultlists['hotelChain'].'" order by id asc ');
        $hotelData=mysqli_fetch_array($rsHotel);
        $roomTypeArray =  explode(",",$resultlists['roomType']);
        $hotelRoomsType="";
        $cnts=1;
        foreach($roomTypeArray as $tagsName2) {
            $rs3='';
            $rs3=GetPageRecord('*',_ROOM_TYPE_MASTER_,' id="'.$tagsName2.'" and deletestatus=0 order by id desc');
            $resListing3=mysqli_fetch_array($rs3);
            if($resListing3['name']!=''){
                $hotelRoomsType.= $cnts.".".$resListing3['name']."&#10;";
                $cnts++;
            }
        }
        $cp_email=$cp_phone=$cp_primaryvalue=$cp_contactPerson = '';

        $contPQuery=GetPageRecord('*','hotelContactPersonMaster',' corporateId="'.$resultlists['id'].'" order by primaryvalue desc limit 1');
        if(mysqli_num_rows($contPQuery)>0){
            $contactPData=mysqli_fetch_array($contPQuery);
            $cp_email  = $contactPData['email'];
            $cp_phone  = $contactPData['phone'];
            $cp_primaryvalue  = $contactPData['primaryvalue'];
            $cp_contactPerson  = $contactPData['contactPerson'];
        }
        
        // else{
        //     $cp_email  = $resultlists['supplierEmail'];
        //     $cp_phone  = $resultlists['supplierPhone'];
        //     $cp_primaryvalue  = 1;
        //     $cp_contactPerson  = $resultlists['contactPerson'];
            
        //     $cp_rsquery ='email="'.$cp_email.'",phone="'.$cp_phone.'",primaryvalue=1,contactPerson="'.$cp_contactPerson.'"'; 
        //     addlistinggetlastid('hotelContactPersonMaster',$cp_rsquery);

        // }

        $imgQuery = GetPageRecord('*','imageGallery','parentId="'.$resultlists['id'].'" and galleryType="hotel" and fileId in (select id from documentFiles where fileDimension="380x246" and deletestatus="0") order by fileId desc');
        $galleryData = mysqli_fetch_assoc($imgQuery);
       $filePath = geDocFileSrc($galleryData['fileId']);

    ?>
    <tr>
        <td align="center"><?php  echo $serviceCode = makeServiceCode('HT',$resultlists['displayId']);  ?></td>
        <td align="left">
            <?php 
         
            if($galleryData['fileId']!='' && file_exists($filePath)){ ?>
                <img src="<?php echo $fullurl.$filePath; ?>" width="75" height="58" />
            <?php }else{ 
                echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>"; 
            } ?>
        </td>
        <td align="left"><?php echo stripslashes($hotelData['name']); ?></td>
        <td align="left">
            <div class="bluelink"
                onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','1200px','auto');">
            <?php echo stripslashes($resultlists['hotelName']); ?></div>
        </td>
        <!--    <td align="left"><?php echo $resultlists['gstn']; ?></td>
        -->
        <td align="left">
            <?php echo $resultlists['hotelCity']; ?>,&nbsp;<?php echo $resultlists['hotelCountry']; ?>

            <?php echo '<br><br> <b>'.$resultlists['locality'].'</b>'; ?>
        </td>
        <td align="left"><span><?php echo $cp_contactPerson; ?><?php if($cp_primaryvalue == 1){ ?><img src="images/connected.png" width="15"><?php } ?></span> <br>
            <strong>Cont.&nbsp;No:&nbsp;</strong><?php echo $cp_phone; ?><br>
            <strong>Email&nbsp;Id:&nbsp;</strong><?php echo $cp_email; ?>
        </td>
        <td align="left"><?php
            $rs3=GetPageRecord('*','hotelCategoryMaster',' id="'.$resultlists['hotelCategoryId'].'"');
            $resListing3=mysqli_fetch_array($rs3);
            echo $resListing3['hotelCategory'].' Star';
        ?></td>
       
            
            <td align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active';?></div><?php }  ?>	
       
         </td>
        <td align="left"><a
            title="<?php if($resultlists['roomType']!='' && $resultlists['roomType']!=',' && $resultlists['roomType']!=0){ echo $hotelRoomsType; } ?>"><?php
            if($resultlists['roomType']!='' && $resultlists['roomType']!=',' && $resultlists['roomType']!=0){ echo $hotelRoomsType; }
        ?></a></td>
        <td align="center"><a
            href="showpage.crm?module=<?php echo clean($_GET['module']); ?>&page=addGallery&hotelId=<?php echo $resultlists['id']; ?>"><input
            name="addnewuserbtn" type="button" class="bluembutton"
        value="+&nbsp;Gallery" /></a></td>
        <td align="center"><a
            href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&view=yes&hotelId=<?php echo encode($resultlists['id']); ?>"><input
            name="addnewuserbtn" type="button" value="+ Add/View"
        class="bluembutton"></a></td>
    </tr>
    <?php $no++; } ?>
</tbody>
</table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
<div class="pagingdiv">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
                        <td><select name="records" id="records" onchange="this.form.submit();"
                            class="lightgrayfield">
                            <option value="25" <?php if($_GET['records']=='25'){ ?>
                            selected="selected" <?php } ?>>25 Records Per Page</option>
                            <option value="50" <?php if($_GET['records']=='50'){ ?>
                            selected="selected" <?php } ?>>50 Records Per Page</option>
                            <option value="100" <?php if($_GET['records']=='100'){ ?>
                            selected="selected" <?php } ?>>100 Records Per Page</option>
                            <option value="200" <?php if($_GET['records']=='200'){ ?>
                            selected="selected" <?php } ?>>200 Records Per Page</option>
                            <option value="300" <?php if($_GET['records']=='300'){ ?>
                            selected="selected" <?php } ?>>300 Records Per Page</option>
                        </select></td>
                    </tr>
                </table>
            </td>
            <td align="right">
                <div class="pagingnumbers"><?php echo $paging; ?></div>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</form>
</td>
</tr>
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"
target="actoinfrm" style="display:none;">
<input name="importpackagehotel" id="importpackagehotel" type="hidden" value="Y" /> 
<input name="importpackagehotelModule" id="importpackagehotelModule" type="hidden"
value="<?php echo clean($_GET['module']); ?>" />
<div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel"
onchange="submitimportfrom();" /></div>
</form>
<script>
function submitimportfrom() {
startloading();
$('#importfrm').submit();
var filesizes = $("#importfield")[0].files[0].size;
filesizes = Number(filesizes / 1024);
if (filesizes > 11) {
}
}
function reloadpagemain() {
location.reload();
}
$('#importbutton').click(function() {
$('#importfield').click();
});
</script>
<script>
window.setInterval(function() {
checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
if (!checked) {
$("#deactivatebtn").hide();
$("#topheadingmain").show();
} else {
$("#deactivatebtn").show();
$("#topheadingmain").hide();
}
}, 100);
comtabopenclose('linkbox', 'op2');
$(document).ready(function() {
    $('#mainsectiontable').DataTable({
        "paging": false,
        "ordering": true,
        "info": true,
        "searching": false,
        "order": [
            [0, 'asc']
        ]
    });
});
</script>
<?php } ?>
