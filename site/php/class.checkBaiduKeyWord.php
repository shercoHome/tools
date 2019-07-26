<?php



class checkBaiduKeyWord
{
    private $searchWord;
    private $searchPercent;
    public function __construct()
    {
        $this->searchWord="达诚信息技术";
        $this->searchPercent="100";
    }
    public function check($info=array())
    {
        if (array_key_exists('searchWord', $info)) {
            $this->searchWord=$info ['searchWord'];
        }
        if (array_key_exists('searchPercent', $info)) {
            $this->searchPercent=$info ['searchPercent'];
        }

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
        $patternt='|<h3 class="t">.*</h3>|isU';
        preg_match_all($patternt, $html, $matchest_titile_array);
        if (count($matchest_titile_array[0])>0) {
            $patternt='|<a .*</a>|isU';
            foreach ($matchest_titile_array[0] as $html_a) {
                preg_match_all($patternt, $html_a, $matchest_a);
                $baidu_title=$matchest_a[0][0];
                $strlen_repeat=similar_text($this->searchWord, $baidu_title);
                $similar=$strlen_repeat/$strlen_searchWord;
                if ($this->searchPercent<=$similar) {
                    $isMatchest=true;
                    $isResultMatchest=true;
                } else {
                    $isMatchest=false;
                }
                $similarStr=number_format($similar*100, 2)."%";
                array_push($result, array("title"=>$baidu_title,"percent"=>$similarStr,"isMatchest"=>$isMatchest));
            }
        }
        return array("data"=>$result,"re"=>$isResultMatchest);
    }
}
