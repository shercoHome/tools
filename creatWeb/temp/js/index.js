$(document).ready(function() {

// 焦点图片切换
    $("#banner").slide({ titCell:".dot ol", mainCell:"ul.picture", effect:"left",  autoPlay:true, autoPage:true, trigger:"click" });

// 新闻列表
    $(".summary").slide({mainCell:"ul",autoPage:true,effect:"top",autoPlay:true});

// 产品菜单
    $(".name").each(function(index, el) {
        var stickwidth = (1000 - $(this).width() - 14)/2;
        $(this).siblings('.sticks').find('li').width(stickwidth);
    });
    $(".column-pro").slide({mainCell:".pro ul",autoPage:true,effect:"left",autoPlay:true,vis:4});
    
// 关于我们
    $(".infomation").slide({titCell:"ol.info-hd li", mainCell:".info ul", effect:"left", autoPlay:true, delayTime:300,trigger:"click", triggerTime:50, startFun:function(i){
        $("http://www.honghuistone.cn/js/.infomation .lump").animate({left:105*i},150);
        }
    });

// 新闻资讯
    $(".column-news").slide({ titCell:"ol.news-center li", mainCell:".newsimg ul",effect:"top", delayTime:200, autoPlay:true,triggerTime:0});
    //文字切换
    $(".column-news").slide({ titCell:"ol.news-center li", mainCell:".newstxt ul",delayTime:50, autoPlay:true});
});
