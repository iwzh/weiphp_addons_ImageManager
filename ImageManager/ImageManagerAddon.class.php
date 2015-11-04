<?php

namespace Addons\ImageManager;
use Common\Controller\Addon;

/**
 * 图片管理插件
 * @author wzh
 */

    class ImageManagerAddon extends Addon{

        public $info = array(
            'name'=>'ImageManager',
            'title'=>'图片管理',
            'description'=>'图片管理，快速选择已上传图片到封面',
            'status'=>1,
            'author'=>'wzh',
            'version'=>'1.0',
            'type'=>0         
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的pageFooter钩子方法
        public function pageFooter(){
            $this->assign("addon_path", $this->addon_path);
            $this->display("widget");
        }
    }