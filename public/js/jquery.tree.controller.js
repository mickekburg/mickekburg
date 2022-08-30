(function ($) {
    $.fn.treeController = function (type) {
		let $this = $(this);
		let catalogData=window[$this.data('var')];
		let pids=$this.data('pids').toString().split(',');
		let is_one = $(this).data('is_one')?$(this).data('is_one'):0;

		let appendChilds2 = (children) => {
			let code='';
			if(typeof children !== 'undefined'&&children.length){
				children.forEach((element) => {
					let liClass=element['expand']?"tree-expanded":"tree-collapsed";
					liClass+=element.hasOwnProperty('children')||element.hasOwnProperty('needload')?" tree-branch":" tree-leaf";
					if(element['is_show']) liClass+=" noactive";
					if(element['active']) liClass+=" active";
					if(element.hasOwnProperty('needload')) liClass+=" notload";
					if(pids.includes(element['id'].toString())){
						liClass+=" active";
					}

					code+=
					"<li class='"+liClass+"' data-id='"+element['id']+"'>"+
						"<div class='catalog-one d-flex'>"+
							"<a href='#' class='collapse-category mr10'></a>"+
							"<div class='name'><a href='#'>"+element['name']+"</a></div>"+
						"</div>";
					if(element.hasOwnProperty('children')){
						code+="<ul>";
						code+=appendChilds2(element['children']);
						code+="</ul>";
					}
					code+="</li>";
				});
			}
			return code;
		}

		$this.on('click', '.current-selected-box', function(event){
			$this.toggleClass('active');
			return false;
		});

		$this.on('click', '.name a', function(event){
			let $li=$(this).closest('li');
			if(is_one){
				$this.find('.current-selected-box ul li').remove();
			}
			if($li.hasClass('active')){
				$this.find('.current-selected-box li[data-element='+$li.attr('data-id')+']').remove();
			}
			else{
				if(is_one){
					$li.closest('.level0').find('li').removeClass('active');
				}
				$this.find('.current-selected-box ul li.empty').remove();
				$this.find('.current-selected-box ul').append("<li data-element='"+$li.attr('data-id')+"'><span class='name'>"+get_pids_name($li.attr('data-id'))+"</span> <a href='' class='delete-pids color-red' title='Удалить'><i class='fas fa-times'></i></a></li>");
			}

			construct_pids();
			$li.toggleClass('active');
			return false;
		});

		$this.on('click', '.delete-pids', function(event){
			let $li=$(this).closest('li');
			$this.find('.level0 li[data-id='+$li.attr('data-element')+']').removeClass('active');
			$li.remove();
			construct_pids();

			return false;
		});

		//Закрыть окна
		$(window).click(function(event) {
			if(!$(event.target).closest('.tree-controller').length) {
				$('.tree-controller').removeClass('active');
			}
		});

		$this.on('click', '.collapse-category', function(){
			let $li=$(this).closest('li');
			if($li.hasClass('tree-collapsed')){
				if ($li.hasClass('notload')) {
                    ajaxLoadNodes2([$li.data('id')]);
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

		let construct_pids = () => {
			let values=[];
			if(!$this.find('.current-selected-box li').length){
				$this.find('.current-selected-box ul').html("<li class='empty'>Ничего не выбрано</li>");
			}
			else{
				$this.find('.current-selected-box li').each(function(){
					values.push($(this).attr('data-element'));
				});
			}
			$this.find('input').val(values.join(','));
		}

		let get_selected_pids = () => {
			if(!$this.data('pids')||pids.length==0){
				return "<li class='empty'>Ничего не выбрано</li>";
			}
			let str="";
			pids.forEach((element) => {
				if(element){
					str+="<li data-element='"+element+"'><span class='name'>"+get_pids_name(element)+"</span> <a href='' class='delete-pids color-red' title='Удалить'><i class='fas fa-times'></i></a></li>";
				}
			});
			return str;
		}

		let get_pids_name = (element) => {
			let path=[];
			if(element){
				let $li=$this.find("li[data-id="+element+"]");
				path.push($li.find(".name a").first().text());

				var i=0;
				while(!$li.closest("ul").hasClass('level0')){
					$li=$li.closest("ul").closest("li");
					path.push($li.find(".name a").first().text());
					++i;

					if(i>20) break;
				}
			}
			return path.reverse().join(" / ");
		}

		let ajaxLoadNodes2 = (ids, recursive = 0, render_opened = 0, force_open = 0) => {
			$.each(ids, function (index, value) {
				if($this.find('.tree-branch[data-id="'+value+'"]').hasClass('notload')){
					$this.find('.tree-branch[data-id="'+value+'"]').addClass('loading').removeClass('notload ');
				}
			});

			var data = {
				ids: ids,
				recursive: recursive,
				render_opened: render_opened,
				force_open: force_open
			};


			$.ajax({
				url: $this.data('get_nodes'),
				type:   'POST',
				data: data,
				dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(result){
					$.each(result, function (index, value) {
						let $li=$this.find("li[data-id="+index+"].loading");
						if($li.length){
							$li.append("<ul>"+appendChilds2(value)+"</ul>");
							$li.removeClass('loading');
							$li.removeClass('tree-collapsed').addClass('tree-expanded');
						}
					});
				},
				error:function(result){
					//console.log(result);
				}
			});
        }

		$this.append("<ul class='level0'>"+appendChilds2(catalogData)+"</ul>");
		$this.html("<div class='current-selected-box'><ul>"+get_selected_pids()+"</ul><span></span><input type='hidden' name='"+$this.data('name')+"' value='"+$this.data('pids')+"'></div>"+$this.html());
	};

})(jQuery);
