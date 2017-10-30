jQuery(window).load(function() {
    
    jQuery('.switchpane h3').click(function(event){
        jQuery(event.target.parentElement).toggleClass('active');
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
			jQuery('#languagedropdown').removeClass('closed');
		}
		else{
			if(!jQuery('#languagedropdown').hasClass('closed')) {
				jQuery('#languagedropdown').addClass('closed');
			}
		}        
	});
	

	jQuery("#mobile-nav").slicknav({label:''});

	jQuery('.slicknav_nav input[type=search]').click(function(){
		jQuery('.slicknav_nav').addClass('search-selected');
		jQuery('.mobile-search-panel').addClass('search-selected');
		jQuery('.mobile-search-panel input[type=search]').focus();

//		setTimeout(function(){ 
//			jQuery('.mobile-search-panel').css('top', jQuery(window).scrollTop());
//		}, 3000);
	});

	jQuery('.mobile-search-panel .search-close-button').click(function(){
		jQuery('.mobile-search-panel').removeClass('search-selected');
		jQuery('.slicknav_nav').removeClass('search-selected');
	});
	
	
	jQuery(".accordion").click(function(){
		jQuery(this).toggleClass("open");
	});

    
    function updateFooter(){
        var maxScroll = jQuery(document).height() - jQuery(window).height();
        var showFooterZone = 60;
        if (jQuery(window).scrollTop() >= maxScroll - showFooterZone )
        {
            jQuery("footer").addClass("expanded");
        } 
        else if (jQuery(document).height() <= jQuery(window).height())
        {
            jQuery("footer").addClass("expanded");
        }
        else
        {
            jQuery("footer").removeClass("expanded");
        }
    }
    
    jQuery(window).scroll(updateFooter);
    updateFooter();

    //if we're on the mobile products page
    if (jQuery('.filter-panel.mobile').length > 0){
    	jQuery('.filter-panel.mobile').css('display', 'block');

    	jQuery('.filter-panel.mobile').appendTo(jQuery('.mobile-products-flyout'));	
	    
	    jQuery('.filter-panel-header').click(closeAllProductFilterPanels);

	    if (jQuery('.mobile-filter-button').length){
	    	jQuery('.mobile-filter-button').click(function(){
	    		var filterName = jQuery(this).attr('data-filter-name');
	    		if (jQuery('.filter-panel.mobile.' + filterName).hasClass('active')){
		    		jQuery('.filter-panel.mobile').removeClass('active');
	    		}
	    		else{
		    		jQuery('.filter-panel.mobile').removeClass('active');
		    		jQuery('.filter-panel.mobile.' + filterName).addClass('active');
	    		}
	    	});
	    }
    }
});



function trackEvent(category, action, label, value){
    if (label == undefined) label = "";
    if (value == undefined) value = 0;
    var trackerName = ga.getAll()[0].get('name');
    ga(trackerName + '.send', 'event', { eventCategory: category, eventAction: action, eventLabel: label, eventValue: value });
    return true;
}


