#weiphp_addons_ImageManager
本插件为weiphp的图片管理插件适用于weiphp2.0及3.0 注意选择版本
本插件已经过线上测试，但是因环境复杂，不保证所有平台通用。
** 若发现问题还望联系wzhec@foxmail.com告知作者**

个人主页[www.5iymt.com](http://www.5iymt.com)

本插件使用说明：
为了识别微信用户，weiphp上传文件处需要增加token验证。
本人的修复版本3.0已经适配过了。其它版本需自行修改文件
安装说明：
####3.0版本
下载本插件至Plugins目录下，然后安装
####2.0版本
下载本插件至Addons目录下，然后后台安装插件即可。

**注意:**
1.关于显示其它用户图片的问题
	<1>需要给picture增加字段token，sql语句如下（注意替换表名）：
```sql
	ALTER TABLE `wp_picture` ADD COLUMN `token`  varchar(255) NULL AFTER `create_time`;
```
<2>修改上传图片的处理文件 PictureModel.class.php(提供已修改过的pictureModel.class.php，未做过任何修改的友友可以直接覆盖即可)
修改：
```php
	 protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );
```
为：
```php
	 protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('token', 'get_token', self::MODEL_INSERT,'function'),
    );
```

修改109行：
```php
	return $this->field(true)->where($map)->find();
```
为:
```php
	//wzh修改逻辑删除图片后，再次上传会再次显示出来。避免逻辑删除后，图片库不再显示的bug。原来的图片再次上传，可不再占用空间，直接确认归属。
	//有问题联系wzhec@foxmail.com
        $map['token']=$token=get_token();
        $picData=$this->field(true)->where($map)->find();
        if($picData){
            empty($picData['status'])&&($this->where(array('id' =>$picData['id'] ))->setField('status',1));
            if( empty($picData['token']) || $picData['token']=='-1'){
                $this->where(array('id' =>$picData['id'] ))->setField('token',$token);
            }
        }
        return $picData;
```