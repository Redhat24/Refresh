<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_validator = $show_scroll = $show_dialog = 1; 
include $this->admin_tpl('header', 'admin');
?>
<form action="?m=album&c=album&a=add" id="myform" method="post">
<div class="pad-10">
<div class="col-tab">
	<ul class="tabBut cu-li">
		<li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',6,1);">
			<?php echo L('catgory_basic', '', 'admin');?>
		</li>
		<li id="tab_setting_2" onclick="SwapTab('setting','on','',6,2);"><?php echo L('extend_setting')?></li>
		<li id="tab_setting_3" onclick="SwapTab('setting','on','',6,3);"><?php echo L('catgory_readpoint')?></li>
	</ul>
<div id="div_setting_1" class="contentList pad-10">
	<table width="100%" class="table_form">
		<tbody>
			<tr>
				<th width="200"><?php echo L('album_title')?>:</th>
				<td><input name="album[title]" type="text" id="title" class="input-text" size="40" onBlur="$.post('api.php?op=get_keywords&number=3&sid='+Math.random()*5,{data:$('#title').val()},function(data){if(data && $('#keywords').val()=='') $('#keywords').val(data);})" /></td>
			</tr>
			<tr>
				<th width="200">专辑副标题:</th>
				<td><input name="album[subtitle]" type="text" class="input-text" size="20" id="subtitle" /></td>
			</tr>
			<tr>
				<th width="200"><?php echo L('album_thumb')?>:</th>
				<td><?php echo form::images('album[thumb]','thumb','','album','',40,'','','',array(350,350));?></td>
			</tr>
			<tr>
				<th width="200"><?php echo L('lecturer_info')?>:</th>
				<td><textarea name="album[lecturer]" id="lecturer" cols="50" rows="6"></textarea></td>
			</tr>
			<tr>
				<th width="200"><?php echo L('album_intro')?>:</th>
				<td><textarea name="album[description]" id="description" cols="50" rows="6"></textarea></td>
			</tr>
			<tr>
				<th width="200">标签：</th>
				<td><input type="text" name="album[keywords]" id="keywords" value="" size="50"/></td>
			</tr>
			<tr>
				<th width="200"><?php echo L('album_belong_category')?>:</th>
				
				<td>
					<?php echo $model_form;?><span id="catids"></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
		
		<tr>
			<th align="right"  valign="top" width="200"><?php echo L('template_style')?>：</th>
			<td valign="top"><?php echo form::select($template_list,$info['default_style'],'name="album[style]" id="style" onchange="load_file_list(this.value)"',L('please_select'))?>
				<script type="text/javascript">
					$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $info['default_style']?>&module=album&templates=album_videolist|list|show_albumvideo&name=album',function(data){$('#album_videolist_template').html(data.album_videolist_template);$('#list_template').html(data.list_template);$('#show_albumvideo_template').html(data.show_albumvideo_template);});
				</script>
			</td>
		</tr>
		<tr>
			<th align="right" valign="top"><?php echo L('album_template')?>：</th>
			<td valign="top" id="album_videolist_template"><?php echo form::select_template('default', 'album', '', 'name="album[album_template]"', 'album_videolist');?>
		</tr>
		<tr>
			<th align="right" valign="top">专辑列表模板：</th>
			<td valign="top" id="list_template"><?php echo form::select_template('default','album','','name="album[list_template]"','list');?></td>
		</tr>
		<tr>
			<th align="right" valign="top"><?php echo L('album_content_template')?>：</th>
			<td valign="top" id="show_albumvideo_template"><?php echo form::select_template('default','album','','name="album[show_albumvideo_template]"','show_albumvideo');?>
		</tr>
	</table>
</div>
<div id="div_setting_3" class="contentList pad-10 hidden">
	<table width="100%" class="table_form">
		<tr>
			<th align="right" valign="top" width="200"><?php echo L('default_readpoint');?></th>
			<td><input type="text" name="album[price]" value="0" size="5" maxlength="5" style="text-align:center" />元</td>
		</tr>
		<tr>
      <th><?php echo L('repeatchargedays');?></th>
      <td>
	    <input name='album[repeatchargedays]' type='text' value='1' size='4' maxlength='4' style='text-align:center'> <?php echo L('repeat_tips');?>&nbsp;&nbsp;
        <font color="red"><?php echo L('repeat_tips2');?></font></td>
    </tr>
	</table>
</div>
<div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</div>
</div>
</form>

<script type="text/javascript">
function load_file_list(id){
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=album&templates=index|list|show&name=album',function(data){$('#index_template').html(data.index_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
}
function SwapTab(name,cls_show,cls_hide,cnt,cur){
	for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

function select_categorys(modelid,id){
	if(modelid){
		$.get('',{m:'album',c:'album',a:'public_categorys_albumadd',modelid:modelid,catid:id,pc_hash:pc_hash},function(data){
			if(data){
				$('#catids').html(data);
			}else{
				$('#catids').html('');
			}
		});
	}
}

	$(function(){
		$.formValidator.initConfig({
			formid:"myform",
			autotip:true,
			onerror:function(msg,obj){
				window.top.art.dialog({
					content:msg,
					lock:true,
					width:'220',
					height:'70'
				},function(){
					this.close();
					$(obj).focus();
				})
			}
		});
		$('#title').formValidator({
			autotip:true,
			onshow:"<?php echo L('please_input_album_title')?>！",
			onfocus:"<?php echo L('min_3_title')?>！",
			oncorrect:"<?php echo L('true')?>"
		}).inputValidator({
			min:1,
			onerror:"<?php echo L('please_input_album_title')?>！"
		/*}).ajaxValidator({
			type:"get",
			url:"",
			data:"m=album&c=album&a=public_check_album",
			datatype:"html",
			cached:false,
			async:'true',
			success : function(data) {
		        if( data == "1" )
				{
		            return true;
				}
		        else
				{
		            return false;
				}
			},
		error: function(){
			alert('服务器没有返回数据，可能服务器忙，请重试');
		},
		onerror : "该专辑已存在",
		onwait : "正在进行合法性校验..."*/	
		});
		$('#thumb').formValidator({
			autotip:true,
			onshow:"<?php echo L('please_upload_thumb')?>",
			oncorrect:"<?php echo L('true')?>"
		}).inputValidator({
			min:1,
			onerror:"<?php echo L('please_upload_thumb')?>"
		});
		$('#album_category').formValidator({
			autotip:true,
			onshow:"<?php echo L('album_belong_category')?>",
			oncorrect:"<?php echo L('true')?>"
		}).inputValidator({
			min:1,
			onerror:"<?php echo L('album_belong_category')?>"
		});
		$('#keywords').formValidator({
			autotip:true,
			onshow:"<?php echo L('keywords_no_null')?>",
			oncorrect:"<?php echo L('true')?>"
		}).inputValidator({
			min:1,
			onerror:"<?php echo L('keywords_no_null')?>"
		});
		$('#lecturer').formValidator({
			autotip:true,
			onshow:"<?php echo L('lecturer_no_null')?>",
			oncorrect:"<?php echo L('true')?>"
		}).inputValidator({
			min:1,
			onerror:"<?php echo L('lecturer_no_null')?>"
		});
	});
</script>
	
	
	
	
	
	
	
	