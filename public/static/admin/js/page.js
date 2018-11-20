
var page=new Vue({
	el:'.page',
	data:{
		url:'',
		where:[],
		allCount:'',
        page:'1',
        products:[],
        html:''

	},
	methods:{
		page1:function(val){
				this.page=val;//当前页面
				this.where['page'] = val;
				
                this.$http.post(baseurl+'?s='+this.url,{page:val,where:this.where}).then(res=>{
               
                var val=eval('('+res.bodyText+')');
                
                //赋值教师列表
                vue.products=val['value'];
                
                this.serachpage(val['page']);
                
            },res=>{
                console.log('请求失败处理,请检查Network!');
            })
        },
        serachpage:function (page){
            //获取当前页面
           
            var max = parseInt(page)+3;
            var min = parseInt(page)-3;

            if (max > 7) {
                if (max > this.allCount) {
                    max=this.allCount;
                }

                if (min < 1) {
                    min = 1;
                }
            }else{
                max=7;
                min=1;
            }
            //点击分页时调用更改分页样式
            var html='<li><a href="javascript:void(0)" onclick="page1(\'prev\');">上一页</a></li>';
            if(min > 1){
                html+='<li><a href="javascript:void(0)" >...</a></li>';
            }
           
            for(var i=1; i<this.allCount+1; i++ ){

                if ( i >= min && i <= max) {
                    if (this.page==i) {
                        html+='<li class="curr"><a href="javascript:void(0)" onclick="page1(\''+i+'\');">'+i+'</a></li>';
                    }else{
                        html+='<li><a href="javascript:void(0)" onclick="page1(\''+i+'\');">'+i+'</a></li>';                        
                    }
                }
            }
            if(max < this.allCount){
                html+='<li><a href="javascript:void(0)" >...</a></li>';
            }
            html+="<li><a href='javascript:void(0)' onclick='page1(\"next\")';>下一页</a></li>";

            return this.html=html;

        },
        htmlPage:function(counts){//这是总页数（点击搜索之后会调用这个方法）

            this.allCount=counts;
            //生成默认分页样式
            if(counts==""){
                page.onload();
            }
            
            var html='<li><a href="javascript:void(0)" onclick="page1(\'prev\');">上一页</a></li>';
            for(var i=0; i<counts; i++ ){
                if(i < 7){
                    if (i=='0') {
                        html+='<li class="curr"><a href="javascript:void(0)" onclick="page1(\''+(i+1)+'\');">'+(i+1)+'</a></li>';
                    }else{
                        html+='<li><a href="javascript:void(0)" onclick="page1(\''+(i+1)+'\');">'+(i+1)+'</a></li>';
                    }
                }
            }
            
            if(i > 7){
                html+='<li><a href="javascript:void(0)">...</a></li>';
            }
            
            html+="<li><a href='javascript:void(0)' onclick='page1(\"next\")';>下一页</a></li>";
            return this.html=html;

        },
        onload:function(){

                this.$http.post(baseurl+'?s='+this.url,{'where':this.where}).then(res=>{
                //console.log(res);
                var val=eval('('+res.bodyText+')');
                //赋值教师列表
                vue.products=val['value'];
                //获取总共多少页面
                this.allCount=val['allCount'];
                //console.log(this.allCount);
                if(this.allCount==0){
                    return;
                };
                //处理总共多少页
                this.html=this.$options.methods.htmlPage(this.allCount);
                //console.log(this.html);
            },res=>{
                console.log('请求失败处理,请检查Network!');
            })
            
        }
        
	}
})



function page1(data){
        //从vue获取当前页
        var pages=page.page;

        //判断是否是超过总页数
        if (data=='next') {
            data=parseInt(pages)+1;
        }else if(data=='prev'){
            data=parseInt(pages)-1;
        }
        //判断是否是超过总页数，是否小于0页
        if (data > page.allCount || data <= '0') {
            return;
        }
        //调用vue
        page.page1(data);
     
    }  