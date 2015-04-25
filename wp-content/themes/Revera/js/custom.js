jQuery(window).load(function() {

  jQuery('#slidebox').flexslider({
        animation: "fade",
        directionNav:true,
        controlNav:false
      });
    
  /* Navigation */

	jQuery('#submenu ul.sfmenu').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   { opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true								// disable drop shadows 
	});	  
    
    jQuery('#topmenu').mobileMenu({
			prependTo:'.mobilenavi'
			});	
	
	jQuery('ul.lang-chooser').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   { opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true,								// disable drop shadows 
		cssArrows: false
	});	  
    
	
	jQuery(document).click(function(event) { 
		if(jQuery(event.target).attr('id') === 'languagechooserbutton' && jQuery('#languagedropdown').hasClass('closed')) {
			console.log("Clicked lang chooser");
			jQuery('#languagedropdown').removeClass('closed');
		}
		else{
			if(!jQuery('#languagedropdown').hasClass('closed')) {
				console.log("Hiding the menu");
				jQuery('#languagedropdown').addClass('closed');
			}
		}        
	});
	
	jQuery("#mobile-nav").slicknav({label:''});
});


