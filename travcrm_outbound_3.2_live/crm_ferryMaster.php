<?php include 'tableSorting.php'; ?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top">

      <form id="listform" name="listform" method="get">

        <div class="rightsectionheader">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">

            <tr>

              <td width="7%">
                <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>
              </td>

              <td>
                <div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo "Ferry Name Master"; ?></span>

                  <div id="deactivatebtn" style="display:none;">

                    <?php if ($deletepermission == 1) { ?>



                      <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=FerryName','600px','auto');" />

                    <?php } ?>

                  </div>



                </div>
              </td>

              <td align="right">
                <table border="0" cellpadding="0" cellspacing="0">

                  <tr>

                    <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="" size="100" maxlength="100" placeholder="Keyword"></td>

                    <td>

                      <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->

                      <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if ($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">



                        <option value=""> Select Status &nbsp;</option>



                        <option value="1" <?php if ($_GET['status'] == '1') { ?>selected="selected" <?php  } ?>>Active</option>



                        <option value="0" <?php if ($_GET['status'] == '0') { ?>selected="selected" <?php  } ?>>Inactive</option>



                      </select>

                    </td>

                    <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>



                    <?php if ($importpermission == 1) { ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>

                    <?php if ($addpermission == 1) { ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo "Ferry Name"; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','400px','auto');" /></td> <?php } ?>

                  </tr>



                </table>
              </td>

            </tr>



          </table>

        </div>



        <div id="pagelisterouter" style="padding-left:30px;">

          <input name="action" id="action" type="hidden" value="deleteferryName" />

          <input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />



          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">



            <thead>



              <tr>

                <th width="2%" class="header" align="left">Sr.</th>

                <th width="4%" height="28" align="center" valign="middle" class="header"><?php if ($editpermission == 1) { ?> <input type="checkbox" id="checkAll" name="checkedAll" onclick="checkallbox();" /><?php } ?>

                  <label for="checkAll"><span></span>&nbsp;</label>

                </th>
                <th width="3%" align="center" class="header" >Image</th>
                <th align="left" class="header">Ferry Company</th>
                <th align="left" class="header">Ferry Name </th>
                <th align="left" class="header">Capacity </th>

                <th align="left" class="header">Created By</th>

                <th align="left" class="header">Modified By</th>

                <th align="left" class="header">Status</th>

              </tr>

            </thead>


            <tbody>

              <?php



              $no = 1;

              $select = '*';

              $where = '';

              $rs = '';

              $wheresearch = '';

              $limit = clean($_GET['records']);

              if ($_GET['keyword'] != '') {

                $wheresearch = "and name like '%" . $_GET['keyword'] . "%'";
              }

              if ($_REQUEST['status'] != '') {

                $wheresearch2 = " and status ='" . clean($_REQUEST['status']) . "' ";
              }

              //$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  



              // $where='where name!="" '.$wheresearch2.''.$wheresearch.' and deletestatus=0 ORDER BY name asc'; 

              $page = $_GET['page'];



              $targetpage = $fullurl . 'showpage.crm?module=' . $_GET['module'] . '&records=' . $limit . '&';



              if ($_GET['keyword'] != '') {

                $wheresearch = "and name like '%" . $_GET['keyword'] . "%'";
              }

              if ($_REQUEST['status'] != '') {



                $wheresearch2 = " and status ='" . clean($_REQUEST['status']) . "' ";
              }

              $where = 'where  name!=""  ' . $wheresearch . '' . $wheresearch2 . ' and deletestatus=0 order by id desc';

              $page = $_GET['page'];

              $targetpage = $fullurl . 'showpage.crm?module=' . $_GET['module'] . '&records=' . $limit . '&';

              $rs = GetRecordList($select,'ferryNameMaster', $where, $limit, $page, $targetpage);

              $totalentry = $rs[1];

              $paging = $rs[2];

              while ($resultlists = mysqli_fetch_array($rs[0])) {

                $dateAdded = clean($resultlists['dateAdded']);

                $modifyDate = clean($resultlists['modifyDate']);
                

              ?>

                <tr>

                  <td width="2%" align="left"><?= $no; ?></td>

                  <td width="2%" align="center" valign="middle"><?php if ($editpermission == 1) { ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk" value="<?php echo encode($resultlists['id']); ?>" />

                      <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?>

                  </td>

                  <td align="left" width="5%"><?php if($resultlists['image']!=''){ ?><img src="packageimages/<?php echo $resultlists['image']; ?>" width="75" height="58" /><?php }else{ echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>"; } ?></td>

                    <td width="11%" align="left"> <?php 
                    // echo $resultlists['ferryCompanyId'];
                     $getferyc = GetPageRecord('*','ferryCompanyMaster',' id="'.$resultlists['ferryCompanyId'].'" and deletestatus=0 and status=1');
                      $getcompName = mysqli_fetch_array($getferyc);
                     echo $getcompName['name'];
                    ?> </td>
                  <td width="11%" align="left">
                    <div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','400px','auto');"><?php echo $resultlists['name']; ?></div>
                  </td>

                    <td width="5%" align="left"> <?php echo $resultlists['capacity']; ?> </td>

                  <td width="17%" align="left"><?php $select = '';

                                                $where2 = '';

                                                $rs2 = '';

                                                $select2 = 'firstName,lastName';

                                                $where2 = 'id="' . $resultlists['addedBy'] . '"';

                                                $rs2 = GetPageRecord($select2, _USER_MASTER_, $where2);

                                                while ($userss = mysqli_fetch_array($rs2)) {



                                                  echo $userss['firstName'] . ' ' . $userss['lastName']; ?>

                      <div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($dateAdded, $loginusertimeFormat); ?></div>

                    <?php



                                                } ?>
                  </td>

                  <td width="15%" align="left"><?php $select = '';

                                                $where2 = '';

                                                $rs2 = '';

                                                $select2 = 'firstName,lastName';

                                                $where2 = 'id="' . $resultlists['modifyBy'] . '"';

                                                $rs2 = GetPageRecord($select2, _USER_MASTER_, $where2);

                                                while ($userss = mysqli_fetch_array($rs2)) {

                                                  echo $userss['firstName'] . ' ' . $userss['lastName']; ?>

                      <div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($modifyDate, $loginusertimeFormat); ?></div>

                    <?php



                                                } ?>
                  </td>

                  <td width="5%" align="left"><?php if ($resultlists['status'] == 1) { ?><div style=" width: fit-content; color: green; "><?php echo 'Active'; ?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active'; ?></div><?php }  ?>

                  </td>



                <?php $no++;
              } ?>

            </tbody>
          </table>

          <?php if ($no == 1) { ?>

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

                        <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield">

                            <option value="25" <?php if ($_GET['records'] == '25') { ?> selected="selected" <?php } ?>>25 Records Per Page</option>

                            <option value="50" <?php if ($_GET['records'] == '50') { ?> selected="selected" <?php } ?>>50 Records Per Page</option>

                            <option value="100" <?php if ($_GET['records'] == '100') { ?> selected="selected" <?php } ?>>100 Records Per Page</option>

                            <option value="200" <?php if ($_GET['records'] == '200') { ?> selected="selected" <?php } ?>>200 Records Per Page</option>

                            <option value="300" <?php if ($_GET['records'] == '300') { ?> selected="selected" <?php } ?>>300 Records Per Page</option>

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



<script>
  window.setInterval(function() {

    checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

    checked = $('#listform td input[type=checkbox]:checked').length;

    //alert(checked);

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
        [1, 'asc'],
        [2, 'asc'],
        [3, 'asc']
      ]



    });

  });
</script>