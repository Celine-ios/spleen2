CALENDAR = {
	calendarCSS: "include/css/calendario.css",

	start: function(){

		var calendars = KRNLDOM.getElementByClass('calendar');
		for(var c=0;c<calendars.length;c++){
			var labelFor = calendars[c].innerHTML;
			calendars[c].style.display = 'none';
			var dateInput = document.getElementById(labelFor);
			CALENDAR.prepare(dateInput);	
		}
		
		//Agrego la hoja de estilo
		KRNLDOM.addStyleSheet(CALENDAR.calendarCSS);
	},

	prepare: function(input){
        Calendar.setup({
			inputField	: "nacimiento",
			button		: "nacimiento2",
			ifFormat	: "%Y%m%d",			
			eventName	:	"focus",
			align		: "Bl",
			showOthers	:	true
        });
	}
}

if(document.getElementsByTagName) KRNLDOM.addEvent(window, 'load', CALENDAR.start, false);