<!DOCTYPE html>
<html>
<head>
	<title></title>



<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

<style type="text/css">
	body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-image: url("https://i.imgur.com/GMmCQHC.png");
    background-repeat: no-repeat;
    background-size: 100% 100%
}

.card {
	width: 660px;
	height: 700px;
    padding: 30px 70px;
    margin-top: 60px;
    margin-bottom: 60px;
    margin-left: 50px;
    border: none !important;
    border-radius: 10px;
    opacity: 0.8;
    box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
}

.blue-text {
    color: #00BCD4
}

.form-control-label {
    margin-bottom: 0
}

input,
textarea,
button {
    padding: 8px 15px;
    border-radius: 5px !important;
    margin: 5px 0px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    font-size: 18px !important;
    font-weight: 300
}

input:focus,
textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #00BCD4;
    outline-width: 0;
    font-weight: 400
}

.btn-block {
    text-transform: uppercase;
    font-size: 15px !important;
    font-weight: 400;
    height: 43px;
    cursor: pointer
}

.btn-block:hover {
    color: #fff !important
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0
}

.mainbtn{
	background-image: url('images/Fixed-date-button.png');
	background-color: white;
	border :none;
	color: white;
	padding: 20px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 12px;
	margin-bottom: 4px 2px;
	width: 150px;
	height: 20px;
/*	border: 5px solid red;*/
	border-collapse: separate;
	overflow: hidden;
	border-radius: 25% 10%;
}

#btn1{
	width: 155px;
	height: 32px;
    font-size: 14px !important;
    text-align: center;
    border: none;
    background-color: white;
    box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
}

#budget{
	width: 225px;
	height: 30px;
}

#inputfeild{
	width: 155px;
	height: 30px;
}

#selectfeildtra{
	width: 160;
	height: 30px;
}

#select8{
	width: 160px;
	height: 30px;
	margin-top: 5px;
}

#input8{
	width: 260px;
	height: 30px;
	margin-left: 20px;
}

#endbtn{
width: 260px;

}






</style>

</head>
<body style="background-image: url('images/TRAVCRM-Landing-Page-Get-Free-Quotes-BG.jpg');">

