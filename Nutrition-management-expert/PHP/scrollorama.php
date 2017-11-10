	<script type="text/javascript" src="JS/TweenMax.min.js"></script>
    <script src="JS/lettering-0.6.1.min.js"></script>
	<script src="JS/superscrollorama.js"></script>
	<script>
		$(document).ready(function() {
			// set rotation of flash
			TweenMax.set("#newversion", {rotation: 15});

			$('body').css('visibility','visible');

			// hide content until after title animation
			$('#content-wrapper').css('display','none');
			
			// lettering.js to split up letters for animation
			$('#title-line1').lettering();
			$('#title-line2').lettering();
			$('#title-line3').lettering();
			
			// TimelineLite for title animation, then start up superscrollorama when complete
			(new TimelineLite({onComplete:initScrollAnimations}))
				.from( $('#title-line1 span'), .4, {delay: 1, css:{right:'1000px'}, ease:Back.easeOut})
				.append([
					TweenMax.from( $('#title-line3 .char1'), .25+Math.random(), {css:{top: '-200px', right:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char2'), .25+Math.random(), {css:{top: '300px', right:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char3'), .25+Math.random(), {css:{top: '-400px', right:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char4'), .25+Math.random(), {css:{top: '-200px', left:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char5'), .25+Math.random(), {css:{top: '200px', left:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char6'), .25+Math.random(), {css:{top: '-300px', right:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char7'), .25+Math.random(), {css:{top: '-200px', right:'1000px'}, ease:Elastic.easeOut}),
					TweenMax.from( $('#title-line3 .char8'), .25+Math.random(), {css:{top: '400px', left:'1000px'}, ease:Elastic.easeOut})
				]);
			
			function initScrollAnimations() {
				$('#content-wrapper').css('display','block');
				var controller = $.superscrollorama();
			
				// title tweens
				$('.title-line span').each(function() {
					controller.addTween(10, TweenMax.to(this, .5, {css:{top: Math.random()*-170-260, left: (Math.random()*1000)-500, rotation:Math.random()*720-360, 'font-size': Math.random()*300+150}, ease:Quad.easeOut}), 200);
				});
				controller.addTween(10, TweenMax.to($('#title-line3'), .75, {ease:Quad.easeOut},200));

				// showcase tweens
				$('#showcase h1').lettering();
				controller.addTween(
					'#showcase h1',
					(new TimelineLite())
						.append([
							TweenMax.from($('#showcase h1 .char1'), .5, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char2'), 1.1, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char3'), .6, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char4'), .7, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char5'), .9, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char6'), 1.2, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char7'), .6, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char8'), .8, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char9'), .5, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char10'), 1.1, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char11'), .6, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char12'), .7, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char13'), .9, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char14'), 1.2, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#showcase h1 .char15'), .5, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut})
						])
						,
					400,
					0 // offset for better timing
				);
				controller.addTween('#showcase p', TweenMax.from( $('#showcase p'), 1, {css:{opacity:0}, ease:Quad.easeOut}));
				$('#showcase .gallery figure').css('position','relative').each(function() {
					controller.addTween('#showcase .gallery', TweenMax.from( $(this), 1, {delay:Math.random()*.2,css:{left:Math.random()*200-100,top:Math.random()*200-100,opacity:0}, ease:Back.easeOut}));
				});



				

				// individual element tween examples
				controller.addTween('#fade-it', TweenMax.from( $('#fade-it'), .5, {css:{opacity: 0}}));
				controller.addTween('#fly-it', TweenMax.from( $('#fly-it'), .25, {css:{right:'500px'}, ease:Quad.easeInOut}));			
				controller.addTween('#scale-it', TweenMax.fromTo( $('#scale-it'), .25, {css:{opacity:0, fontSize:'10px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{opacity:1, fontSize:'50px'}, ease:Quad.easeInOut}));
				controller.addTween('#smush-it', TweenMax.fromTo( $('#smush-it'), .25, {css:{opacity:0, 'letter-spacing':'30px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{opacity:1, 'letter-spacing':'-10px'}, ease:Quad.easeInOut}), 0, 100); // 100 px offset for better timing

				$('#bring-it').lettering();
				controller.addTween(
					'#bring-it',
					(new TimelineLite())
						.append([
							TweenMax.from($('#bring-it .char1'), .5, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char2'), 1.1, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char3'), .6, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char4'), .7, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char5'), .9, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char6'), 1.2, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char7'), .6, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut}),
							TweenMax.from($('#bring-it .char8'), .8, 
								{css:{fontSize: 0}, immediateRender:true, ease:Elastic.easeOut})
						])
						,
					400,
					-100 // offset for better timing
				);


				<?php $row_number = $DB_con->query("SELECT COUNT(*) FROM home")->fetchColumn(); ?>
				var rows = <?php echo $row_number; ?>;
				var class_name_smush = [];
				var class_name_fade = [];
				for(var x = 0; x < rows; x++){
					class_name_smush[x] = "#smush-it-" + x;
					class_name_fade[x] = "#fade-it-" + x;
				}
				for(var x = 0; x < rows; x++){
				controller.addTween(class_name_smush[x], TweenMax.fromTo( $(class_name_smush[x]), .25, {css:{opacity:0, 'letter-spacing':'80px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{opacity:1, 'letter-spacing':'1px'}, ease:Quad.easeInOut}));
				controller.addTween(class_name_fade[x], TweenMax.from( $(class_name_fade[x]), .5, {css:{opacity: 0}}));
				}
				
				
				
			}
		});
	</script>