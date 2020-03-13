<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    echo "<link rel='stylesheet' href='".__TYPECHO_THEME_DIR__."/G/CSS/S.css'/>";
    echo "
    <div id='art-box' style='background-image: url(".__TYPECHO_THEME_DIR__."/G/IMG/setting.png)'>
       <div id='ab-mask'>
         <div id=ab-content>
           <p>主题设置</p>
         </div>
       </div>
     </div>";
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('图标（会显示在浏览器标签上）') , _t(''));
    $form->addInput($favicon);
    $toux = new Typecho_Widget_Helper_Form_Element_Text('toux', NULL, NULL, _t('LOGO') , _t('想要啥LOGO？（若填此项会替换头部的网站名为此处的图片）'));
    $form->addInput($toux);
    $bkimg = new Typecho_Widget_Helper_Form_Element_Text('bkimg', NULL, NULL, _t('背景图片') , _t('想要啥背景？参考，想要自动背景的可以填：https://img.xjh.me/random_img.php?type=bg&ctype=nature&return=302
'));
    $form->addInput($bkimg);
    $bkcolor = new Typecho_Widget_Helper_Form_Element_Text('bkcolor', NULL, NULL, _t('背景颜色') , _t('如果没有想要的背景就换成纯色吧'));
    $form->addInput($bkcolor);
    $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, NULL, _t('备案号') , _t('没备案当我没说'));
    $form->addInput($beian);
    $builtTime = new Typecho_Widget_Helper_Form_Element_Text('builtTime', NULL, NULL, _t('运行时间') , _t('格式YYYY-MM-DD 例如：2020-2-20'));
    $form->addInput($builtTime);
    $animateTime = new Typecho_Widget_Helper_Form_Element_Text('animateTime', NULL, NULL, _t('动画过渡时间') , _t('格式 1s'));
    $form->addInput($animateTime);
    $feedIMG = new Typecho_Widget_Helper_Form_Element_Text('feedIMG', NULL, NULL, _t('打赏二维码图片') , _t('http://...'));
    $form->addInput($feedIMG);

$enablekzmb = new Typecho_Widget_Helper_Form_Element_Radio('enablekzmb', array(
        '1' => _t('开启') ,
        '0' => _t('占地方，关闭好了')
    ) , '0', _t('右下角控制面板') , _t('默认为关闭'));
    $form->addInput($enablekzmb);

    $enableIndexPage = new Typecho_Widget_Helper_Form_Element_Radio('enableIndexPage', array(
        '1' => _t('用') ,
        '0' => _t('不用')
    ) , '0', _t('是否使用独立页面做首页') , _t('默认为关闭'));
    $form->addInput($enableIndexPage);
    $enableUpyun = new Typecho_Widget_Helper_Form_Element_Radio('enableUpyun', array(
        '1' => _t('我是盟友') ,
        '0' => _t('啥东西，不要')
    ) , '0', _t('又拍云联盟开关') , _t('默认为关闭'));
    $form->addInput($enableUpyun);
    $enableAliLogo = new Typecho_Widget_Helper_Form_Element_Radio('enableAliLogo', array(
        '1' => _t('给爸爸打个广告') ,
        '0' => _t('不给广告费就算了')
    ) , '0', _t('阿里云图标') , _t('默认为关闭'));
    $form->addInput($enableAliLogo);
    $enableOpac = new Typecho_Widget_Helper_Form_Element_Radio('enableOpac', array(
        '1' => _t('喜欢') ,
        '0' => _t('不要，快瞎了')
    ) , '0', _t('半透明开关') , _t('默认为打开'));
    $form->addInput($enableOpac);

    $enableOneRow = new Typecho_Widget_Helper_Form_Element_Radio('enableOneRow', array(
        '0' => _t('大图') ,
        '1' => _t('瀑布流[推荐]'),
        '2' => _t('简洁单排'),
        '3' => _t('简洁双排'),
    ) , '0', _t('选择你喜欢的文章展示页样式') , _t('默认为打开'));
    $form->addInput($enableOneRow);

    $kuan = new Typecho_Widget_Helper_Form_Element_Text('kuan', NULL, NULL, _t('瀑布流页面最大宽度') , _t('双排最佳宽度800px，三排最佳宽度1113px，想三排或者更多可以增加宽度'));
    $form->addInput($kuan);

    $enableRDD = new Typecho_Widget_Helper_Form_Element_Radio('enableRDD', array(
        '1' => _t('我是博士') ,
        '0' => _t('???')
    ) , '0', _t('开启罗德岛纪念图标') , _t('默认为关闭'));
    $form->addInput($enableRDD);
}

