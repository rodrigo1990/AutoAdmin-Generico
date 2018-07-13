<script type="text/javascript">
	$(function() 
		{
			$(".latest_img").css("opacity","1.0");

			// ON MOUSE OVER
			$(".latest_img").hover(function () 
			{
				// SET OPACITY TO 100%
				$(this).stop().animate({
				opacity: 0.7
				}, "fast");
			},

			// ON MOUSE OUT
			function () 
			{
				// SET OPACITY BACK TO 50%
				$(this).stop().animate({
				opacity: 1.0
				}, "fast");
			});
		});
</script>