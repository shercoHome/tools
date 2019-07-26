$(document).ready(function() {

// 导航
    //获取地址，以及滑块定位
    $("ul.nav a").each(function(){  
        $this = $(this);  
        if($this[0].href == String(window.location)){  
            $this.parents("ul.nav>li").addClass("in");
        }  
    });  
    if ($("ul.nav>li").hasClass('in') == false) {
        $("ul.nav>li:eq(0)").addClass('in')
    };

    var initial = $("ul.nav>li.in").position().left;
    var liWidth = $("ul.nav>li.in").width();

    $(".trilateral").css({left:initial,width:liWidth});
    $("ul.nav>li").mouseover(function(){
        var thisWidth = $(this).width();
        var leftPosition = $(this).position().left;
        $(".trilateral").stop(true,false).animate({left:leftPosition,width:thisWidth}, 400);
    });
    $("http://www.honghuistone.cn/js/ul.nav").mouseleave(function(event) {
        $(".trilateral").stop(true, true).animate({left:initial,width:liWidth},400);
    });

    // 二级导航宽度与定位
    $(".subnav").each(function(index, el) {
        var subwidth = $(this).siblings('a').width() *1.5;
        var subleft = ($(this).parent("li").width() - subwidth)/2;
        $(this).css({width:subwidth,left:subleft});
    });

    // 二级导航栏淡入淡出
    $("#nav>li").hover(function() {
        $(this).find('.subnav').stop(true, true).slideDown(400);
    }, function() {
        $(this).find('.subnav').slideUp(300);
    });

// 焦点图片切换
    $(".banner").slide({ titCell:".dot ol", mainCell:"ul.picture", effect:"left",  autoPlay:true, autoPage:true, trigger:"click" });

// 编辑框
    $("ul.first a").click(function(event) {
        if ($(this).siblings("ul").length > 0) {
            var a=$(this);
            var thisname = a.parent().attr('class');
            if (thisname == null || thisname == 0) {
                a.siblings("ul").show(400);
                a.parent().siblings().find('ul').animate({width:"0px"}, 300).parent().removeClass();
                var parent = a.parent().parent("ul").attr('class');
                switch (parent) {
                    case "first":
                        a.parent().addClass("box-on");
                        break;
                    case "second":
                        a.parent().addClass("box-in");
                        break;
                    default:
                        a.parent().addClass("box_at");
                }
            }else{
                a.parent().removeClass().find('ul').hide(300);
                a.siblings('ul').find('li').removeClass().find('ul').hide(300);
            };
            return false;
        };
    });

// 产品展示
    if ($(".case-list img").length > 1) {
        $(".case").hover(function() {
            $(".case .scroll").find('http://www.honghuistone.cn/js/a.prev').stop(true, true).animate({left:"7px"}, 300).siblings('http://www.honghuistone.cn/js/a.next').stop(true, true).animate({right:"7px"}, 300);
        }, function() {
            $(".case .scroll").find('http://www.honghuistone.cn/js/a.prev').animate({left:"-50px"}, 300).siblings('http://www.honghuistone.cn/js/a.next').animate({right:"-50px"}, 300);
        });
    };
    jQuery(".case").slide({mainCell:".case-list",autoPage:true,effect:"left",autoPlay:true,vis:1,trigger:"click"});

});