require_once __DIR__ . '/lib/shortcode.php';

/*自定义字段 */
function themeFields($layout) {
	$Height = new Typecho_Widget_Helper_Form_Element_Text('Height', NULL, NULL, _t('瀑布流图高'), _t('瀑布流图片高度，不填将输出图片原高度'));
    $layout->addItem($Height);
  
  
  $zy = new Typecho_Widget_Helper_Form_Element_Text('zy', NULL, NULL, _t('摘要'), _t('在标题下写一句文章摘要，大图模式下，为了美观，所以没有采用截取文章字数的方式'));
    $layout->addItem($zy);
}

/**
* 网站运行时间
*
* @access public
* @param mixed $arg1
*/
function getBuildTime($builtTime) {
  $day1 = strtotime($builtTime);
  $day2 = strtotime(date('Y-m-d'));

  if ($day1 < $day2) {
    $tmp = $day2;
    $day2 = $day1;
    $day1 = $tmp;
  }
  $days = ($day1 - $day2) / 86400;
  echo '<span class="btime">'  . $days. '天</span>';
}


/**
* 文章阅读次数
*
* @access public
* @param mixed
* @return
*/
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
 $views = Typecho_Cookie::get('extend_contents_views');
        if(empty($views)){
            $views = array();
        }else{
            $views = explode(',', $views);
        }
if(!in_array($cid,$views)){
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}



/**
* 通过id获取文章信息
*
* @access public
* @param mixed
* @return
*/

function GetPostById($id){

		$db = Typecho_Db::get();
		$result = $db->fetchAll($db->select()->from('table.contents')
			->where('status = ?','publish')
			->where('type = ?', 'post')
			->where('cid = ?',$id)
		);
		if($result){
			$i=1;
			foreach($result as $val){
				$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
				$post_title = htmlspecialchars($val['title']);
				$post_permalink = $val['permalink'];
        $post_date = $val['created'];
        $post_date = date('Y-m-d',$post_date);
				echo '<div class="ArtinArt">
                  <h4><a href="'.$post_permalink.'">'.$post_title.'</a></h4>
                  <p class="clear"><span style="float:left">ID:'.$id.'</span><span style="float:right">'.$post_date.'</span></p>
                </div>';
			}
		}
    else{
      return '<span>id无效QAQ</span>';
    }
}

/**
* 评论锚点修复
*
* @access public
*/
function Comment_hash_fix($archive){
  $header = "<script type=\"text/javascript\">
  (function () {
      window.TypechoComment = {
          dom : function (id) {
              return document.getElementById(id);
          },

          create : function (tag, attr) {
              var el = document.createElement(tag);

              for (var key in attr) {
                  el.setAttribute(key, attr[key]);
              }

              return el;
          },
          reply : function (cid, coid) {
              var comment = this.dom(cid), parent = comment.parentNode,
                  response = this.dom('" . $archive->respondId . "'), input = this.dom('comment-parent'),
                  form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                  textarea = response.getElementsByTagName('textarea')[0];
              if (null == input) {
                  input = this.create('input', {
                      'type' : 'hidden',
                      'name' : 'parent',
                      'id'   : 'comment-parent'
                  });
                  form.appendChild(input);
              }
              input.setAttribute('value', coid);
              if (null == this.dom('comment-form-place-holder')) {
                  var holder = this.create('div', {
                      'id' : 'comment-form-place-holder'
                  });
                  response.parentNode.insertBefore(holder, response);
              }
              comment.appendChild(response);
              this.dom('cancel-comment-reply-link').style.display = '';
              if (null != textarea && 'text' == textarea.name) {
                  textarea.focus();
              }
              return false;
          },
          cancelReply : function () {
              var response = this.dom('{$archive->respondId}'),
              holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');
              if (null != input) {
                  input.parentNode.removeChild(input);
              }
              if (null == holder) {
                  return true;
              }
              this.dom('cancel-comment-reply-link').style.display = 'none';
              holder.parentNode.insertBefore(response, holder);
              return false;
          }
      };
  })();
  </script>
  ";
  return $header;
}