<div class="container-fluid px-1 py-5 mx-auto" id="mainBody">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
            <div class="card">
                <form class="form-card" onsubmit="event.preventDefault()">
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3"><b>From</b><span class="text-danger"> *</span></label> <select type="text" id="fname" name="fname" placeholder="Enter your first name" onblur="validate(1)"> 
                        	<option>Select</option>
                        </select></div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3"><b>Going To</b><span class="text-danger"> *</span></label> <select type="text" id="lname" name="lname" placeholder="Enter your last name" onblur="validate(2)">
                        <option>Select</option> 
                        </select></div>
                    </div>
                    <div class="row justify-content-between text-left">
                    <label class="form-control-label px-3"><b>Departure Date</b><span class="text-danger"> *</span></label></div> 
                    <div class="row justify-content-between text-left" id="3buttonDiv" >
                        <div class="form-group col-sm-4 flex-column d-flex"> <button class="btn btn-primary rounded-pill" id="btn1"style="background-image: url('images/Fixed-date-button.png');" onclick="show2()">Fixed Date</button></div>
                        <div class="form-group col-sm-4 flex-column d-flex"><button class="btn btn-primary rounded-pill" id="btn1" style="background-image: url('images/Flexible-date-button.png');" onclick="show2()">Flixible Date</button> </div>
                        <div class="form-group col-sm-4 flex-column d-flex"><button class="btn btn-primary rounded-pill" id="btn1" style="background-image: url('images/Anytime-button.png');" onclick="show2()">Anytime</button> </div>
                    </div>


                    <div class="row justify-content-between text-left" style="display:none;" id="nooddaysDiv">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3"><b>Dates</b><span class="text-danger"> *</span></label> <input type="text" id="departuredate" name="lname" placeholder="Enter your last name" onblur="validate(2)"></div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3"><b>No Of Days</b><span class="text-danger"> *</span></label> <input type="text" id="nooddays" name="lname" placeholder="Enter your last name" onblur="validate(2)"> 
                        </div>
                    </div>



                    <div class="row justify-content-between text-left">
                    <label class="form-control-label px-3"><b>Contact Information</b> <span class="text-danger"> *</span></label></div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-4 flex-column d-flex"> 
                       	<input type="text" id="inputfeild" name="name" placeholder="Name" onblur="validate(5)"> </div>
                        <div class="form-group col-sm-4 flex-column d-flex"><input type="text" id="inputfeild" name="mobileNo" placeholder="Mobile Number" onblur="validate(5)"> </div>
                        <div class="form-group col-sm-4 flex-column d-flex"><input type="text" id="inputfeild" name="email" placeholder="E mail" onblur="validate(5)"> </div>
                    </div>

                    <div class="row justify-content-between text-left">
                    <label class="form-control-label px-3"><b>Prefer Hotel Category</b> <span class="text-danger"> *</span></label></div>

                    <div class="row justify-content-between text-left" style="padding: 5px;">
                    <div class="form-group col-sm-3 flex-column d-flex">
                      <div><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">&nbsp;&nbsp;
					  <label for="vehicle1"><b> 5&nbsp;Star</b></label></div>
					</div>

					<div class="form-group col-sm-3 flex-column d-flex">
					  <div><input type="checkbox" id="vehicle2" name="vehicle2" value="Car">&nbsp;&nbsp;
					  <label for="vehicle2"><b> 4&nbsp;Star</b></label></div>
					</div>

					<div class="form-group col-sm-3 flex-column d-flex">
					  <div><input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">&nbsp;&nbsp;
					  <label for="vehicle3"><b> 3&nbsp;Star</b></label></div>
                    </div>

                    <div class="form-group col-sm-3 flex-column d-flex">
					  <div><input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">&nbsp;&nbsp;
					  <label for="vehicle3"><b> Any</b></label></div>
                    </div>
                	</div>

                    <div class="row justify-content-between text-left">
                    <label class="form-group col-sm-6 flex-column d-flex"><b>Do You Need Flight?</b> </label><label class="form-group col-sm-6 flex-column d-flex"><b>Trip Budgest</b></label>
                	</div>

                    <div class="row justify-content-between text-left">
                    <div class="form-group col-sm-3 flex-column d-flex" >
                      <div><input type="radio" id="flightbox" name="vehicle1" value="Yes">&nbsp;
					  <label for="vehicle1"><b> Yes</b></label>&nbsp;
					  <img src="images/flight-yes.png" id="flightyes" width="35"></div>
					</div>


					<div class="form-group col-sm-3 flex-column d-flex">
					  <div><input type="radio" id="flightbox" name="vehicle2" value="No">&nbsp;
					  <label for="vehicle2"><b> No</b></label>&nbsp;
					  <img src="images/flight-no.png" id="flightyes" width="35"></div>
					</div>

					<div class="form-group col-sm-6 flex-column d-flex">
					  <input type="text" id="budget" name="budget" placeholder="In INR">
                    </div>

                	</div>

					<div class="row justify-content-between text-left">
                    <label class="form-control-label px-3"><b>No Of Travelers</b> <span class="text-danger"> *</span></label></div>
                    <div class="row justify-content-between text-left" style="padding: 5px;">
                        <div class="form-group col-sm-6 flex-column d-flex"> 
                       	<select type="text" id="selectfeildtra" name="name" placeholder="Adult" onblur="validate(5)">
                       		<option>Select</option>
                       	</select>	
                       	 </div>
                        <div class="form-group col-sm-6 flex-column d-flex">

                        <select type="text" id="selectfeildtra" name="mobileNo" placeholder="Child Number" onblur="validate(5)"> 
                        	<option>Select</option>
                        </select>	
                        </div>
                    </div>


                    <div class="row justify-content-between text-left">
                    <label class="form-control-label px-3"><b>Type Of Trip You Want? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other Information</b> <span class="text-danger"> *</span></label></div>
                    <div class="row justify-content-between text-left" style="padding: 5px;">
                        <div class="form-group col-sm-4 flex-column d-flex" > 
                       	<select type="text" id="select8" name="name" placeholder="Adult" onblur="validate(5)">
                       		<option>Select</option>
                       	</select>	
                       	 </div>
                        
                        <div class="form-group col-sm-8 flex-column d-flex" >
                        <input type="text" id="input8" name="mobileNo" placeholder="Child Number" onblur="validate(5)">
                        </div>
                    </div>

 

                    <div class="row justify-content-end">
                        <div class="form-group col-sm-12"> <button type="submit" class="btn btn-primary rounded-pill" id="endbtn">Plan my Holiday</button> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>

<script type="text/javascript">
    
    function show2(){
        $('#nooddaysDiv').css('display','inline-block');
        $('#3buttonDiv').css('display','none');
    }

</script>
