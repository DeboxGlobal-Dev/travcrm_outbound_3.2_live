<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  
<div class="mainDiv">
    <div class="mealClass"><h4 style="display: inline-block;">Wallet</h4><span class="closeBTN" ><i class="fa fa-times"></i></span></div>
		<div>
		 <form class="form-container">
        <p>Select:</p>
        <input type="radio" value="">
        <label for="apple">Agent</label>
        <input type="radio"  value="">
        <label for="banana">Direct Client</label>
        </form>
        <input class="serchbtn" type="search" placeholder="Enter client Name, Mobile No, Tour Id">
        <button class="btn" type="button">Add</button>
			<div>
				<table class="table table-bordered">
					<thead>
					    <tr>
						<th>Name</th>
						<th>Mobile No</th>
						<th>Email</th>
						<th>Current Balance</th>
						<th>Action</th>
						<th>Approval Status</th>
						</tr>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<style>
		.mealClass{
		background-color: #233a49 !important;
    	color: #fff;
    	padding: 10px;
    	font-size: 16px;
		border-radius: 3px;
		}
		.closeBTN{
			float: right;
    	font-weight: 600;
    	cursor: pointer;
    	width: 18px;
    	text-align: center;
		}
		.addBtnMeal{
			width: fit-content !important;
			padding: 8px 12px !important;
			background-color: #e7e7e7;
			box-shadow: -2px 3px 4px -3px black;
		}
		.mainDiv{
			margin-top: 20px;
    		margin-bottom: 20px;
    		width:800px;
		}
		.form-container {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 20px; 
    }
    .form-container label {
      margin-right: 20px; 
    }
    .serchbtn{
        width:300px;
        margin-bottom: 20px;
        height:5vh;
        
    }
    .btn{
        width:80px;
        margin-left:50px;
        background-color: DodgerBlue;
    }
		
	</style>
