<?php
include "inc.php";

if(trim($_REQUEST['action'])=='languageeditor' && trim($_REQUEST['languageId'])!='' && trim($_REQUEST['letterId'])!=''){
$letterId = $_REQUEST['letterId'];
$languageId = $_REQUEST['languageId'];
$rs1=GetPageRecord('*','letterLanguageMaster','1 and letterId="'.$letterId.'" and languageId="'.$languageId.'"');
$editresult=mysqli_fetch_array($rs1);
?>
<script type="text/javascript">
                            tinymce.init({
                        
                                selector: "#languageeditor<?php echo $_REQUEST['languageId']; ?>",
                        
                                themes: "modern",   
                        
                                plugins: [
                        
                                    "advlist autolink lists link image charmap print preview anchor",
                        
                                    "searchreplace visualblocks code fullscreen" 
                        
                                ],
                        
                                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
                        
                            });
                        
                            </script>

<textarea name="descname" id="languageeditor<?php echo $_REQUEST['languageId']; ?>"><?php echo stripslashes($editresult['description']); ?></textarea>

<?php 
}
?>