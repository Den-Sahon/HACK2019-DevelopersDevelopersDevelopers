$(document).on('input', '.nice-input-text', function(){
  if (this.value != ''){
    $(this).addClass('with-content'); 
  } else {
    $(this).removeClass('with-content'); 
  }
});

$('.nice-input-card-element').each(function(){
  if (this.value != ''){
    $(this).addClass('with-content'); 
  }
  var $elem = $('<div class="nice-input-cont">\
      '+this.outerHTML+'\
      <div class="pseudo-placeholder" >'+$(this).attr('data-placeholder')+'</div>\
      <div class="nice-input-line"></div>\
    </div>');
  $elem.find('input').val(this.value);
  
  $(this).before($elem);
  $(this).remove();
});



$('.nice-input-text').each(function(){
	if (this.value != ''){
		$(this).addClass('with-content'); 
	}
	var $elem = $('<div class="nice-input-cont">\
			'+this.outerHTML+'\
			<div class="pseudo-placeholder" >'+$(this).attr('data-placeholder')+'</div>\
			<div class="nice-input-line"></div>\
		</div>');
	$elem.find('input').val(this.value);
	
	$(this).before($elem);
	$(this).remove();
	
	
	
});

$(document).on('input', '.nice-input-text', function(){
	if (this.value != ''){
		$(this).addClass('with-content'); 
	} else {
		$(this).removeClass('with-content'); 
	}
});


var loginTimeout = null;

$(document).on('input', '.auth-field', function(){
	if ($('.switch').hasClass('signin-btn')){
		var self = this;
		clearTimeout(loginTimeout);
		loginTimeout = setTimeout(function(){
			$.ajax({
				url: '?api=login',
				type: 'post',
				data: 'val='+self.value
			}).done(function(data){
				if (data == 1){
					window.location.reload();
				}
			});
		}, 500);
	}
});

$(document).on('click', '.signup-submit', function(){
	$.ajax({
		url: '?api=signup',
		type: 'post',
		data: 'val='+$('.auth-field').val()
	}).done(function(data){
		alert('Ваш логин в системе: '+data);
		window.location.reload();
	});
});


$('.switch').click(function(){
	$('.switch').removeClass('active');
	$(this).addClass('active');
	if ($(this).hasClass('signin-btn')){
		$('.auth-field').attr('type', 'text');
		$('.auth-field').next().html('Create Single-login');
		$('.auth-field').before('<button type="button" class="signup-submit">&#10004;</button>'); 
	} else {
		$('.auth-field').attr('type', 'password');
		$('.auth-field').next().html('Single-login');
		$('.signup-submit').remove();
	}
});


$(document).on('click', '.generate', function(){
	var data = $(this).parents('form').serialize();
	var self = this;
	$.ajax({
		url: '?api=generate_codes',
		type: 'post',
		data: data
	}).done(function(data){
		data = JSON.parse(data);
		$('.qr-container').html('');
		data.forEach(function(item){
			$('.qr-container').append('<div class="col-sm-4"><img style="width: 100%" src="'+item+'" /><div><a target="_blank" download href="'+item+'">Скачать</a></div></div>');
		});
		
	});
	
});

$(document).on('click', '.remove-project', function(){
	if ($(this).hasClass('active')){
		if ($('.select-project').length > 0){
			$('.select-project').eq(0).click();
		} else {
			$('.right-side').html('<h1>Добавьте рекламную акцию</h1>');
		}
	}
	var self = this;
	$.ajax({
		url: '?api=remove_project',
		type: 'post',
		data: 'id='+$(this).attr('data-id')
	}).done(function(data){
		$(self).parent().remove();
	});
	
});

$(document).on('click', '.mark-as-payed', function(){
	var self = this;
	$.ajax({
		url: '?api=mark_as_payed',
		type: 'post',
		data: 'id='+$(this).attr('data-id')
	}).done(function(data){
		$(self).before('<div class="text-success">ОПЛАЧЕННО</div>');
		$(self).remove();
	});
	return false;
});


$(document).on('click', '.generate-winner', function(){
	var self = this;
	$.ajax({
		url: '?api=generate_winner',
		type: 'post',
		data: 'id='+$(this).attr('data-id')
	}).done(function(data){
		$('.select-project.active').click();
	});
	return false;
});


$(document).on('input change', '.project-form input, .project-form select', function(){
	if ($(this).attr('name') == 'project_name'){
		$('.select-project[data-id="'+$(this).attr('data-id')+'"]').html('# '+ this.value);
	}
	
	$(this).parents('.project-form').trigger('submit');
});


var form_submit_timeout = null;

$(document).on('submit', '.project-form', function(){
	clearTimeout(form_submit_timeout);
	var self = this;
	form_submit_timeout = setTimeout(function(){
		var fdata = $(self).serialize();
		$.ajax({
			url: '?api=update_project',
			type: 'post',
			data: fdata
		}).done(function(data){
			//$(self).parent().remove();
		});
	}, 500);
	return false;
});



$('.add-project').click(function(e){
	var self = this;
	e.preventDefault();
	$.ajax({
		url: '?api=add_project',
		type: 'post'
	}).done(function(data){
		$('.select-project').removeClass('active');
		$(self).parent().before('<li><a href="#" data-id="'+data+'" class="select-project">#</a><div data-id="'+data+'" class="remove-project">&times;</div></li>');
		$('.select-project[data-id="'+data+'"]').click();
	});
	return false;
});




$(document).on('click', '.select-project', function(){
	$('.select-project').removeClass('active');
	$(this).addClass('active');
	$.ajax({
		url: '?api=get_project',
		type: 'post',
		data: 'id='+$(this).attr('data-id')
	}).done(function(data){
		$('.right-side').html(data);
	});
});



$('.show-login').click(function(e){
	e.preventDefault();
	$.ajax({
		url: '?api=show_login',
		type: 'post',
		data: 'val='+$('.auth-field').val()
	}).done(function(data){
		alert('Ваш логин в системе: '+data);
	});
	return false;
});
