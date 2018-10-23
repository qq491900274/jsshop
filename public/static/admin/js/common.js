/***
**功能点1、头部高亮部分
*********/
$('#header').on('mouseenter','#first>li',function(){
	$(this).addClass('active');
});
$('#header').on('mouseleave','#first>li',function(){
	$(this).removeClass('active');
});

$('#header').on('mouseenter','#second>li',function(){
	$(this).addClass('active');
});
$('#header').on('mouseleave','#second>li',function(){
	$(this).removeClass('active');
});


/**
 *全选 
**/
function selectAll(class_id){
	if(!class_id)	class_id = 'check_one';
	$('.'+class_id).prop('checked',true);
}
/**
 *反选
**/
function uselectAll(class_id){
	if(!class_id)	class_id = 'check_one';
	$('.'+class_id).each(function(){
		if($(this).prop('checked')){
			$(this).prop('checked',false);
		}else{
			$(this).prop('checked',true);
		}
	});
}

/*
function import1(url_path) {
    var url =url_path;
    $('#import').on('click',function () {
        var str='<div id="select_branch1" class="g_select g_select_template"><form action="" enctype="multipart/form-data" method="post" id="form2" name="form"><input type="file" name="import" id="file" value="" style="margin-top: 34px;margin-left: 8px;" /></form></div>';
        var lock = false;
        layer.open({
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            shade:0,
            area: ['300px', '180px'], //宽高
            content: str,
            title: '请选择您需要导入的文件',
            btn: ['确定', '取消'],
            yes:function(index){
                var file=$('#file').val();
                if(!lock){
                    lock = true;
                    if(file.length){
                        var data = new FormData($('#form2')[0]);
                        console.log(data)
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: data,
                            dataType: 'JSON',
                            cache: false,
                            processData: false,
                            contentType: false
                        }).done(function(data){
                            if(data.status == 0){
                                layer.msg(data.info,{icon: 1, time: 1000},function () {
                                    location.reload();
                                })
                            }else{
                                layer.msg(data.info)
                            }
                        });
                    }else {
                        layer.msg("请选择文件");
                    }
                }
            },
        });
    })
}
*/