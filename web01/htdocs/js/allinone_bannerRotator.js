/*
 * AllInOne Banner - Banner Rotator v3.3
 *
 * Copyright 2012-2013, LambertGroup
 * 
 */
(function($) {
	
		
		var effects_arr=new Array(
				'fade'
		);	
		
		var stripe_width;
		var new_stripe_width;
		var delay_time = 100;
		var delay_time_stripes_step=50;
		var delay_time_blocks_step=25;
		
		var arrowClicked=false;
		var val = navigator.userAgent.toLowerCase();
		
		
	function animate_singular_text(elem,current_obj,options) {
		if (options.responsive) {
			newCss='';
			if (elem.css('font-size').lastIndexOf('px')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('px'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'px;';
			} else if (elem.css('font-size').lastIndexOf('em')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('em'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'em;';
			}
			
			if (elem.css('line-height').lastIndexOf('px')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('px'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'px;';
			} else if (elem.css('line-height').lastIndexOf('em')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('em'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'em;';
			}
			
			elem.wrapInner('<div class="newFS" style="'+newCss+'" />');
			
		}

		var theLeft=elem.attr('data-final-left');
		var theTop=elem.attr('data-final-top');
		if (options.responsive) {
			theLeft=parseInt(theLeft/(options.origWidth/options.width),10);
			theTop=parseInt(theTop/(options.origWidth/options.width),10);
		}
  
        var opacity_aux=1;
		if (current_obj.isVideoPlaying==true)
		   opacity_aux=0;
        elem.animate({
                opacity: opacity_aux,
                left:theLeft+'px',
                top: theTop+'px'
              }, elem.attr('data-duration')*1000, function() {
                if (current_obj.isVideoPlaying==true) {
                   var texts = $(current_obj.currentImg.attr('data-text-id')).children();
				   texts.css("opacity",0);
		        }
              });			
	};
        
        
	function animate_texts(current_obj,options,allinone_bannerRotator_the,bannerControls) {
		$(current_obj.currentImg.attr('data-text-id')).css("display","block");
		var texts = $(current_obj.currentImg.attr('data-text-id')).children();

		var i=0;
		currentText_arr=Array();
		texts.each(function() {
			currentText_arr[i] = $(this);
            
            
		  var theLeft=currentText_arr[i].attr('data-initial-left');
		  var theTop=currentText_arr[i].attr('data-initial-top');
		  if (options.responsive) {
				theLeft=parseInt(theLeft/(options.origWidth/options.width),10);
				theTop=parseInt(theTop/(options.origWidth/options.width),10);
		  }		  

            currentText_arr[i].css({
				'left':theLeft+'px',
				'top':theTop+'px',
				'opacity':parseInt(currentText_arr[i].attr('data-fade-start'),10)/100
			});
            
            var currentText=currentText_arr[i];
            setTimeout(function() { animate_singular_text(currentText,current_obj,options);}, (currentText_arr[i].attr('data-delay')*1000));    
            	
            i++;
        });		
	};
		
		function shuffle(o){
			for(var j, x, i = o.length; i; j = parseInt(Math.random() * i,10), x = o[--i], o[i] = o[j], o[j] = x);
			return o;
		};		
		
	//circ
	function the_arc(current_obj,options) {
			nowx = (new Date).getTime();
			if (!current_obj.mouseOverBanner && !current_obj.effectIsRunning && options.showCircleTimer) {	 
				current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
  	            
                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
                current_obj.ctx.lineWidth = options.circleLineWidth+2;
                current_obj.ctx.strokeStyle = options.behindCircleColor;
                current_obj.ctx.stroke();
                

                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.circleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, ((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime)/1000*2/options.autoPlay*Math.PI,  false);
                current_obj.ctx.lineWidth = options.circleLineWidth;
                current_obj.ctx.strokeStyle = options.circleColor;
                current_obj.ctx.stroke();
             }
    }			
		

        // generate the stripes
        function allinone_bannerRotator_generate_stripes(allinone_bannerRotator_container,options,current_obj) {
			var ver_ie=getInternetExplorerVersion();
			$('.stripe', allinone_bannerRotator_container).remove();
			$('.block', allinone_bannerRotator_container).remove();
            stripe_width = Math.round(options.width/options.numberOfStripes);
			new_stripe_width=stripe_width;
        	var cssBgResize=true;
			for (var i = 0; i < options.numberOfStripes; i++){
				if (i == options.numberOfStripes-1) {
					new_stripe_width=allinone_bannerRotator_container.width()-stripe_width*(options.numberOfStripes-1);
					//alert (stripe_width+'  -  '+new_stripe_width);
				}
				if (!options.responsive || (ver_ie==-1) || (ver_ie!=-1 && ver_ie>=9)  ) {
					if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1) {
						cssBgResize=false;
					} else {
						allinone_bannerRotator_container.append(
							$('<div class="stripe"></div>').css({ 
								opacity:'0',
								left:(stripe_width*i)+'px', 
								width:new_stripe_width+'px',
								height:'0px', 
								background: 'url("'+ current_obj.current_imgInside.attr('src') +'") '+ (-1)*(i * stripe_width) +'px 0%'
							})
						);
					}
				} else {
					cssBgResize=false;
				}
				
				if (!cssBgResize) {
					mleft=(-1)*(stripe_width*i);
					allinone_bannerRotator_container.append(
						$('<div class="stripe"><img src="'+current_obj.current_imgInside.attr('src')+'" width="'+options.width+'" height="'+options.height+'" style="margin-left:'+mleft+'px;"></div>').css({ 
							opacity:'0',
							left:(stripe_width*i)+'px', 
							width:new_stripe_width+'px',
							height:'0px'
						})
					);						
				}
			}
			
			if (options.responsive && cssBgResize) {
				if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=9) ) {
					$('.stripe', allinone_bannerRotator_container).css({
						'-webkit-background-size':options.width+'px '+options.height+'px',
						'-moz-background-size':options.width+'px '+options.height+'px',
						'-o-background-size':options.width+'px '+options.height+'px',
						'-ms-background-size':options.width+'px '+options.height+'px',
						'background-size':options.width+'px '+options.height+'px'
					});				
			
				}
			}
        };
        
        
        // generate the blocks
        function allinone_bannerRotator_generate_blocks(allinone_bannerRotator_container,options,current_obj) {
			var ver_ie=getInternetExplorerVersion();
			$('.stripe', allinone_bannerRotator_container).remove();
			$('.block', allinone_bannerRotator_container).remove();
			var block_width = Math.round(options.width/options.numberOfColumns);
			var block_height = Math.round(options.height/options.numberOfRows);
        	var new_block_width=block_width;
			var new_block_height=block_height;
			var cur_left=0;
			var cur_top=0;
        	var cssBgResize=true;	
            for(var i = 0; i < options.numberOfRows; i++){
            	for(var j = 0; j < options.numberOfColumns; j++){
					cur_left=block_width*j;
					cur_top=block_height*i;
					
					if (j == options.numberOfColumns-1) {
						new_block_width=options.width-block_width*(options.numberOfColumns-1);
					} else {
						new_block_width=block_width;
					}
					
					if (i == options.numberOfRows-1) {
						new_block_height=options.height-block_height*(options.numberOfRows-1);
					} else {
						new_block_height=block_height;
					}					
					
					if (!options.responsive || (ver_ie==-1) || (ver_ie!=-1 && ver_ie>=9)  ) {
						if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1) {
							cssBgResize=false;
						} else {
							allinone_bannerRotator_container.append(
								$('<div class="block"></div>').css({ 
									opacity:'0',
									left:cur_left+'px', 
									top:cur_top+'px',
									width:new_block_width+'px',
									height:new_block_height+'px',
									background: 'url("'+ current_obj.current_imgInside.attr('src') +'") -'+ cur_left +'px -'+ cur_top +'px'
								})
							);
						}
					} else {
						cssBgResize=false;
					}
					if (!cssBgResize) {
						mleft=(-1)*cur_left;
						mtop=(-1)*cur_top;
						allinone_bannerRotator_container.append(
							$('<div class="block"><img src="'+current_obj.current_imgInside.attr('src')+'" width="'+options.width+'" height="'+options.height+'" style="margin-left:'+mleft+'px; margin-top:'+mtop+'px;"></div>').css({ 
								opacity:'0',
								left:cur_left+'px', 
								top:cur_top+'px',
								width:new_block_width+'px',
								height:new_block_height+'px'
							})
						);					
					}
					
            	}
			}
			if (options.responsive && cssBgResize) {
				if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=9) ) {
					$('.block', allinone_bannerRotator_container).css({
						'-webkit-background-size':options.width+'px '+options.height+'px',
						'-moz-background-size':options.width+'px '+options.height+'px',
						'-o-background-size':options.width+'px '+options.height+'px',
						'-ms-background-size':options.width+'px '+options.height+'px',
						'background-size':options.width+'px '+options.height+'px'
					});
				}
			}			
			
        };		
        
        
		function animate_block(block,i,j,options,allinone_bannerRotator_container){
            var w = block.width();
            var h = block.height();
            block.css({
				'width':'0',
				'height':'0'
			});
            if (i==options.numberOfRows-1 && j==options.numberOfColumns-1) 
            	setTimeout(function(){
					block.animate({ opacity:'1.0', width:w, height:h }, (options.effectDuration*1000)/3 , '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
				}, (delay_time));               	
            else	
				setTimeout(function(){
					block.animate({ opacity:'1.0', width:w, height:h }, (options.effectDuration*1000)/3 );
				}, (delay_time));
			delay_time += delay_time_blocks_step;
		};
        
		
        // navigation
		function allinone_bannerRotator_navigation(direction,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs){
			var navigateAllowed=true;
			if ((!options.loop && current_obj.current_img_no+direction>=total_images) || (!options.loop && current_obj.current_img_no+direction<0))
				navigateAllowed=false;				
			
			if (navigateAllowed) {
				$('.newFS', allinone_bannerRotator_container ).contents().unwrap();
				
				//current_obj.arcInitialTime=(new Date).getTime();
				//current_obj.timeElapsed=0;			
				if (options.showCircleTimer) {
						//clearInterval(current_obj.intervalID);
	
						current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
						current_obj.ctx.lineWidth = options.circleLineWidth+2;
						current_obj.ctx.strokeStyle = options.behindCircleColor;
						current_obj.ctx.stroke();            
						
						
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.circleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
						current_obj.ctx.lineWidth = options.circleLineWidth;
						current_obj.ctx.strokeStyle = options.circleColor;
						current_obj.ctx.stroke();	
								
						//current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
				}				
				
				//hide previous texts
				$(current_obj.currentImg.attr('data-text-id')).css("display","none");
				
				//deactivate previous
				$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
				
				//set current img
				if (options.randomizeImages && !current_obj.bottomNavClicked) {
					var rand_no=Math.floor(Math.random() * total_images);
					if (current_obj.current_img_no===rand_no)
						current_obj.current_img_no=Math.floor(Math.random() * total_images);
					else
						current_obj.current_img_no=rand_no;
				} else {
					if (current_obj.current_img_no+direction>=total_images) {
						current_obj.current_img_no=0;
					} else if (current_obj.current_img_no+direction<0) {
						current_obj.current_img_no=total_images-1;
					} else {
						current_obj.current_img_no+=direction;
					}
				}
				current_obj.bottomNavClicked=false;
				//activate current
				$(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');
				
				current_obj.currentImg = $(imgs[current_obj.current_img_no]);
	            current_obj.current_imgInside=current_obj.currentImg.find('img:first');
	            
	            
				//set current_effect
				if(current_obj.currentImg.attr('data-transition')){
					current_effect = current_obj.currentImg.attr('data-transition');
					if (current_effect=='random') {
								current_effect=effects_arr[Math.floor(Math.random()*(effects_arr.length))];
					}
	      } else if (options.defaultEffect!='random') {
	            	current_effect=options.defaultEffect;	            	
	      } else {
	            	current_effect=effects_arr[Math.floor(Math.random()*(effects_arr.length))];
	      }

				current_obj.effectIsRunning=true;
				if(current_effect == 'fade' || current_effect == 'slideFromLeft' || current_effect == 'slideFromRight' || current_effect == 'slideFromTop' || current_effect == 'slideFromBottom'){
					allinone_bannerRotator_generate_stripes(allinone_bannerRotator_container,options,current_obj);
					var first_stripe = $('.stripe:first', allinone_bannerRotator_container);
					
					if (current_effect == 'fade') {
						first_stripe.css({
							'top':'0px',
		                    'height': '100%',
		                    'width': allinone_bannerRotator_container.width() + 'px'
		                });
						//alert (first_stripe.css('top'));
						first_stripe.animate({ opacity:'1.0' }, (options.effectDuration*2000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
					}
					
					if (current_effect == 'slideFromLeft') {
						first_stripe.css({
							'top':'0px',
		                    'height': '100%',
		                    'width': '0'
		                });
						first_stripe.animate({ opacity:'1.0', width:allinone_bannerRotator_container.width() + 'px' }, (options.effectDuration*1000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
					}
					
					if (current_effect == 'slideFromRight') {
						first_stripe.css({
							'top':'0px',
		                    'height': '100%',
		                    'width':  '0',
		                    'left': allinone_bannerRotator_container.width()+5 + 'px'
		                });
						first_stripe.animate({ opacity:'1.0', left:'0', 'width':  allinone_bannerRotator_container.width() + 'px' }, (options.effectDuration*1000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
					}

					if (current_effect == 'slideFromTop') {
						first_stripe.css({
							'top':'0px',
		                    'height': '0',
		                    'width': allinone_bannerRotator_container.width() + 'px'
		                });
						first_stripe.animate({ opacity:'1.0', height:allinone_bannerRotator_container.height() + 'px' }, (options.effectDuration*1000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
					}
					
					if (current_effect == 'slideFromBottom') {
						first_stripe.css({
							'top':'0px',
		                    'height': '0',
		                    'width': allinone_bannerRotator_container.width() + 'px',
		                    'top': allinone_bannerRotator_container.height() + 'px'
		                });
						first_stripe.animate({ opacity:'1.0', top:0, height:allinone_bannerRotator_container.height() + 'px' }, (options.effectDuration*1000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
					}					
					
				}   
				
				if(current_effect.indexOf('Stripes')>=0) {
					allinone_bannerRotator_generate_stripes(allinone_bannerRotator_container,options,current_obj);
					if (current_effect.indexOf('Reverse')>=0){
						var stripes = $('.stripe', allinone_bannerRotator_container).myReverse();
					} else {
						var stripes = $('.stripe', allinone_bannerRotator_container);
					}
					delay_time = 100;
					i = 0;
					stripes.each(function(){
						var stripe = $(this);
						//setting the css for stripes according to current effect
						if(current_effect=='topBottomDroppingStripes' || current_effect=='topBottomDroppingReverseStripes')
							stripe.css({ 'top': '0px' });
						if(current_effect=='bottomTopDroppingStripes' || current_effect=='bottomTopDroppingReverseStripes')
							stripe.css({ 'bottom': '0px' });
						if(current_effect=='leftRightFadingStripes' || current_effect=='leftRightFadingReverseStripes')
							stripe.css({ 'top': '0px', 'height':'100%', 'width':'0' });						
						if (current_effect=='asynchronousDroppingStripes') {
							if (i % 2)
								stripe.css({ 'top': '0px' });
							else
								stripe.css({ 'bottom': '0px' });
						} 
						
						if(current_effect=='leftRightFadingStripes' || current_effect=='leftRightFadingReverseStripes') {
							var aux_stripe_width=stripe_width;
							if ( (current_effect=='leftRightFadingStripes' && i == options.numberOfStripes-1) || (current_effect=='leftRightFadingReverseStripes' && i==0) )
								aux_stripe_width=new_stripe_width;								
							
							if(i == options.numberOfStripes-1){
								setTimeout(function(){
									stripe.animate({ width:aux_stripe_width+'px', opacity:'1.0' }, (options.effectDuration*800), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
								}, (delay_time));
							} else {
								setTimeout(function(){
									stripe.animate({ width:aux_stripe_width+'px', opacity:'1.0' }, (options.effectDuration*800) );
								}, (delay_time));
							}							
						} else {
								if(i == options.numberOfStripes-1){
									setTimeout(function(){
										stripe.animate({ height:'100%', opacity:'1.0' }, (options.effectDuration*1000), '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
									}, (delay_time));
								} else {
									setTimeout(function(){
										stripe.animate({ height:'100%', opacity:'1.0' }, (options.effectDuration*1000) );
									}, (delay_time));
								}
						}
						delay_time += delay_time_stripes_step;
						i++;
					});
				} //if stripes
				
				if(current_effect.indexOf('Blocks')>=0) {
					allinone_bannerRotator_generate_blocks(allinone_bannerRotator_container,options,current_obj);
					if (current_effect.indexOf('Reverse')>=0){
						var blocks = $('.block', allinone_bannerRotator_container).myReverse();
					} else if (current_effect=='randomBlocks') {
						var blocks = shuffle($('.block', allinone_bannerRotator_container));
					} else {
						var blocks = $('.block', allinone_bannerRotator_container);
					}
					delay_time = 100;
					
					if (current_effect=='randomBlocks') {
						i=0;
						var total_blocks = options.numberOfRows*options.numberOfColumns;
						blocks.each(function(){
							var block = $(this);
			                var w = block.width();
			                var h = block.height();
			                block.css({
								'width':'0',
								'height':'0'
							});
							if(i == total_blocks-1){
			                	setTimeout(function(){
									block.animate({ opacity:'1.0', width:w, height:h }, (options.effectDuration*1000)/3 , '', function(){ allinone_bannerRotator_container.trigger('effectComplete'); });
								}, (delay_time));               	
							} else {
								setTimeout(function(){
									block.animate({ opacity:'1.0', width:w, height:h }, (options.effectDuration*1000)/3 );
								}, (delay_time));
							}
							delay_time += delay_time_blocks_step;
							i++;
						});						
					} else {

							var row_i=0;
							var col_i=0;
							var blocks_arr=new Array();
							blocks_arr[row_i] = new Array();
							blocks.each(function(){
									blocks_arr[row_i][col_i] = $(this);
									col_i++;
									if(col_i == options.numberOfColumns){
										row_i++;
										col_i = 0;
										blocks_arr[row_i] = new Array();
									}
							});
		
							//first part
							row_i=0;
							col_i=0;
							delay_time = 100;
							var block = $(blocks_arr[row_i][col_i]);
							animate_block(block,0,0,options,allinone_bannerRotator_container);
							while (row_i<options.numberOfRows-1 || col_i<options.numberOfColumns-1) {
								if (row_i<options.numberOfRows-1)
									row_i++;
								if (col_i<options.numberOfColumns-1)
									col_i++;
		
								i=row_i;
								if (col_i<row_i && options.numberOfRows>options.numberOfColumns)
									i=row_i-col_i;
								j=0;
								if (row_i<col_i && options.numberOfRows<options.numberOfColumns)
									j=col_i-row_i;
								while (i>=0 && j<=col_i) {
									var block = $(blocks_arr[i--][j++]);
									animate_block(block,i,j,options,allinone_bannerRotator_container);
								}
		
							}
							
							//last part
							if (options.numberOfRows<options.numberOfColumns)
								delay_time-=(options.numberOfRows-1)*delay_time_blocks_step;
							else
								delay_time-=(options.numberOfColumns-1)*delay_time_blocks_step;
							
							limit_i=0;
							limit_j=col_i-row_i;
							while (limit_i<row_i && limit_j<col_i) {
								i=row_i+1; //options.numberOfRows-1;
								j=limit_j;
								while (i>limit_i && j<col_i) {
									i=i-1;
									j=j+1;							
									var block = $(blocks_arr[i][j]);
									animate_block(block,i,j,options,allinone_bannerRotator_container);
								}
								limit_i++;
								limit_j++;
							}
		
					} // else randomBlocks
				} // if blocks
				
			} // if navigateAllowed
			
		};
		

			function doResize(current_obj,options,current_effect,total_images,imgs,allinone_bannerRotator_the,bannerControls,allinone_bannerRotator_container,bottomNavButs,allinone_bannerRotator_leftNav,bottomNavBut,allinone_bannerRotator_bottomNav,allinone_bannerRotator_bottomNavLeft,allinone_bannerRotator_bottomNavRight,allinone_bannerRotator_rightNav) {
					var ver_ie=getInternetExplorerVersion();
					/*var bodyOverflow_initial=$('body').css('overflow');
					$('body').css('overflow','hidden');*/
					if (options.enableTouchScreen) {
						responsiveWidth=allinone_bannerRotator_the.parent().parent().parent().width();
						responsiveHeight=allinone_bannerRotator_the.parent().parent().parent().height();
					} else {
						responsiveWidth=allinone_bannerRotator_the.parent().parent().width();
						responsiveHeight=allinone_bannerRotator_the.parent().parent().height();						
					}
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}

					if (options.width100Proc) {
						options.width=responsiveWidth;
					}
					
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}

					if (options.skin=='attractive') {
						options.isAttractiveResp=false;
						allinone_bannerRotator_rightNav.css("right",options.rightVal+"px");
					}
					if (options.origWidth!=responsiveWidth || options.width100Proc) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
							options.isAttractiveResp=true;
							if (options.skin=='attractive')
								allinone_bannerRotator_rightNav.css("right",options.rightVal-1+"px");
						} else if (!options.width100Proc) {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/current_obj.bannerRatio;
						
						options.width=parseInt(options.width,10);
						options.height=parseInt(options.height,10);						
						
						if (options.enableTouchScreen && options.responsive)
							options.width-=1;
						
						//set banner size
						allinone_bannerRotator_container.width(options.width);
						allinone_bannerRotator_container.height(options.height);
						
						
					if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1 || (ver_ie!=-1 && ver_ie<=7)) {
						$('#curBgImgIos', allinone_bannerRotator_container).attr('src',current_obj.current_imgInside.attr("src"));
						$('#curBgImgIos', allinone_bannerRotator_container).width(options.width);
						$('#curBgImgIos', allinone_bannerRotator_container).height(options.height);
					} else {						
						if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=9) ) {
							allinone_bannerRotator_container.css({
								'-webkit-background-size':options.width+'px '+options.height+'px',
								'-moz-background-size':options.width+'px '+options.height+'px',
								'-o-background-size':options.width+'px '+options.height+'px',
								'-ms-background-size':options.width+'px '+options.height+'px',
								'background-size':options.width+'px '+options.height+'px'
							});
						} else if (ver_ie==8) {
							allinone_bannerRotator_container.css({filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+current_obj.current_imgInside.attr('src')+"',sizingMethod='scale')"});	
						}
					}
						if (options.enableTouchScreen) {
							allinone_bannerRotator_container.parent().width(options.width+1);
							allinone_bannerRotator_container.parent().height(options.height);
						}
						
						
						bannerControls.css('margin-top',parseInt((options.height-allinone_bannerRotator_leftNav.height())/2,10)+'px');

						for (i=0; i<total_images; i++) {
							//reposition text
							$($(imgs[i]).attr('data-text-id')).css('width',allinone_bannerRotator_the.width()+'px');
						}


							allinone_bannerRotator_bottomNav.css("left",parseInt((allinone_bannerRotator_container.width()-allinone_bannerRotator_bottomNav.width())/2,10)+'px');
							allinone_bannerRotator_bottomNavLeft.css("left",parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)-allinone_bannerRotator_bottomNavLeft.width()+'px');
							allinone_bannerRotator_bottomNavRight.css("left",parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)+allinone_bannerRotator_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px');							
							
							/*if (options.width100Proc && options.height100Proc || options.skin=='attractive') {
								// nothing
							} else {
								allinone_bannerRotator_bottomNav.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
								allinone_bannerRotator_bottomNavLeft.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
								allinone_bannerRotator_bottomNavRight.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});									
							}*/


						clearTimeout(current_obj.timeoutID);
					
						allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs);

					}
					

					//$('body').css('overflow',bodyOverflow_initial);
			}	
		

			function getInternetExplorerVersion()
			// -1 - not IE
			// 7,8,9 etc
			{
			   var rv = -1; // Return value assumes failure.
			   if (navigator.appName == 'Microsoft Internet Explorer')
			   {
				  var ua = navigator.userAgent;
				  var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
				  if (re.exec(ua) != null)
					 rv = parseFloat( RegExp.$1 );
			   }
			   return parseInt(rv,10);
			}			
		
	
	$.fn.allinone_bannerRotator = function(options) {
		
		var options = $.extend({},$.fn.allinone_bannerRotator.defaults, options);

		return this.each(function() {
			var allinone_bannerRotator_the = $(this);
					responsiveWidth=allinone_bannerRotator_the.parent().width();
					responsiveHeight=allinone_bannerRotator_the.parent().height();
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}			

					options.origWidth=options.width;
					if (options.width100Proc)
						options.width=responsiveWidth;
					
					options.origHeight=options.height;
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}

					if (options.responsive && (options.origWidth!=responsiveWidth || options.width100Proc)) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
						} else {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/(options.origWidth/options.origHeight);	
					}
					
					options.width=parseInt(options.width,10);
					options.height=parseInt(options.height,10);
			
						if (options.enableTouchScreen && options.responsive)
							options.width-=1;			
			
			allinone_bannerRotator_the.css("display","block");
			
			//the controllers
			var allinone_bannerRotator_wrap = $('<div></div>').addClass('allinone_bannerRotator').addClass(options.skin);
			var bannerControlsDef = $('<div class="bannerControls">   <div class="leftNav"></div>   <div class="rightNav"></div>      </div> <canvas class="mycanvas"></canvas>');
			allinone_bannerRotator_the.wrap(allinone_bannerRotator_wrap);
			allinone_bannerRotator_the.after(bannerControlsDef);
			

			
			//the elements
			var allinone_bannerRotator_container = allinone_bannerRotator_the.parent('.allinone_bannerRotator');
			var bannerControls = $('.bannerControls', allinone_bannerRotator_container);
			
			var bottomNavLeft_aux=$('<div class="bottomNavLeft"></div>');
			var bottomNav_aux=$('<div class="bottomNav"></div>');
			var bottomNavRight_aux=$('<div class="bottomNavRight"></div>');
			
			allinone_bannerRotator_the.after(bottomNavLeft_aux);
			allinone_bannerRotator_the.after(bottomNav_aux);
			allinone_bannerRotator_the.after(bottomNavRight_aux);
			 
			if (!options.showAllControllers)
				bannerControls.css("display","none");			
			
			
			var allinone_bannerRotator_leftNav = $('.leftNav', allinone_bannerRotator_container);
			var allinone_bannerRotator_rightNav = $('.rightNav', allinone_bannerRotator_container);
			allinone_bannerRotator_leftNav.css("display","none");
			allinone_bannerRotator_rightNav.css("display","none");			
			if (options.showNavArrows) {
				if (options.showOnInitNavArrows) {
					allinone_bannerRotator_leftNav.css("display","block");
					allinone_bannerRotator_rightNav.css("display","block");
				}
			}
			
			var allinone_bannerRotator_bottomNav = $('.bottomNav', allinone_bannerRotator_container);
			var allinone_bannerRotator_bottomNavLeft = $('.bottomNavLeft', allinone_bannerRotator_container);
			var allinone_bannerRotator_bottomNavRight = $('.bottomNavRight', allinone_bannerRotator_container);
			var allinone_bannerRotator_bottomOverThumb;
			allinone_bannerRotator_bottomNav.css("display","block");
			allinone_bannerRotator_bottomNavLeft.css("display","block");
			allinone_bannerRotator_bottomNavRight.css("display","block");
				allinone_bannerRotator_bottomNav.css("top",options.height+'px');
				//if (options.width100Proc && options.height100Proc || options.skin=='attractive') {
					allinone_bannerRotator_bottomNav.css({"bottom":options.thumbsWrapperMarginBottom+"px", "top":"auto"});
					allinone_bannerRotator_bottomNavLeft.css({"bottom":options.thumbsWrapperMarginBottom+"px", "top":"auto"});
					allinone_bannerRotator_bottomNavRight.css({"bottom":options.thumbsWrapperMarginBottom+"px", "top":"auto"});
				/*} else {
					allinone_bannerRotator_bottomNav.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
					allinone_bannerRotator_bottomNavLeft.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
					allinone_bannerRotator_bottomNavRight.css({"bottom":options.thumbsWrapperMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
				}*/
		
			
			if (!options.showBottomNav) {
				allinone_bannerRotator_bottomNav.css("display","none");
				allinone_bannerRotator_bottomNavLeft.css("display","none");
				allinone_bannerRotator_bottomNavRight.css("display","none");
			}
			if (!options.showOnInitBottomNav) {
				allinone_bannerRotator_bottomNav.css("left","-5000px");
				allinone_bannerRotator_bottomNavLeft.css("left","-5000px");
				allinone_bannerRotator_bottomNavRight.css("left","-5000px");				
			}
			
			var ver_ie=getInternetExplorerVersion();
			
			//the vars
			var current_effect=options.defaultEffect;
			var total_images=0;
			var current_obj = {
				current_img_no:0,
				currentImg:0,
				current_imgInside:'',
				bottomNavClicked:false,
				effectIsRunning:false,
				mouseOverBanner:false,
				rightVal:0,
				isAttractiveResp:false,
				timeoutID:'',
				intervalID:'',
				arcInitialTime:(new Date).getTime(),
				timeElapsed:0,
				windowWidth:0,
				canvas:'',
				ctx:'',
				bannerRatio:options.origWidth/options.origHeight				
			};
			

			var i = 0;


			current_obj.canvas = $('.mycanvas', allinone_bannerRotator_container)[0];
			current_obj.canvas.width=2*options.circleRadius+4*options.circleLineWidth;
			current_obj.canvas.height=2*options.circleRadius+4*options.circleLineWidth;			
			
			if (ver_ie!=-1 && ver_ie<9) {
			   options.showCircleTimer=false;
			}
			if (options.showCircleTimer) {				
				current_obj.ctx = current_obj.canvas.getContext('2d');
			}

			
			//set banner size
			allinone_bannerRotator_container.width(options.width);
			allinone_bannerRotator_container.height(options.height);
			
			/*bannerControls.width('100%');
			bannerControls.height('100%');*/
			bannerControls.css('margin-top',parseInt((options.height-allinone_bannerRotator_leftNav.height())/2,10)+'px');
			
			//get images
			var theul= allinone_bannerRotator_the.find('ul:first');
			var imgs = theul.children();
			var bottomNavBut;
			var bottomNavWidth=0;
			var bottomNavMarginTop=0;
			imgs.each(function() {
	            current_obj.currentImg = $(this);
	            if(!current_obj.currentImg.is('li')){
	            	current_obj.currentImg = current_obj.currentImg.find('li:first');
	            }
	            	
	            if(current_obj.currentImg.is('li')){
	            	current_obj.currentImg.css('display','none');
	            	total_images++;

	            
		            //generate bottomNav
		            bottomNavBut = $('<div class="bottomNavButtonOFF" rel="'+ (total_images-1) +'"></div>');
		            allinone_bannerRotator_bottomNav.append(bottomNavBut);
		            
		            
		            bottomNavWidth+=parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+bottomNavBut.width();
		            bottomNavMarginTop=parseInt((allinone_bannerRotator_bottomNav.height()-parseInt(bottomNavBut.css('height').substring(0, bottomNavBut.css('height').length-2)))/2,10);

		            bottomNavBut.css('margin-top',bottomNavMarginTop+'px');
	            }	            

	        });		
			allinone_bannerRotator_bottomNav.width(bottomNavWidth);
			if (options.showOnInitBottomNav) {
				allinone_bannerRotator_bottomNav.css("left",parseInt((allinone_bannerRotator_container.width()-bottomNavWidth)/2,10)+'px');
				allinone_bannerRotator_bottomNavLeft.css("left",parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)-allinone_bannerRotator_bottomNavLeft.width()+'px');
				allinone_bannerRotator_bottomNavRight.css("left",parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)+allinone_bannerRotator_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px');
			}
			
			
	        //initialize first number image
			current_obj.current_img_no = options.firstImg;
			if (options.firstImg>total_images)
				current_obj.current_img_no=total_images;
			if (options.firstImg<0)
				current_obj.current_img_no=0;			
           
        
			//initialize first image number if randomize option is set
			if(options.randomizeImages){
	        	current_obj.current_img_no = Math.floor(Math.random() * total_images);
	        }
	        
	        
	        //Get first image (using initialized above current_obj.current_img_no) and init first bg
            current_obj.currentImg = $(imgs[current_obj.current_img_no]);
			current_obj.current_imgInside=current_obj.currentImg.find('img:first');
			
			
				if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1 || (ver_ie!=-1 && ver_ie<=7)) {
						allinone_bannerRotator_container.append('<img id="curBgImgIos" src="'+ current_obj.current_imgInside.attr("src") +'" width="'+options.width+'" height="'+options.height+'">');
				} else {
					allinone_bannerRotator_container.css('background','url("'+ current_obj.current_imgInside.attr('src') +'") no-repeat');
					if (options.responsive) {
						if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=9) ) {
							allinone_bannerRotator_container.css({
								'-webkit-background-size':options.width+'px '+options.height+'px',
								'-moz-background-size':options.width+'px '+options.height+'px',
								'-o-background-size':options.width+'px '+options.height+'px',
								'-ms-background-size':options.width+'px '+options.height+'px',
								'background-size':options.width+'px '+options.height+'px'
							});
							
						} else if (ver_ie==8) {
							allinone_bannerRotator_container.css({filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+current_obj.current_imgInside.attr('src')+"',sizingMethod='scale')"});	
						}
					}
			}


			if (options.enableTouchScreen) {
				var randomNo=Math.floor(Math.random()*100000);
				
				allinone_bannerRotator_container.wrap('<div id="bannerRotatorParent_'+randomNo+'" style="position:relative;" />');
				$('#bannerRotatorParent_'+randomNo).width(options.width+1);
				$('#bannerRotatorParent_'+randomNo).height(options.height);
			
				allinone_bannerRotator_container.css({
					'cursor':'url('+options.absUrl+'img/attractiveFullwidth/nav_slider/hand.cur),url('+options.absUrl+'img/attractiveFullwidth/nav_slider/hand.cur),move',
					'left':'0px',
					'position':'absolute'
				});
				

				options.rightVal=parseInt(allinone_bannerRotator_rightNav.css('right').substring(0, allinone_bannerRotator_rightNav.css('right').length-2),10);
				if (options.skin=='attractive' && options.width100Proc)
							allinone_bannerRotator_rightNav.css("right",options.rightVal-1+"px");
				
				//$("body").css("overflow", "hidden");
				
				allinone_bannerRotator_container.mousedown(function() {
					if (options.rightVal<0 && !arrowClicked) {
						allinone_bannerRotator_rightNav.css({
							'visibility':'hidden',
							'right':'0'
						});
						if ((options.skin=='attractive' && options.width100Proc) || (options.skin=='attractive' && options.isAttractiveResp))
								allinone_bannerRotator_rightNav.css("right",options.rightVal-1+"px");
						allinone_bannerRotator_leftNav.css('visibility','hidden');
					}
				});	
				allinone_bannerRotator_container.mouseup(function() {
					arrowClicked=false;
					if (options.rightVal<0) {	
						allinone_bannerRotator_rightNav.css({
							'right':options.rightVal+'px',
							'visibility':'visible'
						});
						if ((options.skin=='attractive' && options.width100Proc) || (options.skin=='attractive' && options.isAttractiveResp))
								allinone_bannerRotator_rightNav.css("right",options.rightVal-1+"px");						
						allinone_bannerRotator_leftNav.css('visibility','visible');							
					}
				});					
				
				allinone_bannerRotator_container.draggable({ 
					axis: 'x',
					containment: 'parent',
					//scroll:false,
					//revert:true,
					start: function(event, ui) {
						origLeft=$(this).css('left');
					},
					stop: function(event, ui) {
						if (!current_obj.effectIsRunning) {
							finalLeft=$(this).css('left');
							direction=1;
							if (origLeft<finalLeft) {
								direction=-1;
							}	

							allinone_bannerRotator_navigation(direction,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs);
						}
						if (options.rightVal<0) {	
							allinone_bannerRotator_rightNav.css({
								'right':options.rightVal+'px',
								'visibility':'visible'
							});
							if ((options.skin=='attractive' && options.width100Proc) || (options.skin=='attractive' && options.isAttractiveResp))
								allinone_bannerRotator_rightNav.css("right",options.rightVal-1+"px");
							allinone_bannerRotator_leftNav.css('visibility','visible');							
						}
						$(this).css('left','0px');
					}
				});
			}		        
	        
	        
	        //generate the text for first image
			animate_texts(current_obj,options,allinone_bannerRotator_the,bannerControls);
	        
			

	        //Event when Animation finishes
			allinone_bannerRotator_container.bind('effectComplete', function(){
				var ver_ie=getInternetExplorerVersion();
				current_obj.effectIsRunning=false;
				
				
					if (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1 || (ver_ie!=-1 && ver_ie<=7)) {
						$('#curBgImgIos', allinone_bannerRotator_container).attr('src',current_obj.current_imgInside.attr("src"));
						$('#curBgImgIos', allinone_bannerRotator_container).width(options.width);
						$('#curBgImgIos', allinone_bannerRotator_container).height(options.height);
					} else {
						allinone_bannerRotator_container.css('background','url("'+ current_obj.current_imgInside.attr('src') +'") no-repeat');
						if (options.responsive) {
							if (ver_ie==-1 || (ver_ie!=-1 && ver_ie>=9) ) {
								allinone_bannerRotator_container.css({
									'-webkit-background-size':options.width+'px '+options.height+'px',
									'-moz-background-size':options.width+'px '+options.height+'px',
									'-o-background-size':options.width+'px '+options.height+'px',
									'-ms-background-size':options.width+'px '+options.height+'px',
									'background-size':options.width+'px '+options.height+'px'
								});
								
							} else if (ver_ie==8) {
								allinone_bannerRotator_container.css({filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+current_obj.current_imgInside.attr('src')+"',sizingMethod='scale')"});	
							}
					}
				}

				
				current_obj.arcInitialTime=(new Date).getTime();
				current_obj.timeElapsed=0;			
				if (options.showCircleTimer) {
						clearInterval(current_obj.intervalID);
	
						current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
						current_obj.ctx.lineWidth = options.circleLineWidth+2;
						current_obj.ctx.strokeStyle = options.behindCircleColor;
						current_obj.ctx.stroke();            
						
						
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.circleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
						current_obj.ctx.lineWidth = options.circleLineWidth;
						current_obj.ctx.strokeStyle = options.circleColor;
						current_obj.ctx.stroke();	
								
						current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
				}


				animate_texts(current_obj,options,allinone_bannerRotator_the,bannerControls);
				
				if (options.autoPlay>0 && total_images>1 && !current_obj.mouseOverBanner) {
					clearTimeout(current_obj.timeoutID);
					current_obj.timeoutID=setTimeout(function(){ allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs)},options.autoPlay*1000);
				}				
	        }); //bind
			
			
			//pause on hover
			allinone_bannerRotator_container.mouseenter(function() {
				current_obj.mouseOverBanner=true;
				
				clearTimeout(current_obj.timeoutID);
				nowx = (new Date).getTime();
				current_obj.timeElapsed=current_obj.timeElapsed+(nowx-current_obj.arcInitialTime);
								
				if (options.autoHideNavArrows && options.showNavArrows) {
					allinone_bannerRotator_leftNav.css("display","block");
					allinone_bannerRotator_rightNav.css("display","block");
				}
				if (options.autoHideBottomNav && options.showBottomNav) {
					allinone_bannerRotator_bottomNav.css({
						'display':'block',
						'left':parseInt((allinone_bannerRotator_container.width()-bottomNavWidth)/2,10)+'px'
					});
					
					allinone_bannerRotator_bottomNavLeft.css({
						'display':'block',
						'left':parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)-allinone_bannerRotator_bottomNavLeft.width()+'px'
					});
					
					allinone_bannerRotator_bottomNavRight.css({
						'display':'block',
						'left':parseInt(allinone_bannerRotator_bottomNav.css('left').substring(0, allinone_bannerRotator_bottomNav.css('left').length-2),10)+allinone_bannerRotator_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px'
					});
				}				
			});
			
			allinone_bannerRotator_container.mouseleave(function() {
				current_obj.mouseOverBanner=false;
				nowx = (new Date).getTime();
				if (options.autoHideNavArrows && options.showNavArrows) {
					allinone_bannerRotator_leftNav.css("display","none");
					allinone_bannerRotator_rightNav.css("display","none");
				}
				if (options.autoHideBottomNav && options.showBottomNav) {
					allinone_bannerRotator_bottomNav.css("display","none");
					allinone_bannerRotator_bottomNavLeft.css("display","none");
					allinone_bannerRotator_bottomNavRight.css("display","none");
				}				
				if (options.autoPlay>0 && total_images>1) {
					clearTimeout(current_obj.timeoutID);
				    current_obj.arcInitialTime = (new Date).getTime();
					var new_delay = parseInt(options.autoPlay*1000-((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime),10);
										
					current_obj.timeoutID=setTimeout(function(){ allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs)},new_delay);
				}
			});
			
			allinone_bannerRotator_container.click(function() {
				if ($(imgs[current_obj.current_img_no]).attr('data-link')!=undefined && !current_obj.effectIsRunning && $(imgs[current_obj.current_img_no]).attr('data-link')!='') {
					var cur_target=options.target;
					if ($(imgs[current_obj.current_img_no]).attr('data-target')!=undefined && $(imgs[current_obj.current_img_no]).attr('data-target')!=''){
						cur_target=$(imgs[current_obj.current_img_no]).attr('data-target');
					}
					
					if (cur_target=="_blank")
						window.open($(imgs[current_obj.current_img_no]).attr('data-link'));
					else
						window.location = $(imgs[current_obj.current_img_no]).attr('data-link');
				}	
			});
			
			
			//controllers
			allinone_bannerRotator_leftNav.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.effectIsRunning) {
					//current_obj.mouseOverBanner=false;
					clearTimeout(current_obj.timeoutID);
					allinone_bannerRotator_navigation(-1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs);
				}
			});
			allinone_bannerRotator_leftNav.mouseup(function() {
				arrowClicked=false;
			});				
			
			allinone_bannerRotator_rightNav.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.effectIsRunning) {
					//current_obj.mouseOverBanner=false;
					clearTimeout(current_obj.timeoutID);
					allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs);
				}
			});
			allinone_bannerRotator_rightNav.mouseup(function() {
				arrowClicked=false;
			});			
			

			var TO = false;
			$(window).resize(function() {
				var ver_ie=getInternetExplorerVersion();
				doResizeNow=true;
				if (navigator.userAgent.indexOf('Android') != -1) {
					if (options.windowOrientationScreenSize0==0 && window.orientation==0)
						options.windowOrientationScreenSize0=$(window).width();
						
					if (options.windowOrientationScreenSize90==0 && window.orientation==90)
						options.windowOrientationScreenSize90=$(window).height();	
						
					if (options.windowOrientationScreenSize_90==0 && window.orientation==-90)
						options.windowOrientationScreenSize_90=$(window).height();						
					
					if (options.windowOrientationScreenSize0 && window.orientation==0 && $(window).width()>options.windowOrientationScreenSize0)	
						doResizeNow=false;

					if (options.windowOrientationScreenSize90 && window.orientation==90 && $(window).height()>options.windowOrientationScreenSize90)	
						doResizeNow=false;
						
					if (options.windowOrientationScreenSize_90 && window.orientation==-90 && $(window).height()>options.windowOrientationScreenSize_90)	
						doResizeNow=false;		
						
					if (current_obj.windowWidth==0) {
						doResizeNow=false;
						current_obj.windowWidth=$(window).width();
					}

				}
				
				if (ver_ie!=-1 && ver_ie==9 && current_obj.windowWidth==0)
					doResizeNow=false;
				
				
				if (current_obj.windowWidth==$(window).width()) {
					doResizeNow=false;
					if (options.windowCurOrientation!=window.orientation && navigator.userAgent.indexOf('Android') != -1) {
						options.windowCurOrientation=window.orientation;
						doResizeNow=true;
					}
				} else {
					/*if (current_obj.windowWidth===0 && (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1))
						doResizeNow=false;*/
					current_obj.windowWidth=$(window).width();
				}

				if (options.responsive && doResizeNow) {
					 if(TO !== false)
						clearTimeout(TO);
					 
					
					 TO = setTimeout(function(){ doResize(current_obj,options,current_effect,total_images,imgs,allinone_bannerRotator_the,bannerControls,allinone_bannerRotator_container,bottomNavButs,allinone_bannerRotator_leftNav,bottomNavBut,allinone_bannerRotator_bottomNav,allinone_bannerRotator_bottomNavLeft,allinone_bannerRotator_bottomNavRight,allinone_bannerRotator_rightNav) }, 300); //200 is time in miliseconds
				}
			});
			
			
			
			//bottom nav
			var bottomNavButs=$(".bottomNavButtonOFF", allinone_bannerRotator_container);
			bottomNavButs.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.effectIsRunning) {
					var currentBut=$(this);
					var i=currentBut.attr('rel');
					//deactivate previous 
					$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
					
					current_obj.bottomNavClicked=true;
					current_obj.current_img_no=i-1;
					allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs);
				}
			});
			bottomNavButs.mouseup(function() {
				arrowClicked=false;
			});				
			
			
			bottomNavButs.mouseenter(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');
				
				
				if (options.showPreviewThumbs) {
					allinone_bannerRotator_bottomOverThumb = $('<div class="bottomOverThumb"></div>');
					currentBut.append(allinone_bannerRotator_bottomOverThumb);
					var image_name=$(imgs[i]).attr('data-bottom-thumb');
					allinone_bannerRotator_bottomOverThumb.html('<img src="' + image_name + '">');
				}
				
				currentBut.addClass('bottomNavButtonON');
			});
			
			bottomNavButs.mouseleave(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');

				if (options.showPreviewThumbs) {
					allinone_bannerRotator_bottomOverThumb.remove();
				}				
				
				if (current_obj.current_img_no!=i)
					currentBut.removeClass('bottomNavButtonON');
			});			
			
			//first start autoplay
			$(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');
			if (options.autoPlay>0 && total_images>1) {
				if (options.showCircleTimer) {
					current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
				}
				current_obj.timeoutID=setTimeout(function(){ allinone_bannerRotator_navigation(1,options,current_obj,total_images,current_effect,allinone_bannerRotator_container,bottomNavButs,imgs)},options.autoPlay*1000);
			};
			
			
		});
	};

	//reverse effect
	$.fn.myReverse = [].reverse;
	
	//
	// plugin skins
	//
	$.fn.allinone_bannerRotator.defaults = {
			skin: 'classic',
			width:960,
			height:384,
			width100Proc:false,
			height100Proc:false,			
			randomizeImages: false,
			firstImg:0,
			numberOfStripes:20,
			numberOfRows:5,
			numberOfColumns:10,
			defaultEffect:'random',
			effectDuration:0.5,
			autoPlay:4,
			loop:true,
			target:"_blank",
			showAllControllers:true,
			showNavArrows:true,
			showOnInitNavArrows:true, // o1
			autoHideNavArrows:true, // o1
			showBottomNav:true,
			showOnInitBottomNav:true, // o2
			autoHideBottomNav:true, // o2
			showPreviewThumbs:true,
			enableTouchScreen:true,
			absUrl:'',
			
			showCircleTimer:false,
			showCircleTimerIE8IE7:false,
			circleRadius:10,
			circleLineWidth:4,
			circleColor: "#FF0000",
			circleAlpha: 100,
			behindCircleColor: "#000000",
			behindCircleAlpha: 50,
			responsive:false,
			responsiveRelativeToBrowser:true,
			
			origWidth:0,
			origHeight:0,
			thumbsWrapperMarginBottom:0,
			windowOrientationScreenSize0:0,
			windowOrientationScreenSize90:0,
			windowOrientationScreenSize_90:0,
			windowCurOrientation:0		
	};

})(jQuery);