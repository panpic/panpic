$(function()
{
	var bWizardTabClass = '';
	$('.wizard').each(function()
	{
		if ($(this).is('#rootwizard'))
			bWizardTabClass = 'bwizard-steps';
		else
			bWizardTabClass = '';

		var wiz = $(this);
		
		$(this).bootstrapWizard(
		{
			onNext: function(tab, navigation, index) 
			{
				if(index==1) {
					// Make sure we entered the title
					if(!wiz.find('#company_id').val()) {
						alert('You must select company');
						wiz.find('#company_id').focus();
						return false;
					} else {
						$('#purchaseForm').submit();
					}
				}
				
				if(index==2) {
					/*
					if(!wiz.find('#personal_id').val()) {
						alert('You must select personal contact');
						wiz.find('#personal_id').focus();
						return false;
					} else {
						$('#purchaseForm').submit();
					}
					*/
					$('#purchaseForm').submit();
				}
				
				if(index ==3){
					/*
					if(!wiz.find('#job_name').val()) {
						alert('You must enter job name');
						wiz.find('#job_name').focus();
						return false;
					} else {
						$('#purchaseForm').submit();
					}
					*/
					$('#purchaseForm').submit();
				}
				
			}, 
			onLast: function(tab, navigation, index) 
			{
				// Make sure we entered the title
				if(!wiz.find('#company_id').val()) {
					alert('You must select company');
					wiz.find('#company_id').focus();
					return false;
				} else {
					$('#purchaseForm').submit();
				}
				
				
				
			}, 
			onTabClick: function(tab, navigation, index) 
			{
				if(step <= 1) {
					// Make sure we entered the title
					if(!wiz.find('#company_id').val()) {
						alert('You must select company');
						wiz.find('#company_id').focus();
						return false;
					} 
					else {
						$('#purchaseForm').submit();
					}
				}
				
				/*
				else if(!wiz.find('#personal_id').val()) {
					alert('You must select personal contact');
					wiz.find('#personal_id').focus();
					return false;
				} 
				*/
				//alert(index)				
				
				
			},
			onTabShow: function(tab, navigation, index) 
			{
				var $total = navigation.find('li:not(.status)').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				
				if (wiz.find('.progress-bar').length)
				{
					wiz.find('.progress-bar').css({width:$percent+'%'});
					wiz.find('.progress-bar')
						.find('.step-current').html($current)
						.parent().find('.steps-total').html($total)
						.parent().find('.steps-percent').html(Math.round($percent) + "%");
				}
				
				// update status
				if (wiz.find('.step-current').length) wiz.find('.step-current').html($current);
				if (wiz.find('.steps-total').length) wiz.find('.steps-total').html($total);
				if (wiz.find('.steps-complete').length) wiz.find('.steps-complete').html(($current-1));
				
				// mark all previous tabs as complete
				navigation.find('li:not(.status)').removeClass('primary');
				navigation.find('li:not(.status):lt('+($current-1)+')').addClass('primary');
	
				// If it's the last tab then hide the last button and show the finish instead
				if($current >= $total) {
					wiz.find('.pagination .next').hide();
					wiz.find('.pagination .finish').show();
					wiz.find('.pagination .finish').removeClass('disabled');
				} else {
					wiz.find('.pagination .next').show();
					wiz.find('.pagination .finish').hide();
				}
			},
			tabClass: bWizardTabClass,
			nextSelector: '.next', 
			previousSelector: '.previous',
			firstSelector: '.first', 
			lastSelector: '.last'
		});

		wiz.find('.finish').click(function() 
		{
			alert('Finished!, Starting over!');
			wiz.find("a[data-toggle*='tab']:first").trigger('click');
		});
	});
});