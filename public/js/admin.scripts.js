$(document).ready(function(){
	$('.left-side > ul > li > a').click(function(){
		var $li=$(this).closest('li');
		if($li.find('.popup').length){
			if($li.hasClass('active')){
				$li.removeClass('active');
				$('.left-side-overlay').removeClass('active');
			}
			else{
				$('.left-side > ul > li.active').removeClass('active');
				$li.addClass('active');
				$('.left-side-overlay').addClass('active');
			}
			return false;
		}
	});

	$('.left-side .popup .close, .left-side-overlay').click(function(){
		$('.left-side > ul > li.active').removeClass('active');
		$('.left-side-overlay').removeClass('active');
		return false;
	});

	$('.left-side .hide-sidebar').click(function(){
		$('body').toggleClass('small-sidebar');
		localStorage.setItem("is_small_sidebar", $('body').hasClass('small-sidebar'));
		return false;
	});

	if(localStorage.getItem("is_small_sidebar") === "true"){
		$('body').addClass('small-sidebar');
	}

	$(document).on('click', '.catalog-list .actions .vis', function(){
		var isShowURL=$('#catalog-list').data('isshowurl');
		var $this=$(this);
		$.ajax({
			url: isShowURL+$this.closest('li').data('id'),
			type: 'POST',
			data: {},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(result){
				$this.closest('li').toggleClass('noactive');
				if($this.closest('li').hasClass('noactive')){
					$this.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
				}
				else{
					$this.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
				}
			}
		});
		return false;
	});

	if(typeof catalogData !== 'undefined'){
		var $catalog=$('#catalog-list');
		var showURL=$catalog.data('showurl');
		var mainsURL=$catalog.data('mainsurl');
		var editURL=$catalog.data('editurl');
		var addURL=$catalog.data('addurl');
		var deleteURL=$catalog.data('deleteurl');
		var canEdit=$catalog.data('canedit');
		var canAdd=$catalog.data('canadd');
		var canDelete=$catalog.data('candelete');

		let mainsSubstr=mainsURL&&mainsURL.includes("edit_group/0")?"":"<div class='actions'><a href='"+mainsURL+"' class='edit' title='Редактировать'><i class='fas fa-pencil-alt'></i></a></div>";

		$catalog.append("<li class='root noDraggable' data-notmove='notmove'><div class='catalog-one all d-flex'><div class='name'><a href='"+showURL+"1'>Все</a></div>"+mainsSubstr+"</div></li>");
		$catalog.append(appendChilds(catalogData));
		if(!$catalog.find('.active').length){
			$catalog.find('.root').addClass('active');
		}

		function appendChilds(children){
			let code='';
			children.forEach((element) => {
				let liClass=element['expand']?"tree-expanded":"tree-collapsed";
				liClass+=element.hasOwnProperty('children')||element.hasOwnProperty('needload')?" tree-branch":" tree-leaf";
				let eye_icon="fa-eye-slash";
				if(!element['is_show']){
					liClass+=" noactive";
					eye_icon="fa-eye";
				}
				if(element['active']) liClass+=" active";
				if(element.hasOwnProperty('needload')) liClass+=" notload";

				let addBlock="",editBlock="",deletelock="";
				if(canEdit){
					editBlock=
						"<a href='#' class='move mr10' title='Переместить'><i class='fas fa-arrows-alt-v'></i></a>"+
						"<a href='"+editURL+element['id']+"' class='edit mr10' title='Редактировать'><i class='fas fa-pencil-alt'></i></a>"+
						"<a href='#' class='vis mr10' title='Показать/скрыть'><i class='fas "+eye_icon+"'></i></a>";
				}
				else{
					editBlock="<span class='catalog-placeholder'></span><span class='catalog-placeholder'></span><span class='catalog-placeholder'></span>";
				}

				if(canAdd){
					addBlock="<a href='"+addURL+element['id']+"' class='add mr10' title='Добавить категорию'><i class='fas fa-plus'></i></a>";
				}
				else{
					addBlock="<span class='catalog-placeholder'></span>";
				}

				if(canDelete&&element['is_can_delete']=='1'){
					deletelock="<a href='"+deleteURL+element['id']+"' class='delete confirm' title='Удалить' data-confirm='Вы уверены, что хотите удалить?'><i class='fas fa-times'></i></a>";
				}
				else{
					deletelock="<span class='catalog-placeholder'></span>";
				}

				code+=
				"<li class='"+liClass+"' data-id='"+element['id']+"'>"+
					"<div class='catalog-one d-flex'>"+
						"<div class='custom-chekbox mr5'><input type='checkbox' id='cat-"+element['id']+"'><label for='cat-"+element['id']+"'></label></div>"+
						"<a href='#' class='collapse-category mr10 mt5'></a>"+
						"<div class='name'><a href='"+showURL+element['id']+"'>"+element['name']+"</a></div>"+
						"<div class='actions'>"+
							addBlock  +
							editBlock +
							deletelock +
						"</div>"+
					"</div>";
				if(element.hasOwnProperty('children')){
					code+="<ul>";
					code+=appendChilds(element['children']);
					code+="</ul>";
				}
				code+="</li>";
			});
			return code;
		}

		function ajaxLoadNodes(ids, force_open = 0) {
			$.each(ids, function (index, value) {
				if($catalog.find('.tree-branch[data-id="'+value+'"]').hasClass('notload')){
					$catalog.find('.tree-branch[data-id="'+value+'"]').addClass('loading').removeClass('notload');
				}
			});

			var data = {
				ids: ids,
				force_open: force_open
			};

			$.ajax({
				url: $catalog.data('get_nodes'),
				type:   'POST',
				data: data,
				dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(result){
					$.each(result, function (index, value) {
						let $li=$catalog.find("li[data-id="+index+"].loading");
						if($li.length){
							$li.append("<ul>"+appendChilds(value)+"</ul>");
							$li.removeClass('loading');
							$li.removeClass('tree-collapsed').addClass('tree-expanded');
						}
					});

					if(force_open){
						if($catalog.find('.notload').length){
							let ids=[];
							$catalog.find('.notload').each(function(){
								ids.push($(this).data('id'));
							});
							ajaxLoadNodes(ids,1);
						}
					}
				},
				error:function(result){
					//console.log(result);
				}
			});
        }

		$('.catalog-list').nestedSortable({
			handle: '.move',
			items: 'li:not([data-notmove])',
			toleranceElement: '>.catalog-one',
			branchClass: 'tree-branch',
			collapsedClass: 'tree-collapsed',
			expandedClass: 'tree-expanded',
			leafClass: 'tree-leaf',
			forcePlaceholderSize: true,
			tabSize: 30,
			listType: 'ul',
			disabledClass: 'noDraggable',
			expandOnHover: false,
			placeholder: {
				element: function (currentItem, ui) {
					var placeholder = $(currentItem)
						.clone()
						.addClass('tree-placeholder')
						.removeClass('active')
						.css({
							position: 'static',
							width: 'auto'
						});
					placeholder.find('.custom-chekbox').empty();
					placeholder.find('.collapse-category').addClass('noimage');
					placeholder.find('.name').empty();
					return placeholder[0];
				},
				update: function (container, p) {
					return;
				}
			},
			update: function (event, ui) {
				var source_id = ui.item.data('id');

				if (ui.item.parent().is('.treesort')) {
					var parent_id = 0;
				}
				else {
					var parent_id = ui.item.parents('li[data-id]').data('id');
				}

				if (ui.item.next().length) {
					var destination_id = ui.item.next().data('id');
					var destination_direction = 'up';
				}
				else {
					var destination_id = ui.item.prev().data('id');
					var destination_direction = 'down';
				}

				var data={
					from: source_id,
					to: destination_id,
					flag: destination_direction,
					parent: parent_id
				};
				var moveURL=$('#catalog-list').data('moveurl').replace(/^\/|\/$/g, '');
				$.ajax({
					url: moveURL,
					type: 'POST',
					data: data,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(result){
						console.log(result);
					}
				});
			}
		});

		$(document).on('change', '#catalog-toggle-all', function(){
			$('#catalog-list input[type=checkbox]').each(function(){
				$(this).prop('checked',!$(this).prop('checked'));
			});

			if($('#catalog-list input[type=checkbox]:checked').length){
				$('.groups-actions .disabled').removeClass('disabled');
			}
			else{
				$('.groups-actions .show-all').addClass('disabled');
				$('.groups-actions .delete-all').addClass('disabled');
			}
		});

		$(document).on('change', '#catalog-list input[type=checkbox]', function(){
			if($('#catalog-list input[type=checkbox]:checked').length){
				$('.groups-actions .disabled').removeClass('disabled');
			}
			else{
				$('.groups-actions .show-all').addClass('disabled');
				$('.groups-actions .delete-all').addClass('disabled');
			}
		});

		$(document).on('click', '#catalog-list .collapse-category', function(){
			var $li=$(this).closest('li');
			if($li.hasClass('tree-collapsed')){
				if ($li.hasClass('notload')) {
                    ajaxLoadNodes([$li.data('id')]);
                }
				else{
					$li.removeClass('tree-collapsed').addClass('tree-expanded');
				}
			}
			else if($li.hasClass('tree-expanded')){
				$li.removeClass('tree-expanded').addClass('tree-collapsed');
			}
			return false;
		});

		$(document).on('click', '.groups-actions .expand-all', function(){
			if($catalog.find('.notload').length){
				let ids=[];
				$catalog.find('.notload').each(function(){
					ids.push($(this).data('id'));
				});
				ajaxLoadNodes(ids,1);
			}
			$('.tree-branch.tree-collapsed').removeClass('tree-collapsed').addClass('tree-expanded');
			return false;
		});

		$(document).on('click', '.groups-actions .collapse-all', function(){
			$('.tree-branch.tree-expanded').removeClass('tree-expanded').addClass('tree-collapsed');
			return false;
		});

		$(document).on('click', '.groups-actions .show-all', function(){
			if(!$(this).hasClass('disabled')){
				var ids=[];
				$('#catalog-list input[type=checkbox]:checked').each(function(){
					ids.push($(this).closest('li').data('id'));
				});
				if(ids.length){
					var isShowURL=$('#catalog-list').data('isshowurl').replace(/^\/|\/$/g, '');
					$.ajax({
						url: isShowURL,
						type: 'POST',
						data: {
							ids: ids,
						},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success: function(result){
							$('#catalog-list input[type=checkbox]:checked').each(function(){
								$(this).closest('li').toggleClass('noactive');
								if($(this).closest('li').hasClass('noactive')){
									$(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
								}
								else{
									$(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
								}
								$(this).prop('checked',false);
							});
						}
					});
				}
			}
			return false;
		});

		$(document).on('click', '.groups-actions .delete-all', function(){
			if(!$(this).hasClass('disabled')){
				var ids=[];
				$('#catalog-list input[type=checkbox]:checked').each(function(){
					if($(this).closest('.catalog-one').find('.delete').length){
						ids.push($(this).closest('li').data('id'));
					}
					else{
						$(this).prop('checked',false);
					}
				});
				if(ids.length){
					var deleteURL=$('#catalog-list').data('deleteurl').replace(/^\/|\/$/g, '');
					$.ajax({
						url: deleteURL,
						type: 'POST',
						data: {
							ids: ids,
						},
						success: function(result){
							$('#catalog-list input[type=checkbox]:checked').each(function(){
								$(this).closest('li').remove();
							});
						}
					});
				}
			}
			return false;
		});
	}

	$(document).on('click', '.clear-group-search', function(){
		$('#catalog-list').removeClass('d-none');
		$('.groups-actions').removeClass('d-none').addClass('d-flex');
		$('.groups-block .search-result').addClass('d-none');
		$('.search-block inpit[type=text]').val("");
		return false;
	});

	$(document).on('change', '#items-toggle-all', function(){
		$('.all-items tbody input[type=checkbox].id-checkbox').each(function(){
			$(this).prop('checked',!$(this).prop('checked'));
		});
	});

	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	$(".all-items tbody").sortable({
		helper: fixHelper,
		handle: '.move',
		stop: function( event, ui ) {
			setOrder();
		}
	}).disableSelection();

	$(document).on('submit', '.items-form', function(){
		var action=$(this).find('select[name=action]').val();
		if($('.all-items tbody input[type=checkbox].id-checkbox:checked').length||'renew'==action){
			if(action=='move'&&!$('.items-form input[name=move_to]').val()){
				$('#change-category').modal('show');
				return false;
			}
			return true;
		}
		else{
			return false;
		}

	});

	$(document).on('click', '.change-relatives-table', function(){
		var action=$(this).closest('.tab-one').find('select[name=action]').val();
		if(action=='move'&&!$(this).closest('.tab-one').find('input.move_to').val()){
			$('#change-category').modal('show');
		}
		return false;
	});

	$(document).on('click', '.confirm', function(){
		var $ref=$(this);
		bootbox.confirm($(this).data('confirm')?$(this).data('confirm'):"Вы уверены?", function(result) {
			if(result){
				document.location.href=$ref.attr('href');
			}
		});
		return false;
	});

	if($('.tree-controller').length){
		$('.tree-controller').treeController();
	}

	$('.search-tr select').change(function(){
		if($(this).attr('name')!='action'){
			$(this).closest('form').submit();
		}
	});

	$('.confirm-movement').click(function(){
		if($(this).closest(".modal-content").find(".tree-controller input").val()){
			$('.items-form input[name=move_to]').val($(this).closest(".modal-content").find(".tree-controller input").val());
			$('.items-form #submitForm').trigger('click');
		}
	});

	$('.tabs-titles-block a').click(function(){
		$('.tabs-titles-block a').removeClass('active');
		$(this).addClass('active');
		$('.tabs-block > div').addClass('d-none');
		$($(this).attr('href')).removeClass('d-none');
		$("input[name=c_tab]").val($(this).attr('href'));
		return false;
	});

	$('.translit').click(function(){
		let $input=$(this).closest('.field-block').find('input');
		let $from=$('input[name='+$input.data('translit')+']');
		$input.val(urlLit($from.val(),0));
		return false;
	});


	function urlLit(w,v) {
		var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
		var ww=''; w=w.toLowerCase();
		for(i=0; i<w.length; ++i) {
			cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]);
			if(ch.length<3) ww+=ch; else ww+=eval(ch)[v];
		}
		return(ww.replace(/[^a-zA-Z0-9\-]/g,'-').replace(/[-]{2,}/gim, '-').replace( /^\-+/g, '').replace( /\-+$/g, ''));
	}

	$.fn.datetimepicker.Constructor.Default = $.extend({},
		$.fn.datetimepicker.Constructor.Default,
		{
			icons:
			{
				time: 'fas fa-clock',
				date: 'fas fa-calendar',
				up: 'fas fa-arrow-up',
				down: 'fas fa-arrow-down',
				previous: 'fas fa-arrow-circle-left',
				next: 'fas fa-arrow-circle-right',
				today: 'far fa-calendar-check-o',
				clear: 'fas fa-trash',
				close: 'far fa-times'
			}
		}
	);

	$('.date-field').datetimepicker({
		locale: 'ru',
		format: 'L'
	});
	$('.time-field').datetimepicker({
		locale: 'ru'
	});

	$('.select2-ajax').select2({
		language: "ru",
		width: '100%',
		theme: 'bootstrap4',
		ajax: {
			delay: 250,
			dataType: 'json',
			debug:true,
			data: function (params) {
				return {
					q: params.term
				};
			},
			processResults: function (data) {
				return {
					results: data
				};
			},
		},
	});


	$('.select2-simple').select2({
		language: "ru",
		width: '100%',
		theme: 'bootstrap4',
	});

	if($('.dropzone').length){
		Dropzone.autoDiscover = false;
		$("div.dropzone").each(function(){
			var $this=$(this);
			var connect=$this.data('connect');
			var dropzoneFolder=$this.data('folder');
			$(this).dropzone({
				url: $this.data('upload'),
				dictDefaultMessage: "<span class='text_upload'>Перетащите изображения сюда</span>",
				dictFallbackMessage: "Ваш браузер не поддерживает способ Drag & drop.",
				dictFallbackText: "Пожалуйста, загрузите файлы обычным методом.",
				dictFileTooBig: "Файл слишком большой ({{filesize}}мб). Максимальный размер: {{maxFilesize}}мб.",
				dictInvalidFileType: "Допустимые расширения: jpg, png.",
				dictResponseError: "Ошибка: {{statusCode}} код ответа.",
				dictCancelUpload: "Отменить загрузку",
				dictCancelUploadConfirmation: "Вы уверены, что хотите прервать загрузку?",
				dictRemoveFile: "Удалить",
				dictMaxFilesExceeded: "Вы не можете загрузить так много изображений.",
				maxFiles: 20,
				acceptedFiles: "image/jpeg,image/png",
				addRemoveLinks: true,
				success: function(file,resp) {
					let $input=$(connect);
					let files=$input.val().split(";");
					if(!files.includes(resp)){
						files.push(resp);
					}
					file.previewElement.querySelector(".dz-filename span").innerHTML=resp;
					$input.val(files.join(';'));
				},
				removedfile: function(file) {
					let $input=$(connect);
					let files=$input.val().split(";");
					let filenames=file.previewElement.querySelector(".dz-filename span").innerHTML.split('/');
					let index = files.indexOf(filenames[filenames.length-1]);
					if (index !== -1) files.splice(index, 1);
					$input.val(files.join(';'));

					if (file.previewElement != null && file.previewElement.parentNode != null) {
						file.previewElement.parentNode.removeChild(file.previewElement);
					}

					return this._updateMaxFilesReachedClass();
				},
				accept: function(file, done) {
					done();
				},
				init: function () {
					let $input=$(connect);
					if($input.val()){
						var dropzone=this;
						let files=$input.val().split(";");
						files.forEach(function(item){
							item=dropzoneFolder+"/"+item;
							var mockFile = { name: item, size: 12345, type: 'image/jpeg' };
							dropzone.options.addedfile.call(dropzone, mockFile);
							dropzone.options.thumbnail.call(dropzone, mockFile, item);
							mockFile.previewElement.classList.add('dz-success');
							mockFile.previewElement.classList.add('dz-complete');
						});
					}
				},
				error:function(file, message) {
					console.log(message);
				}
			});

			$(this).sortable({
				items:'.dz-preview',
				cursor: 'move',
				opacity: 0.5,
				containment: '.dropzone',
				distance: 20,
				tolerance: 'pointer',
				stop: function (evt, ui) {
					let orders=[];
					$this.find('.dz-filename').each(function(){
						let parts=$(this).text().split('/');
						orders.push(parts[parts.length-1]);
					});
					let $input=$(connect);
					$input.val(orders.join(";"));
				}
			});
		});
	}

	$('.attrs-group').sortable({
		containment: "parent",
		items:'> .field-block',
		cursor: 'move',
		opacity: 0.5,
		tolerance: "pointer",
		cursor: "move",
		distance: 20,
		tolerance: 'pointer',
		handle: '.move-group',
		stop: function (evt, ui) {
			let orders=[];
		}
	});

	$('.attrs-group-block').sortable({
		containment: "parent",
		items:'> .attrs-group',
		cursor: 'move',
		opacity: 0.5,
		tolerance: "pointer",
		cursor: "move",
		distance: 20,
		tolerance: 'pointer',
		handle: '.move-group2',
		stop: function (evt, ui) {
			let orders=[];
		}
	});

	jQuery.ui.autocomplete.prototype._resizeMenu = function () {
		var ul = this.menu.element;
		ul.outerWidth(this.element.outerWidth());
	}
	$('.autocomplete').autocomplete({
		source: function(request, response){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url : this.element.attr('data-ajax'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data:{
					q: request.term
				},
				success: function(data){
					response($.map(data, function(item){
						return {
							label: item.name,
							value: item.name,
							id: item.id
						}
					}));
				}
			});
		},
		select: function( event, ui ) {
			//console.log(ui.item);
			$(event.target).closest('form').submit();
		},
		minLength: 2
	});

	$(document).on('submit', '.groups-block .search-block', function(){
		$(this).find('.autocomplete').autocomplete('close');

		let value=$(this).find('input').val();
		if(value){
			$.ajax({
				type: 'POST',
				url : $(this).attr('action'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data:{
					q: value
				},
				success: function(result){
					$('#catalog-list').addClass('d-none');
					$('.groups-actions').removeClass('d-flex').addClass('d-none');
					$('.groups-block .search-result').html(result);
					$('.groups-block .search-result').removeClass('d-none');
				}
			});
		}
		else{
			$('#catalog-list').removeClass('d-none');
			$('.groups-actions').removeClass('d-none').addClass('d-flex');
			$('.groups-block .search-result').addClass('d-none');
		}
		return false;
	});

	$(document).on('click', '.file-image.cropper-block', function(){
		var img=$(this).find('img').attr('src');
		var $this=$(this);
		$('#image-editor').html("<div class='mb15' style='position: relative; width: 100%; max-height: 600px;'><img src='"+img+"' style='max-width: 100%;'></div><p class='mb0'><a href='#' class='save-image-crop btn btn-green'>Сохранить</a></p>");
		var $img = $('#image-editor img');
		$img.attr("data-id",$(this).attr('id'));

		$img.cropper({
			aspectRatio: parseInt($this.attr('data-width'))/parseInt($this.attr('data-height')),
			zoomOnWheel:false,
			ready: function () {
				$(this).cropper('crop');
				$(this).cropper('setData', {x:parseInt($this.attr('data-x')), y:parseInt($this.attr('data-y')), width:parseInt($this.attr('data-width')), height:parseInt($this.attr('data-height'))});
			},
		});

		$.fancybox.open({
			src  : '#image-editor',
			type : 'inline'
		});
	});

	$(document).on('click', '.save-image-crop', function(){
		//TODO
		var cropper = $('#image-editor img').data('cropper');
		var data=cropper.getData();

		var $cropperBlock=$("#"+$('#image-editor img').attr('data-id'));

		var postData={
			x:parseInt(data.x),
			y:parseInt(data.y),
			width:parseInt(data.width),
			height:parseInt(data.height),
			db_field:$('#image-editor img').attr('data-id').replace("cropper_",""),
			item_id:$("input[name=item_id]").val(),
			is_groups:$("input[name=is_groups]").length,
		};

		$.ajax({
			type: 'POST',
			url : "/admin/"+$("input[name=c_controller]").val()+"/saveCropImage",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data:postData,
			success: function(result){
				$cropperBlock.attr('data-x',postData.x);
				$cropperBlock.attr('data-y',postData.y);
				$cropperBlock.attr('data-width',postData.width);
				$cropperBlock.attr('data-height',postData.height);
			}
		});

		$.fancybox.close();
		return false;
	});

	$('.custom-file input').change(function() {
		let filename=$('.custom-file input')[0].files.length?$('.custom-file input')[0].files[0].name:"Выбрать файл";
		$(this).closest('.custom-file').find('label').text(filename);
	});

	$(document).on('click', '.delete-file', function(){
		var $block=$(this).closest('.field-data');
		var $this=$(this);
		$.ajax({
			type: 'POST',
			url : $(this).attr('data-url'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data:{
				name: $(this).attr('data-name'),
				id: $(this).attr('data-id'),
			},
			success: function(result){
				$block.find('.custom-file').removeClass('d-none');
				$block.find('.file-image').removeClass('d-inline-block').addClass('d-none');
				$this.addClass('d-none');
			}
		});


		return false;
	});

	$(document).on('click', '.toggle-widget-block', function(){
		$('.widget-block').slideToggle();
		return false;
	});

	$(document).on('change', '.widget-block input', function(){
		var module_id=$(this).attr('id');
		$.ajax({
			url: "/admin/toggleQuickAccess",
			type:   'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
				module_id:module_id.replace('field','')
			},
			success: function(result){
				console.log(result);
				$('.quick-access .'+ module_id).toggleClass('d-none');
			}
		});

		return false;
	});

	if($('.popup-note').length){
		setTimeout(function(){
			$(".popup-note").alert('close');
		},3000);
	}

	$('.remember-password').click(function(){
		$('.login-block').addClass('d-none');
		$('.password-block').removeClass('d-none');
		return false;
	});

	$('.to-login-block').click(function(){
		$('.password-block').addClass('d-none');
		$('.login-block').removeClass('d-none');
		return false;
	});

	if($("input[name=c_tab]").length){
		$("input[name=c_tab]").val("#"+$(".tabs-block .tab-one:not(.d-none)").attr('id'));
		if(window.location.hash.substr(1)){
			let hash="#"+window.location.hash.substr(1);
			if($(".tabs-titles-block a[href="+hash+"]").length){
				$(".tabs-titles-block a[href="+hash+"]").trigger('click');
			}
		}
	}

	$(document).on('click', '.page-left', function(){
		let pageNum=parseInt($(this).closest('.pager').find("input").val());
		if(!isNaN(pageNum)){
			let pageMax=parseInt($(this).closest('.pager').find("input").attr('data-max'));
			if(pageNum>1){
				--pageNum;
				$('.pager input').val(pageNum);
				$(this).closest('.pager').find("input").trigger('change');
			}
		}
		return false;
	});

	$(document).on('click', '.page-right', function(){
		let pageNum=parseInt($(this).closest('.pager').find("input").val());
		if(!isNaN(pageNum)){
			let pageMax=parseInt($(this).closest('.pager').find("input").attr('data-max'));
			if(pageNum<pageMax){
				++pageNum;
				$('.pager input').val(pageNum);
				$(this).closest('.pager').find("input").trigger('change');
			}
		}
		return false;
	});

	$(document).on('change', '.pager input', function(){
		let pageNum=parseInt($(this).val());
		let pageMax=parseInt($(this).closest('.pager').find("input").attr('data-max'));
		if(!isNaN(pageNum)&&pageNum>0&&pageNum<=pageMax){
			var $this=$(this);
			showListPage("/admin/"+$('.all-items').attr('data-controller')+"/show/"+$('.all-items').attr('data-pid')+"/"+pageNum,{});
			$('.pager input').val($this.val());
		}

		return false;
	});

	$(document).on('change', '.changeAdminOnPage', function(){
		let adminOnPage=parseInt($(this).val());

		if(!isNaN(adminOnPage)&&adminOnPage>0){
			var $this=$(this);
			$('.all-items').attr('data-page_num',1);
			$('.pager input').val(1);
			showListPage("/admin/"+$('.all-items').attr('data-controller')+"/show/"+$('.all-items').attr('data-pid')+"/"+$('.all-items').attr('data-page_num'),{
				adminOnPage:adminOnPage
			});
		}
		return false;
	});

	function showListPage(url, data){
		$.ajax({
			type: 'POST',
			url : url,
			data:data,
			dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(result){
				window.history.pushState(null, null, url);
				$('.all-items tbody').html(result.table);
				$('[data-toggle=toggle]').bootstrapToggle();
				$('.pagesCountReal').text(result.pagesCount);
				$('.pager input').attr('data-max',result.pagesCount);
				initOrder();
			},
			error: function(result){
				console.log(result.responseText);
			}
		});
	}

	$('thead .search-tr input,thead .search-tr select').change(function(){
		let data={
			filters:{}
		};
		$('thead .search-tr input.filter-field').each(function(){
			data.filters[$(this).attr("name")]=$(this).val();
		});
		$('thead .search-tr select').each(function(){
			data.filters[$(this).attr("name")]=$(this).val();
		});

		$('.all-items').attr('data-page_num',1);
		$('.pager input').val(1);
		showListPage("/admin/"+$('.all-items').attr('data-controller')+"/show/"+$('.all-items').attr('data-pid')+"/1",data);
	});

	$('.clear-filters').click(function(){
		$('thead .search-tr input.filter-field').val("");
		$('thead .search-tr select').val("all");
		if($('thead .search-tr input.filter-field').length){
			$('thead .search-tr input.filter-field').first().trigger("change");
		}
		else if($('thead .search-tr select').length){
			$('thead .search-tr select').first().trigger("change");
		}
		return false;
	});

	$('.names-tr .sorted-a').click(function(){
		let newSort=$(this).attr('data-sorttype');
		showListPage("/admin/"+$('.all-items').attr('data-controller')+"/show/"+$('.all-items').attr('data-pid')+"/"+$('.all-items').attr('data-page_num'),{
			order:$(this).attr('data-sort'),
			orderType:$(this).attr('data-sorttype'),
		});
		$('.names-tr .sorted-a').attr('data-sorttype','asc');
		$(this).attr('data-sorttype',newSort=='asc'?'desc':'asc');
		$('.names-tr .sorted-a').removeClass('sorted-asc').removeClass('sorted-desc');
		$(this).addClass($(this).attr('data-sorttype')=='asc'?'sorted-desc':'sorted-asc');
		return false;
	});

	var cOrder=[];
	function initOrder(){
		if($('.order-input').length){
			$('.order-input').each(function(){
				cOrder.push($(this).val());
			});
		}
	}
	initOrder();

	$(document).on('change', '.order-input', function(){
		var value=parseInt($(this).val());
		if(isNaN(value)){
			value=0;
			$(this).val(0);
		}

		var $row = $(this).closest("tr");
		var cId = $row.attr('data-id');
		var is_insert=false;
		$('.all-items tbody tr').each(function(){
			if($(this).attr('data-id')!=cId){
				let order=parseInt($(this).find('.order-input').val());
				if(order>=value){
					$row.insertBefore($(this));
					is_insert=true;
					return false;
				}
			}
		});

		if(!is_insert){
			$row.insertAfter($('.all-items tbody tr').last());
		}

		setOrder();
	});

	function setOrder(){
		var i=0;
		var data={
			orders:{}
		};

		$('.order-input').each(function(){
			$(this).val(cOrder[i]);
			data.orders[$(this).closest('tr').attr('data-id')]=cOrder[i];
			++i;
		});
		$.ajax({
			type: 'POST',
			url : "/admin/"+$('.all-items').attr('data-controller')+"/setOrder",
			data: data,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(result){
			},
			error: function(result){
				console.log(result);
			}
		});
	}

	$(document).on('submit', '.login-form', function(){
		let $btn = $('.login-form button')
		let old_btn_text = $btn.html();
		$btn.html('<i class="fas fa-spinner fa-spin"></i>');
		$.ajax({
			type: 'POST',
			url : "",
			data: $(this).serialize(),
			dataType: 'json',
			success: function(result){
				if(result.message){
					$('#change-category .modal-body p').text(result.message);
					$('#change-category').modal('show');
				}
				if(result.redirect){
					document.location.href = result.redirect;
				}
				else{
					$btn.html(old_btn_text);
                }
			},
			error: function(result){
				console.log(result);
			}
		});
		return false;
	});
});
