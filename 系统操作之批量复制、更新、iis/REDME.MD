## 无法启动网站
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

401 - 未授权: 由于凭据无效，访问被拒绝。
您无权使用所提供的凭据查看此目录或页面。
 

解决方法：

1、打开“IIS信息服务管理器”——》选择你发布的网站——》选择功能视图中的“身份验证”——》右键匿名身份验证，选择“编辑”，选择“特定用户IUSR”；如果没有找到IUSR，就点击添加 输入 IUSR 密码为空。

2、右键要发布的网站文件夹，选择“安全”——》“编辑”——》“添加”——》“高级”——》“立刻查询”——》选择“IUSR”用户，然后保存；



.plist  application/xml
.ipa    application/octet-stream
.apk    application/vnd.android.package-archive
.woff   application/x-font-woff

id:
fromQuestionID:question`s id
commentAuthor:user`s id
commentContent:string
commentCreatTime
underWhichCommentID: null or commentID
isDelete

联表获取user信息，同question（underWhichCommentID==null）下（或同under）按时间顺序排序即可，即线性结构
如需点赞功能，另开一表（id、commentID、userID、type=like/hate、time）

SQL
追加
UPDATE test SET user= CONCAT(user,',phpchina')  WHERE id= '2';