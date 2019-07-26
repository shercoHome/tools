<?php
class GetBaiduRelatedSearch
{
    private $searchWord;
    // private $searchPercent;
    // private $needCheck;

    public function __construct()
    {
        $this->searchWord="达诚信息技术";
        // $this->searchPercent="100";
        // $this->needCheck="0";
    }
    public function get($info=array())
    {
        if (array_key_exists('searchWord', $info)) {
            $this->searchWord=$info ['searchWord'];
        }
        // if (array_key_exists('searchPercent', $info)) {
        //     $this->searchPercent=$info ['searchPercent'];
        // }
        // if (array_key_exists('needCheck', $info)) {
        //     $this->needCheck=$info ['needCheck'];
        // }

        $strlen_searchWord=mb_strlen($this->searchWord);
        $array = array(
            "wd" => $this->searchWord
        );
        require_once 'HTTPRequester.php';
        $tool=new HTTPRequester();
        $html=$tool->HTTPGet("http://www.baidu.com/s", $array);
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8")) {
            $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        }

        $result=array();
        $isResultMatchest=false;

        
        $patternt = '|<div class="tt">相关搜索</div>|isU';
        preg_match_all($patternt, $html, $matchest_related);
        if (count($matchest_related[0])<=0) {
            return array("data"=>$result,"re"=>$isResultMatchest);
        }

    
        $patternt='|<table cellpadding="0">.*</table>|isU';
        preg_match_all($patternt, $html, $matchest_table);
        if (count($matchest_table[0])>0) {
            $pa='|<a .*</a>|isU';
            preg_match_all($pa, $matchest_table[0][0], $matchest_a);
            foreach ($matchest_a[0] as $h3) {
                // if (preg_match("|href=\".*\"|isU", $h3, $matches_href_array)) {
                //     $matches_href=$matches_href_array[0];
                //     $matches_href="http://www.baidu.com".mb_substr($matches_href, 6, -1);
                // } else {
                //     $matches_href="null";
                // }
                if (preg_match("|>.*<|isU", $h3, $matches_word_array)) {
                    $matches_word=$matches_word_array[0];
                    $matches_word=mb_substr($matches_word, 1, -1);
                } else {
                    $matches_word="null";
                }


                $__re__="null";
                // if($this->needCheck=="1" && $matches_word!=="null" && $matches_word){
                //     require_once "class.checkBaiduKeyWord.php";
                //     $check=new checkBaiduKeyWord();
                //     $checkInfo=array();
                //     $checkInfo["searchWord"]=trim($matches_word);
                //     $checkInfo["searchPercent"]=trim($this->searchWord);
                //     $checkResult =  $check->check($checkInfo);
                //     $__re__=$checkResult['re'];
                // }
                


                array_push($result, array("keyword"=>$matches_word));//,"checkResult"=>$__re__
            }
        }
        return array("data"=>$result,"re"=>$isResultMatchest);
    }
}
