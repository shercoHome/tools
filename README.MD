## 目录
1. ZFB 支付宝转银行卡，自动提交表单
2. creatWeb SEO 批量根据模板建站工具
3. jpgascll
4. site SEO 查询工具
5. test
5. vue-plan-api 接口
6. wechatJump 微信、qq指导跳出到浏览器访问（top跳转到哪个网址   www.xxxx.cn ）
7. wechatJump2 微信、qq指导跳出到浏览器访问
8. wechatMP 微信用iframe打开网站，以便正常浏览已屏蔽的网站
9. wwwroot creatWeb生成的网站

## Win2008系统+IIS7.0下安装SSL证书教程
### 申请免费SSL证书
https://freessl.cn/

### KeyManager 生成CSR
https://keymanager.org/

### IIS安装证书
http://baijiahao.baidu.com/s?id=1601252392478469692

## 服务器相关
### 无法从本地复制文件到远程桌面
解决办法：
* 重启rdpclip.exe。

    rdpclip.exe is the main executable for File Copy. It provides function for the Terminal Services server that allows you to copy and paste between server and client. This program is important for the stable and secure running of your computer and should not be terminated.

    1. 打开任务管理器
    2. 结束rdpclip.exe
    3. win+R
    4. 输入rdpclip.exe，回车，即重新启动。

## IIS建站
### 除非 Windows Activation Service (WAS)和万维网发布服务(W3SVC)均处于运行状态，否则无法启动网站

解决办法：
* 在WINDOWS服务管理里 启动 World Wide Web Publishing Service 即可！
    1. 打开WINDOWS服务管理方法：
    2. 在运行内输入services.msc
    3. 就可以打开服务
    4. 找到windowsa installer
    5. 右键——启动
    6. 右键属性——启动类型——自动就可以了

### IIS提示“另一个程序正在使用此文件，进程无法访问。（异常来自HRESULT:0x80070020) ”

    问题原因
    80或是443端口已被另一个程序占用

解决办法
1. 打开CMD DOS模式窗口
2. 在窗口中输入 netstat -obna 之后回车，在列出来的信息遂个查看443端口和80端口是否被占用
3. 记住使用80端口的pid号，在命令提示符下输入tasklist，用上边出现的pid号找到对应的程序，结束它

### 401 - 未授权: 由于凭据无效，访问被拒绝。

    您无权使用所提供的凭据查看此目录或页面。
 
解决方法：
1. 打开“IIS信息服务管理器”——》选择你发布的网站——》选择功能视图中的“身份验证”——》右键匿名身份验证，选择“编辑”，选择“特定用户IUSR”；如果没有找到IUSR，就点击添加 输入 IUSR 密码为空。
2. 右键要发布的网站文件夹，选择“安全”——》“编辑”——》“添加”——》“高级”——》“立刻查询”——》选择“IUSR”用户，然后保存；

### 401 - 未授权: 由于凭据无效，访问被拒绝。

### 服务器无法加载字体、app，显示404。

文件后缀|MIME类型
-----|-----|
.plist|application/xml|
.ipa|application/octet-stream|
.apk|application/vnd.android.package-archive|
.woff|application/x-font-woff|

## sql相关
### 评论表的设计

字段名称|字段说明
-----|-----|
id||
fromQuestionID|question`s id|
commentAuthor|user`s id|
commentContent|string|
commentCreatTime||
underWhichCommentID| null or commentID|
isDelete||

    联表获取user信息，同question（underWhichCommentID==null）下（或同under）按时间顺序排序即可，即线性结构
    如需点赞功能，另开一表（id、commentID、userID、type=like/hate、time）

### SQL 追加
```sql
UPDATE test SET user= CONCAT(user,',phpchina')  WHERE id= '2';
```