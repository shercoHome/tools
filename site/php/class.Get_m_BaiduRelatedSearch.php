<?php
class Get_m_BaiduRelatedSearch
{
    private $searchWord;

    public function __construct()
    {
        $this->searchWord="达诚信息技术";
    }
    public function get($info=array())
    {
        if (array_key_exists('searchWord', $info)) {
            $this->searchWord=$info ['searchWord'];
        }
        $strlen_searchWord=mb_strlen($this->searchWord);
        $array = array(
            "word" => $this->searchWord
        );
        require_once 'HTTPRequester.php';
        $tool=new HTTPRequester();
        $html=$tool->HTTPGet("http://m.baidu.com/s", $array);
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8")) {
            $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        }
        $result=array();
        $isResultMatchest=false;
        $patternt_list='|<div class="rw-list-new".*</div>|isU';
        preg_match_all($patternt_list, $html, $matchest_list);
        if (count($matchest_list[0])<=0) {
            return array("data"=>$result,"re"=>$isResultMatchest);
        }
        include('simple_html_dom.php');
        foreach ($matchest_list[0] as $_ONE_LIST_) {
            $htmlObj = str_get_html($_ONE_LIST_);
            $matches_word = $htmlObj->find('span', 0)->innertext; // result: "ok"
            array_push($result, array("keyword"=>$matches_word));//,"checkResult"=>$__re__
        }
        $htmlObj->clear();
        return array("data"=>$result,"re"=>$isResultMatchest);
    }
}


// $Get_m_BaiduRelatedSearch=new Get_m_BaiduRelatedSearch();
// $result =  $Get_m_BaiduRelatedSearch->get();

// echo json_encode($result);
