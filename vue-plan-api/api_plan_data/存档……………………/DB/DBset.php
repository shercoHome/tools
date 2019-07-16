<?php
date_default_timezone_set("Asia/Chongqing");
// php实现对文本数据库的数据显示、加入、修改、删除、查询五大基本操作的方法。

// private $txtSetFile;  //储存配置文件的路径;

// 此文本数据库共有字段5个：

// private $authorize;  //是否开启授权验证 0   1
// private $shareRequired;  //分享ip数要求，默认100
// private $authorizeWhite;   //授权白名单，直接授权无分享ip限制 以#分隔每一个账号
// private $authorizeBlack;   //授权黑名单，永不授权 以#分隔每一个账号
// private $planId;   //默认显示的计划代码，1-100，0表示由系统筛选最佳
// @abstract   TxtDB store
// @access     public
// @author
class DBset
{
    private $txtSetFile;  //储存配置文件的路径;

    private $authorize;  //是否开启授权验证 0   1
    private $shareRequired;  //分享ip数要求，默认100
    private $authorizeWhite;   //授权白名单，直接授权无分享ip限制
    private $authorizeBlack;   //授权黑名单，永不授权
    private $planId;   //默认显示当前胜率第几名计划，1-30

    public function __construct()
    {
        $this->txtSetFile=dirname(__FILE__)."/txt/set.txt";  //储存配置文件的路径;

        if (!file_exists($this->txtSetFile)) {
            $list=array(
                "authorize|0|\r\n",
                "shareRequired|100|\r\n",
                "authorizeWhite|name1#name2|\r\n",
                "authorizeBlack|name1#name2|\r\n",
                "planId|2|"
            );
            file_put_contents($this->txtSetFile, $list);
        } 
        //数据显示程序段
        if (file_exists($this->txtSetFile)) { //检测文件是否存在
            $array = file($this->txtSetFile); //将文件全部内容读入到数组$array

           
            $this->authorize=explode("|", $array[0])[1];  //是否开启授权验证 0   1
            $this->shareRequired=explode("|", $array[1])[1];  //分享ip数要求，默认100
            $this->authorizeWhite=explode("|", $array[2])[1];  //授权白名单，直接授权无分享ip限制
            $this->authorizeBlack=explode("|", $array[3])[1];   //授权黑名单，永不授权
            $this->planId=explode("|", $array[4])[1];   //默认显示的计划代码，1-100，0表示由系统筛选最佳
        } else {
            echo 'set_file_not_exists';
        }
    }

    public function show()
    {
        return array(
            "authorize"=>$this->authorize,
            "shareRequired"=>$this->shareRequired,
            "authorizeWhite"=>explode("#", $this->authorizeWhite),
            "authorizeBlack"=>explode("#", $this->authorizeBlack),
            "planId"=>$this->planId,
        );
    }

    /**
     * 数据修改程序段
     * private $authorize;  //是否开启授权验证 0   1
     * private $shareRequired;  //分享ip数要求，默认100
     * private $authorizeWhite;   //授权白名单，直接授权无分享ip限制
     * private $authorizeBlack;   //授权黑名单，永不授权
     * @return boolean 成功  true
     *  失败 false
     */
    public function alter($key, $value)
    {
        $list = file($this->txtSetFile); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第二条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n

        if ($n > 0) { //如果用户数大于0
            $fp = fopen($this->txtSetFile, "w"); //则以只写模式打开文件userlist.txt
            for ($i = 0; $i < $n; $i ++) { //进入循环
                $f = explode("|", $list [$i]);

                if ($key==$f[0]) {
                    $add_value=$value;
                    switch ($i) {
                        case 0:
                        $this->authorize=$value;
                        break;
                        case 1:
                        $this->shareRequired=$value;
                        break;
                        case 2:
                        $authorizeName=explode("#", $f [1]);
                        if (!in_array($value, $authorizeName)) {
                            $this->authorizeWhite=  $f [1]."#".$value;
                            $add_value= $f [1]."#".$value;
                        } else {
                            $add_value= $f [1];
                        }
                        break;
                        case 3:
                        $authorizeName=explode("#", $f [1]);
                        if (!in_array($value, $authorizeName)) {
                            $this->authorizeBlack= $f [1]."#".$value;
                            $add_value= $f [1]."#".$value;
                        } else {
                            $add_value= $f [1];
                        }
                        break;
                        case 4:
                        $this->planId=$value;
                        break;
                        default:
                    }

                    $list [$i] = $f [0] . "|" .$add_value . "|\r\n";

                    break; //跳出循环
                }
            }//循环结束符
        }
        fclose($fp); //关闭文件
        $fwriteResult=file_put_contents($this->txtSetFile, $list);
        return $fwriteResult;
    }
    /**
     * 数据删除程序段
     * private $authorizeWhite;   //授权白名单，直接授权无分享ip限制
     * private $authorizeBlack;   //授权黑名单，永不授权
     * @return boolean 成功  true
     *  失败 false
     */
    public function delete($key, $value)//
    {
        $list = file($this->txtSetFile); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第二条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n

        if ($n > 0) { //如果用户数大于0
            $fp = fopen($this->txtSetFile, "w"); //则以只写模式打开文件userlist.txt
            for ($i = 0; $i < $n; $i ++) { //进入循环
                $f = explode("|", $list [$i]);

                if ($key==$f[0]) {
                    $add_value=$value;
                    switch ($i) {
                        case 0:
                        case 1:
                        case 4:
                        break;
                        case 2:
                        case 3:
                        $authorizeName=explode("#", $f [1]);
                        if (!in_array($value, $authorizeName)) {
                            $add_value= $f [1];
                        } else {
                            $nn=count($authorizeName);
                            $add_value_array=array();
                            for ($ii = 0; $ii < $nn; $ii ++) { //进入循环

                                if ($value!=$authorizeName[$ii]) {
                                    array_push($add_value_array, $authorizeName[$ii]);
                                }
                            }
                            $add_value=implode("#", $add_value_array);
                        }

                        if ($i==2) {
                            $this->authorizeWhite=$add_value;
                        } else {
                            $this->authorizeBlack=$add_value;
                        }
                        break;
                        default:
                    }

                    $list [$i] = $f [0] . "|" .$add_value . "|\r\n";

                    break; //跳出循环
                }
            }//循环结束符
        }
        fclose($fp); //关闭文件
        $fwriteResult=file_put_contents($this->txtSetFile, $list);
        return $fwriteResult;
    }
    public function __destruct()
    {
    }
}
