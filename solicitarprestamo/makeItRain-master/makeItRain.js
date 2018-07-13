$(document).ready(function() {


			var maxBills = 5;


			for (var i = 0; i < maxBills; i++){

			var random = $(window).width();

			var randomPosition = Math.floor(random*Math.random());

			var randomTime = Math.random() * 3;
			var randomSpeed = (Math.random()*20)+10 ;


			var bills = $("<span class='billsBillsBills'>")
				.css({
					left : randomPosition,
					top: '-150px',
					"-webkit-animation-delay" : randomTime + "s",
					"-webkit-animation-duration" : randomSpeed + "s"
				});

				$(bills).prepend('<img src="makeItRain-master/images/bill.svg" alt="a dollar bill">');


				$('body').append(bills);

			}; // end click function

});// ready
