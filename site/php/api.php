<?php
if (is_array($_POST)&&count($_POST)>0) {
    $info=array();
    if (isset($_POST["searchWord"])) {
        if (strlen($_POST["searchWord"])>0) {
            $info["searchWord"]=trim($_POST['searchWord']);
        }
    }
    if (isset($_POST["searchPercent"])) {
        if (strlen($_POST["searchPercent"])>0) {
            $info["searchPercent"]=trim($_POST['searchPercent']);
        }
    }
    if (isset($_POST["needCheck"])) {
        if (strlen($_POST["needCheck"])>0) {
            $info["needCheck"]=trim($_POST['needCheck']);
        }
    }

    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            $type=trim($_POST['type']);

            switch ($type) {
                case "checkBaiduKeyWord":
                    require_once "class.checkBaiduKeyWord.php";
                    $checkBaiduKeyWord=new checkBaiduKeyWord();
                    $result =  $checkBaiduKeyWord->check($info);
                    echo json_encode($result);
                break;
                    case "GetBaiduRelatedSearch":
                    require_once "class.GetBaiduRelatedSearch.php";
                    $GetBaiduRelatedSearch=new GetBaiduRelatedSearch();
                    $result =  $GetBaiduRelatedSearch->get($info);

                    echo json_encode($result);
                break;

                case "check_m_BaiduKeyWord":
                    require_once "class.check_m_BaiduKeyWord.php";
                    $check_m_BaiduKeyWord=new check_m_BaiduKeyWord();
                    $result =  $check_m_BaiduKeyWord->check($info);
                    echo json_encode($result);
                break;
                case "Get_m_BaiduRelatedSearch":
                    require_once "class.Get_m_BaiduRelatedSearch.php";
                    $Get_m_BaiduRelatedSearch=new Get_m_BaiduRelatedSearch();
                    $result =  $Get_m_BaiduRelatedSearch->get($info);

                    echo json_encode($result);
                break;

            }
        }
    }
}
