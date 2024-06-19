 
<style type="text/css">
	div,body,button{
		margin: 0;
	    padding: 0;
	    border: 0;
	    font: inherit;
	    vertical-align: baseline;
	    font-family: 'Roboto', sans-serif;
	}
	.app-main-trip-nav {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		left: 0;
		background-color: #233a49;
		border-bottom: 5px solid #7a96ff;
		width: 100%;
		z-index: 100;
		display: flex;
		justify-content: center;
		padding-right: 0.5rem;
		padding-right: 0;
	}
	.app-main-trip-nav .app-main-trip-nav-container{
	    width:100%;
	    max-width:90rem;
	    display:flex;
	    align-items:center;
	    flex:0 1 auto;
	    flex-flow:row wrap;
	    justify-content:space-between
	}
	.app-main-trip-nav .app-main-trip-nav-inner{
	    padding:8px;
	    flex:0 1 auto;
	    display:flex;
	    align-items:center;
	    flex-flow:row wrap
	} 
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group{
	    display:flex;
	    align-items:center
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn{
	    font-weight:400;
	    color:#fff;
	    fill:#fff;
	    margin-right:1.25rem;
	    margin-left:0
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn:focus, .app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn:hover {
	    fill:#fff;
	    color:#fff;
	}
 
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn:last-child{
	    margin-right:0
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn span{
	    margin-left:.25rem
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .trip-nav-btn svg{
	    height:1rem;
	    width:1rem
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .more-menu{
	    width:14rem
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .send-menu{
	    width:255px
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .send-menu hr{
	    border-left:0;
	    border-right:0;
	    border-bottom:0;
	    border-top:1px solid #d7dfe3;
	    border-color:#d7dfe3;
	    margin:1rem 0
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .send-menu .divider{
	    margin:.7rem 0
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .send-menu p{
	    color:#fff;
	    font-weight:700;
	    font-size:.8rem;
	    margin-bottom:.2rem
	}
	.app-main-trip-nav .app-main-trip-nav-inner .trip-nav-inner-group .send-menu a.trip-url{
	    display:block;
	    margin-bottom:.2rem;
	    overflow:hidden;
	    text-overflow:ellipsis;
	    width:100%;
	    white-space:nowrap
	}
	.btn {
	    position: relative;
	    text-transform: initial;
	    border: 1px solid transparent;
	    overflow: hidden;
	    text-align: center;
	    border-radius: 0.25rem;
	    font-family: 'Roboto', sans-serif;
	    backface-visibility: hidden;
	    transform: scale(1);
	    font-size: 14px;
	    line-height: 1;
	    display: flex;
	    flex-flow: row wrap;
	    align-items: center;
	    justify-content: center;
	    height: 2.9rem;
	    padding-left: 0.7rem;
	    padding-right: 0.7rem;
	    transition-property: transform,background-color,border,color,box-shadow;
	    transition-duration: .25s;
	    font-weight: 400;
	}

	._btn-little, ._btn-small {
	    height: 2.1rem;
	    padding-left: 0.35rem;
	    padding-right: 0.35rem;
	}
	._btn-primary {
	    color: #fff;
	    background-color: #e3ae1a;
	    border-color: transparent;
	}
	.btn-group-inline>.btn {
	    width: auto;
	    display: inline-flex;
	    margin-bottom: 0;
	    margin-right: 0.7rem;
	}
	.btn>* {
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
	.btn-group-inline>.btn:last-child, .btn-group-inline>.btn:last-of-type {
	    margin-bottom: 0;
	    margin-right: 0;
	}
 
	.btn-group-inline {
	    display: flex;
	    flex-direction: row;
	    flex-wrap: wrap;
	}
	.big-input-wrap select, .btn, .ember-link-to, .t-link, [data-ember-action], button {
	    cursor: pointer;
	}
	button {
	    background-color: transparent;
	    color: inherit;
	}
	.btn:focus, .btn:hover {
	    color: #fff;
	    border: 1px solid transparent;
	    background-color: #233a49;
	    /*background-color: #e3ae1a;*/
	    outline: 0;

	}
	.calweek a, .v2-article a, a {
	    text-decoration: none;
	}
	.t-position-relative {
	    position: relative;
	}
	.component-flyout {
	    position: absolute;
	    background-color: #fff;
	    box-shadow: 0 0.25rem 2rem -0.5rem rgb(125 151 164 / 30%);
	    border: 1px solid #d7dfe3;
	    border-radius: 0.25rem;
	    z-index: 50;
	    width: 100%;
	    transform-origin: 50% 40%;
	    transform: scale(0);
	    transition-property: transform;
	    transition-duration: .25s;
	}
	.component-flyout._is-active {
	    transform: scale(1);
	}
	.component-flyout._with-padding {
	    padding: 0.7rem;
	}
	.component-flyout._align-right {
	    right: 0;
	    top: 3em;
	}

	.component-list-item-button {
	    padding: 0.5rem;
	    margin-bottom: 2px;
	    color: #233a49;
	    border-radius: 0.25rem;
	    cursor: pointer;
	    display: flex;
	    align-items: center;
	    transition-property: background-color,color;
	    transition-duration: .25s;
	    width: 100%;
	    text-align: left;
	} 
	.modal-wrap {
	    position: fixed;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background-color: rgba(5,37,48,.6);
	    z-index: 100;
	    opacity: 0;
	    display: none;
	    align-items: center;
	    justify-content: center;
	    visibility: hidden;
	}
	.modal-wrap, .modal-wrap.modal-is-active {
	    transition-property: transform,opacity;
	    transition-duration: 0,.25s;
	}
	.modal-wrap.modal-is-active {
	    opacity: 1;
	    display: flex;
	    visibility: visible;
	}
	.modal {
	    width: 50%;
	    height: auto;
	    opacity: 0;
	    overflow-x: hidden;
	    position: relative;
	    display: flex;
	    flex-direction: column;
	    transition: .25s;
	}
	.modal, .t-radio-mark {
	    background-color: #fff;
	}
	.modal-is-active .modal {
	    opacity: 1;
	    transform: scale(1);
	}

	.modal-header {
	    font-weight: 700;
	    background-color: #f2f5f6;
	    border-bottom: 1px solid #d7dfe3;
	    align-items: center;
	    flex: 0 0 auto;
	    padding: 0.525rem;
	    display: flex;
	    justify-content: space-between;
	    z-index: 1;
	}

	.modal-header-title {
	    font-size: 1.16667rem;
	    line-height: 1.4rem;
	    color: #7d97a4;
	}

	.modal-header-close, .modal-header-close:after {
	    border-radius: 0.25rem;
	}
	.modal-header-close {
	    cursor: pointer;
	    position: relative;
	    left: 0.35rem;
	    width: 1.75rem;
	    height: 1.75rem;
	    transition: .25s;
	    padding: 0.175rem;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
	.modal-content {
	    position: relative;
	    min-width: 20rem;
	    overflow-x: hidden;
	    overflow-y: auto;
	    flex: auto;
	    padding: 1.05rem;
	    z-index: 1;
	}

	.component-list-item-button.highlighted, .component-list-item-button:hover {
	    color: var(--fp-color-brand--primary-dark,#2A79A6);
	    background-color: var(--fp-color-brand--primary-lighter,#EFF9FF);
	}
	.fa{
		margin: 0px 5px;
	}	

	.component-trip-settings-modal .trip-details-modal-section {
	    border-top: 1px solid #f2f5f6;
	    padding: 2rem 1rem;
	}
	.component-trip-settings-modal .trip-details-modal-section:first-child {
	    border-top: none;
	    padding-top: 1rem;
	}
	.component-trip-settings-modal .trip-details-modal-row {
	    padding-bottom: 1rem;
	}
	.component-trip-settings-modal .trip-details-modal-row>label {
	    font-weight: 700;
	    display: block;
	    padding-bottom: 0.5rem;
	    font-size: 1rem;
	    line-height: 1;
	    flex: 0 0 8rem;
	}
	.component-trip-settings-modal .trip-details-modal-row-right {
	    color: #7d97a4;
	    display: flex;
	    align-items: center;
	    flex: 1 1 auto;
	    flex-flow: row wrap;
	}
</style> 
 <?php 
$proURL = $fullurl.'PreviewFiles/crm_proposal.php?propNum='.trim($propNum).'&id='.encode($quotationId);
$elegantURL = $fullurl.'Elegant/Home/'.encode($quotationId);  
$sendEmailURL = $fullurl.'showpage.crm?module=query&view=yes&id='.encode($queryId).'&propURL='.encode($proURL);
?>
<!-- end setting modal -->
<div class="propsal_nav app-main-trip-nav removeDiv">
<div class=" app-main-trip-nav-container">
    <div class="app-main-trip-nav-inner">
        <div class="btn-group-inline trip-nav-inner-group">
            <a href="<?php echo $fullurl; ?>showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultpageQuotation['id']); ?>" class="btn _btn-small trip-nav-btn"><i class="fa fa-angle-left " aria-hidden="true"></i> Modify Trip</a>
            <div class="t-position-relative _c-right">
                <button class="btn trip-nav-btn _btn-small " onclick="$('#previewSettingId').toggleClass(' modal-is-activeaaaaa');proposal_alertspopupopen('action=proposalSettings&quotationId=<?php echo encode($resultpageQuotation['id']); ?>','600px','auto');">
                    <span><i class="fa fa-cog" aria-hidden="true"></i>Preview Settings</span>
                </button>
            </div>
			<a href="<?php echo $elegantURL; ?>" class="btn _btn-small trip-nav-btn" target="_blank">
                <span><i class="fa fa-globe" aria-hidden="true"></i>Elegant</span>
            </a>
        </div>
    </div>
    <div class="app-main-trip-nav-inner">
        <div class="btn-group-inline trip-nav-inner-group">

		<!-- <div style="">
			<select style="padding: 10px;" id="languageType2" name="languageType2" class="gridfield" displayname="Language Type" autocomplete="off"  >
			<option value="0" disabled >Select Language</option>
			<?php 
				$rs=GetPageRecord('id,name','tbl_languagemaster','1 and status=1 and deletestatus=0');
	        	$totalrow = mysqli_num_rows($rs);
	        	while($languageDetails=mysqli_fetch_array($rs)){
	        	?>
	        	<option value="<?php echo $languageDetails['id']; ?>" <?php if($languageDetails['id'] == $quotationData['languageId']){ echo "selected"; } ?>><?php echo $languageDetails['name']; ?></option>
	        <?php } ?> 
			</select> 	
		</div> -->
            <div class="t-position-relative _c-right">

			
                <button class="btn _btn-small trip-nav-btn mobile-icon-only" onclick="$('#exportBtnId').toggleClass('_is-active')">
                    <span><i class="fa fa-book fa-fw" aria-hidden="true"></i>Export</span>
                </button>
				<div id="exportBtnId" class="component-flyout send-menu _align-left _with-padding popbox">
				    <ul>
				        <li>
				            <button class="list-item component-list-item-button" onclick="printDiv('printBox')">
							    <span><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Pdf Document</span>
							</button>
				        </li>
			            <li>
			                <button class="list-item component-list-item-button " onclick="Export2Word('printBox','<?php echo $proName; ?>');">
							    <span><i class="fa fa-file-word-o" aria-hidden="true"></i>&nbsp;Word Document</span>
							</button>
			            </li>

			    	</ul>
				</div>
            </div>
           
            <a id="propURL" href="<?php echo $proURL; ?>" class="btn _btn-small trip-nav-btn" target="_blank">
                <span><i class="fa fa-play" aria-hidden="true"></i>Preview</span>
            </a>
            <div class="t-position-relative _c-right">
                <button class="btn _btn-small _btn-primary" onclick="$('#shareBtnId').toggleClass('_is-active')">
                    <span><i class="fa fa-share-alt" aria-hidden="true"></i>Send</span>
                </button>
				<div id="shareBtnId" class="component-flyout send-menu _align-right _with-padding popbox">
				    <ul>
				        <li>
				            <button class="list-item component-list-item-button" onclick="copyToClipboard('propURL');">
							    <span><i class="fa fa-link " aria-hidden="true"></i>Get Trip Link</span>
							</button>
				        </li>

			            <li>
			            	<a target="_blank" href="<?php echo $sendEmailURL; ?>" class="list-item component-list-item-button">
			                    <span><i class="fa fa-envelope" aria-hidden="true"></i>Send via Email</span>
							</a>
			            </li>

			            <li>
			                <a target="_blank" href="https://wa.me/?text=<?php echo urlencode($proURL); ?>" class="list-item component-list-item-button">
							    <span><i class="fa fa-whatsapp" aria-hidden="true"></i>Send via Whatsapp</span>
							</a>
			            </li> 
			    	</ul>
				</div>
            </div>
        </div>
    </div>
</div>
</div>