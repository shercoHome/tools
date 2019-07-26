let json_arr = [
    {
        url: "openWeb.html",
        title: "批量访问"
    }, {
        url: "siteBaidu.html",
        title: "批量siteBaidu"
    }, {
        url: "dfz.html",
        title: "域名分组"
    }, {
        url: "get-history.html",
        title: "域名历史"
    }, {
        url: "checkBaiduKeyWord.html",
        title: "去除百度屏蔽词"
    }, {
        url: "GetBaiduRelatedSearch.html",
        title: "百度相关搜索"
    }, {
        url: "check_m_BaiduKeyWord.html",
        title: "去除手机百度屏蔽词"
    },{
        url: "Get_m_BaiduRelatedSearch.html",
        title: "手机百度相关搜索"
    }
];


json_arr.forEach((element, index) => {
    let activeClass="";
    if(location.href.indexOf(element.url)!=-1){
        activeClass="activelink"
    }
    json_arr[index] = '<a class="'+activeClass+'" href="' + element.url + '">' + element.title + '</a>'
});
let ul = json_arr.join(" | ");
ul = '<link rel="stylesheet"  href="js/css.css" /><p id="myLink">' + ul + '</p>';

$(document).ready(function () {


    $("body").prepend(ul)
});