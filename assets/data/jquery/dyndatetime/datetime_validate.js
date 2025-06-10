// Valide Day Month Year


function compare(){
	//compare day month year
	if(! validateTwoMonthYear() ) {		
		popupMsg(myMessage);
	}	
}

//Compare two day
function validateTwoDates() {
	var $dateStart = $("#prPromoDateFrom").val();
	var $dateEnd = $("#prPromoDateTo").val();
	return($dateEnd > $dateStart);
}

//Compare two month and year
function validateTwoMonthYear()
{
	var $dateStart = $("#prPromoDateFrom").val();
	var $dateEnd = $("#prPromoDateTo").val();
	var monthFirst = $dateStart.split('-');
	var monthSecond = $dateEnd.split('-');
	
	var onemonth = monthFirst[1];
	var oneyear = monthFirst[2];
	var twomonth = monthSecond[1];
	var twoyear = monthSecond[2];
	
	var year1 = oneyear + onemonth / 12;
	var year2 = twoyear + twomonth / 12;
	if (year1 > year2) { return false }
	if (! validateTwoDates() && (year1 == year2) ) { return false }
	
	return true;
}

// check datetime to drop down input Date_To
function dropdownTo(value, focus_id) {
	
	if(value == '') return;
	
	if (typeof focus_id == "undefined") { focus_id='prPromoDateFrom' }	  
	
	var dateparts = value.split('-');
	var CurrentDate = new Date();    
    var dbDate = new Date(dateparts[2], dateparts[1] - 1, dateparts[0]);
    
  	var date_from = datePlus(value, 2);
	var date_to = datePlus(value, 1);
	
	if (dbDate < CurrentDate) {
		$('#prPromoDateTo').val(date_from);
		$('#prPromoDateFrom').val(date_to);
        
		pop_title = (pop_title != '') ? pop_title : "Alert";
		popupMsg(pop_title, currentInValid, focus_id);
		return;
		
		//popupMsg(currentInValid);
    } else { $('#prPromoDateTo').val(date_to); }
}


function datePlus(value, number) {
	if(value == '') return;
	
	var dateparts = value.split('-');
	var my_day = parseInt(dateparts[0])+number;
	var my_month = parseInt(dateparts[1])+number;
	var my_year = parseInt(dateparts[2])+number;
	
  	var date_from = my_day+'-'+dateparts[1]+'-'+dateparts[2];	
	var date_valid = dateparts[1]+'/'+my_day+'/'+dateparts[2];
	
	if(! isDate(date_valid)) { //valid day of month
		date_from = '01-'+my_month+'-'+dateparts[2];
										
		var date_valid = my_month+'/1/'+dateparts[2];								
		if(! isDate(date_valid)) { //valid month of year
			date_from = '01-01-'+my_year;
		}
	}
	
	return date_from;
}


//validate month/day/year
function isDate(txtDate)
{
	var currVal = txtDate;
	
	if(currVal == '') return false;
	
	//Declare Regex 
	var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
	var dtArray = currVal.match(rxDatePattern); // is format OK?
	
	if (dtArray == null) return false;
		
	//Checks for mm/dd/yyyy format.
	dtMonth = dtArray[1];
	dtDay= dtArray[3];
	dtYear = dtArray[5];
		
	if (dtMonth < 1 || dtMonth > 12)
		return false;
	else if (dtDay < 1 || dtDay> 31)
		return false;
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
		return false;
	else if (dtMonth == 2)
	{
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if (dtDay> 29 || (dtDay ==29 && !isleap))
			return false;
	}

	return true;
}