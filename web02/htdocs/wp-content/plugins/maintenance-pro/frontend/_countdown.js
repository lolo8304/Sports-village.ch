(function($){
	var days	= 24*60*60,
		hours	= 60*60,
		minutes	= 60;
	$.fn.countdown = function(prop){
		var options = $.extend({
			callback	: function(){},
			timestamp	: 0,
			arrLabels   : ['Days','Hours','Minutes','Seconds']
		},prop);
		
		var left, d, h, m, s, positions, ed, eh, em, es;
		init(this, options);
		positions = this.find('.position');
		
		(function tick(){
			left = Math.floor((options.timestamp - (new Date())) / 1000);
			if(left < 0) { left = 0; }
			d = Math.floor(left / days);
			updateDuo(0, 1, d);
			left -= d*days;
			h = Math.floor(left / hours);
			updateDuo(2, 3, h);
			left -= h*hours;
			m = Math.floor(left / minutes);
			updateDuo(4, 5, m);
			left -= m*minutes;
			s = left;
			updateDuo(6, 7, s);
			options.callback(d, h, m, s);
			setTimeout(tick, 1000);
		})();
		
		function updateDuo(minor,major,value){
			switchDigit(positions.eq(minor),Math.floor(value/10)%10);
			switchDigit(positions.eq(major),value%10);
		}
		return this;
	};


	function init(elem, options){
		elem.addClass('countdownHolder');
		$.each(options.arrLabels,function(i){
			
			$('<span class="digits count' +this+'"></span>').html(
				'<div class="box-digits e'+this+'">' +
					'<span class="position">' +
						'<span class="digit static">0</span>' +
					'</span>' + 
					'<span class="position">' +
						'<span class="digit static">0</span>' +
					'</span>' + 
					'<span class="bg-overlay"></span>' +
				'</div>' +
				'<span class="title-time">'+this+'</span>'
			).appendTo(elem);
			
			if(this!="Seconds"){
				elem.append('<span class="countDevider countDiv'+i+'"></span>');
			}
		});

	}

	function switchDigit(position,number){
		var digit = position.find('.digit')
		 if(digit.is(':animated')){ return false; }
		 if(position.data('digit') == number){
			return false;
		}
		position.data('digit', number);
		var replacement = $('<span>',{
			'class':'digit',
			css:{
				top:'-2.1em',
				opacity:0
			},
			html:number
		});
		
		digit
			.before(replacement)
			.removeClass('static')
			.animate({top:'1em',opacity:0},'fast',function(){
				digit.remove();
			})

		replacement
			.delay(100)
			.animate({top:0,opacity:1},'fast',function(){
				replacement.addClass('static');
			});
	}
})(jQuery);