/**
* 文章内容解析（短代码，表情）
*
* @access public
* @param mixed
* @return
*/
function emotionContent($content,$url)
{
    // //HyperDown解析
    // $Parsedown = new Parsedown();
    // $content =  $Parsedown->text($content);
    //表情解析
    $fcontent = preg_replace('#\@\((.*?)\)#','<img src="'. $url .'/IMG/bq/$1.png" class="bq">',$content);

    //感谢Maicong大佬的短代码解析QwQ
    $fcontent = do_shortcode($fcontent);


    //输出最终结果
    echo $fcontent;
}

/**
* 泽泽大佬的字数统计
*/
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('myyodu', 'one');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('myyodu', 'one');
class myyodu {
    public static function one()
    {
    ?>
<style>
  #custom-field input[type=text] {
display: inline-block;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  padding: .5em .6em;
  border: 0;
  outline:none;
  background: rgba(250,250,250,1);
  border-bottom: 2px solid #444;
  color: #43454A;
    width: 100%;
}
  
  
.field.is-grouped{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;  -ms-flex-wrap: wrap;flex-wrap: wrap;}.field.is-grouped>.control{-ms-flex-negative:0;flex-shrink:0}.field.is-grouped>.control:not(:last-child){margin-bottom:.5rem;margin-right:.75rem}.field.is-grouped>.control.is-expanded{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-negative:1;flex-shrink:1}.field.is-grouped.is-grouped-centered{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.field.is-grouped.is-grouped-right{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}.field.is-grouped.is-grouped-multiline{-ms-flex-wrap:wrap;flex-wrap:wrap}.field.is-grouped.is-grouped-multiline>.control:last-child,.field.is-grouped.is-grouped-multiline>.control:not(:last-child){margin-bottom:.75rem}.field.is-grouped.is-grouped-multiline:last-child{margin-bottom:-.75rem}.field.is-grouped.is-grouped-multiline:not(:last-child){margin-bottom:0}.tags{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.tags .tag{margin-bottom:.5rem}.tags .tag:not(:last-child){margin-right:.5rem}.tags:last-child{margin-bottom:-.5rem}.tags:not(:last-child){margin-bottom:1rem}.tags.has-addons .tag{margin-right:0}.tags.has-addons .tag:not(:first-child){border-bottom-left-radius:0;border-top-left-radius:0}.tags.has-addons .tag:not(:last-child){border-bottom-right-radius:0;border-top-right-radius:0}.tag{-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:#f5f5f5;border-radius:3px;color:#4a4a4a;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;font-size:.75rem;height:2em;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;line-height:1.5;padding-left:.75em;padding-right:.75em;white-space:nowrap}.tag .delete{margin-left:.25em;margin-right:-.375em}.tag.is-white{background-color:#fff;color:#0a0a0a}.tag.is-black{background-color:#0a0a0a;color:#fff}.tag.is-light{background-color:#fff;color:#363636}.tag.is-dark{background-color:#363636;color:#f5f5f5}.tag.is-primary{background-color:#00d1b2;color:#fff}.tag.is-info{background-color:#3273dc;color:#fff}.tag.is-success{background-color:#23d160;color:#fff}.tag.is-warning{background-color:#ffdd57;color:rgba(0,0,0,.7)}.tag.is-danger{background-color:#ff3860;color:#fff}.tag.is-large{font-size:1.25rem}.tag.is-delete{margin-left:1px;padding:0;position:relative;width:2em}.tag.is-delete:after,.tag.is-delete:before{background-color:currentColor;content:"";display:block;left:50%;position:absolute;top:50%;-webkit-transform:translateX(-50%) translateY(-50%) rotate(45deg);transform:translateX(-50%) translateY(-50%) rotate(45deg);-webkit-transform-origin:center center;transform-origin:center center}.tag.is-delete:before{height:1px;width:50%}.tag.is-delete:after{height:50%;width:1px}.tag.is-delete:focus,.tag.is-delete:hover{background-color:#e8e8e8}.tag.is-delete:active{background-color:#dbdbdb}.tag.is-rounded{border-radius:290486px}
</style>
<script language="javascript">
    var EventUtil = function() {};
    EventUtil.addEventHandler = function(obj, EventType, Handler) {
        if (obj.addEventListener) {
            obj.addEventListener(EventType, Handler, false);
        }
        else if (obj.attachEvent) {
            obj.attachEvent('on' + EventType, Handler);
        } else {
            obj['on' + EventType] = Handler;
        }
    }
    if (document.getElementById("text")) {
        EventUtil.addEventHandler(document.getElementById('text'), 'propertychange', CountChineseCharacters);
        EventUtil.addEventHandler(document.getElementById('text'), 'input', CountChineseCharacters);
    }
    function showit(Word) {
        alert(Word);
    }
    function CountChineseCharacters() {
        Words = document.getElementById('text').value;
        var W = new Object();
        var Result = new Array();
        var iNumwords = 0;
        var sNumwords = 0;
        var sTotal = 0;
        var iTotal = 0;
        var eTotal = 0;
        var otherTotal = 0;
        var bTotal = 0;
        var inum = 0;
      var znum = 0;
      var gl = 0;
      var paichu = 0;
        for (i = 0; i < Words.length; i++) {
            var c = Words.charAt(i);
            if (c.match(/[\u4e00-\u9fa5]/) || c.match(/[\u0800-\u4e00]/) || c.match(/[\uac00-\ud7ff]/)) {
                if (isNaN(W[c])) {
                    iNumwords++;
                    W[c] = 1;
                }
                iTotal++;
            }
        }
        for (i = 0; i < Words.length; i++) {
            var c = Words.charAt(i);
            if (c.match(/[^\x00-\xff]/)) {
                if (isNaN(W[c])) {
                    sNumwords++;
                }
                sTotal++;
            } else {
                eTotal++;
            }
            if (c.match(/[0-9]/)) {
                inum++;
            }
           if (c.match(/[a-zA-Z]/)) {
                znum++;
            }
          if (c.match(/[\s]/)) {
               gl++;
            }
           if (c.match(/[　◕‿↑↓←→↖↗↘↙↔↕。《》、【】“”•‘’❝❞′……—―‐〈〉„╗╚┐└‖〃「」‹›『』〖〗〔〕∶〝〞″≌∽≦≧≒≠≤≥㏒≡≈✓✔◐◑◐◑✕✖★☆₸₹€₴₰₤₳र₨₲₪₵₣₱฿₡₮₭₩₢₧₥₫₦₠₯○㏄㎏㎎㏎㎞㎜㎝㏕㎡‰〒々℃℉ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦㄧㄨㄩ]/)) {
               paichu++;
            }
        }
        document.getElementById('hanzi').innerText = iTotal - paichu;
        document.getElementById('zishu').innerText = inum + iTotal - paichu;
        document.getElementById('biaodian').innerText = sTotal - iTotal + eTotal - inum - znum - gl + paichu;
        document.getElementById('zimu').innerText = znum;
        document.getElementById('shuzi').innerText = inum;
        document.getElementById("zifu").innerHTML = iTotal * 2 + (sTotal - iTotal) * 2 + eTotal;
    }
</script>
<script>
$(document).ready(function(){
$("#wmd-editarea").append('<div class="field is-grouped"><span class="tag">共计：</span><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zishu">0</span> <span class="tag is-primary">个字数</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zifu">0</span> <span class="tag is-primary">个字符</span></div></div><span class="tag">包含：</span><div class="control"><div class="tags has-addons"><span class="tag is-light" id="hanzi">0</span> <span class="tag is-danger">个文字</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="biaodian">0</span> <span class="tag is-info">个符号</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="zimu">0</span> <span class="tag is-success">个字母</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="shuzi">0</span> <span class="tag is-warning">个数字</span></div></div></div>');
CountChineseCharacters();
});
</script>
<?php
    }
}
