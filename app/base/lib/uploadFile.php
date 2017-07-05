<?php 
// 说明：图片上传类 
// 作者：upall 
// 日期：23:22 2010/05/05 周三 
class uploadFile{ 
    public $thumbWidth = 160; // 缩略图宽度 
    public $thumbHeight = 120; // 缩略图高度 
    public $autoThumb = TRUE; // 是否自动生成缩略图 
    public $error = ''; // 错误信息 
    public $imgPath = ''; // 上传成功后的图片位置 
    public $thumbPath = ''; // 上传成功后的缩略图位置 
	public $allowpictype = array('1'=>'gif','2'=>'jpg','3'=>'png','6'=>'bmp');// 允许上传文件类型
	public $maxsize = '1024000';//单位kb
     
    // 说明：初始化，创建存放目录 
    function __construct($public_dir='/public',$uploadFolder = '/pic', $thumbFolder = '/thumb'){
        $this->uploadFolder = $uploadFolder.'/'.date('Ymd'); 
        $this->thumbFolder = $thumbFolder.'/'.date('Ymd');
        $this->public_dir = $public_dir;
        $this->_mkdir(); 
    }
     
    // 说明：上传图片，参数是<input />的name属性值；成功返回图片的相对URL，失败返回FALSE和错误信息（在$this->error里） 
    // bool/sting upload(string $html_tags_input_attrib_name); 
    function upload($files, $thumbWidth = 160, $thumbHeight = 160) { 
        $this->thumbWidth = $thumbWidth;
        $this->thumbHeight = $thumbHeight;
		$_FILES["name"] = $files['name'];
		$_FILES["tmp_name"] = $files['tmp_name'];
		$_FILES["size"] = $files['size'];
		$_FILES["type"] = $files['type'];
		$_FILES["error"] = $files['error'];
        if ($this->error){ // 如果有错，直接返回（例如_mkdir） 
            return FALSE; 
        } 
        if(!$_FILES["name"]){ 
            $this->error = ' 没有上传图片'; 
            return FALSE;
        } 
		// 判断上传文件类型
		list($width, $height, $type, $attr) = getimagesize($_FILES["tmp_name"]);
		if ($width <= 0 || $height <= 0 || !array_key_exists($type,$this->allowpictype)){
			$this->error = '只能上传' .implode(',', $this->allowpictype). '类型的图片';
			return false;
		}
		// 文件大小
		if($_FILES["size"] > $this->maxsize){ 
            $this->error = ' 上传图片不能超过' . $this->maxsize/1024 . 'KB'; 
            return FALSE;
        } 
        if($_FILES["name"]){ 
            $isUpFile = $_FILES['tmp_name']; 
            if (is_uploaded_file($isUpFile)){ 
                $imgInfo = $this->_getinfo($isUpFile); 
                if (FALSE == $imgInfo){ 
                    return FALSE; 
                } 
                $extName = $imgInfo['type']; 
                $microSenond = floor(microtime()*10000); // 取一个毫秒级数字,4位。 
                $newFileName = '/'.date('YmdHis').$microSenond . '.' . $extName ; // 所上传图片的新名字。 
                $location = $this->public_dir.$this->uploadFolder . $newFileName; 
                $result = move_uploaded_file($isUpFile, $location); 
                if ($result){
                    if (TRUE == $this->autoThumb){ // 是否生成缩略图 
                        $thumb = $this->thumb($location, $this->thumbWidth, $this->thumbHeight); 
                        if (FALSE == $thumb){ 
                            return FALSE; 
                        } 
                    } 
                    $this->imgPath = $location;
                    $this->pic_name = substr($this->uploadFolder . $newFileName,1);
                    return $location; 
                }else{ 
                    $this->error = ' 移动临时文件时出错'; 
                    return FALSE; 
                } 
            }else{ 
                $uploadError = $_FILES['error']; 
                if (1 == $uploadError) { // 文件大小超过了php.ini中的upload_max_filesize 
                    $this->error = ' 文件太大，服务器拒绝接收大于' . ini_get('upload_max_filesize') . '的文件'; 
                    return FALSE; 
                }elseif (3 == $uploadError) { // 上传了部分文件 
                    $this->error = '上传中断，请重试'; 
                    return FALSE; 
                }elseif (4 == $uploadError){ 
                    $this->error = ' 没有文件被上传'; 
                    return FALSE; 
                }elseif (6 == $uploadError){ 
                    $this->error = ' 找不到临时文件夹，请联系您的服务器管理员'; 
                    return FALSE; 
                }elseif (7 == $uploadError){ 
                    $this->error = ' 文件写入失败，请联系您的服务器管理员'; 
                    return FALSE; 
                }else{ 
                    if (0 != $uploadError){ 
                        $this->error = ' 未知上传错误，请联系您的服务器管理员'; 
                        return FALSE; 
                    } 
                } // end if $uploadError 
            } // end if is_uploaded_file else 
        } // end if $_FILES["name"] 
    } 
     
    // 说明：获取图片信息，参数是上传后的临时文件，成功返回数组，失败返回FALSE和错误信息 
    // array/bool _getinfo(string $upload_tmp_file) 
    public function _getinfo($img){ 
        if (!file_exists($img)){ 
            $this->error = ' 找不到图片，无法获取其信息'; 
            return FALSE; 
        } 
        $tempFile = @fopen($img, "rb"); 
        $bin = @fread($tempFile, 2); // 只读2字节   
        @fclose($tempFile); 
        $strInfo = @unpack("C2chars", $bin); 
        $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']); 
        $fileType = ''; 
        switch ($typeCode){ // 6677:bmp 255216:jpg 7173:gif 13780:png 7790:exe 8297:rar 8075:zip tar:109121 7z:55122 gz 31139 
            case '255216': 
                $fileType = 'jpg'; 
                break; 
            case '7173': 
                $fileType = 'gif'; 
                break; 
            case '13780': 
                $fileType = 'png'; 
                break; 
            default: 
                $fileType = 'unknown'; 
        } 
        if ($fileType == 'jpg' || $fileType == 'gif' || $fileType == 'png'){ 
            $imageInfo = getimagesize($img); 
            $imgInfo['size'] = $imageInfo['bits']; 
            $imgInfo["type"] = $fileType; 
            $imgInfo["width"] = $imageInfo[0]; 
            $imgInfo["height"] = $imageInfo[1]; 
            return $imgInfo; 
        }else{ // 非图片类文件信息 
            $this->error = '图片类型错误'; 
            return FALSE; 
        } 
    } // end _getinfo 
     
    // 说明：生成缩略图，等比例缩放或拉伸 
    // bool/string thumb(string $uploaded_file, int $thumbWidth, int $thumbHeight, string $thumbTail); 
    function thumb($img, $thumbWidth = 300, $thumbHeight = 200, $thumbTail = '_thumb'){ 
        $filename = $img; // 保留一个名字供新的缩略图名字使用 
        $imgInfo = $this->_getinfo($img); 
        if (FALSE == $imgInfo){ 
            return FALSE; 
        }  
        $imgType = $imgInfo['type']; 
        switch ($imgType) { // 创建一个图，并给出扩展名 
            case "jpg" : 
                $img = imagecreatefromjpeg($img); 
                $extName = 'jpg'; 
                break; 
            case 'gif' : 
                $img = imagecreatefromgif($img); 
                $extName = 'gif'; 
                break; 
            case 'png' : 
                $img = imagecreatefrompng($img); 
                $extName = 'png'; 
                break; 
            default : // 如果类型错误，生成一张空白图 
                $img = imagecreate($thumbWidth,$thumbHeight); 
                imagecolorallocate($img,0x00,0x00,0x00); 
                $extName = 'jpg'; 
        } 
        // 缩放后的图片尺寸(小则拉伸，大就缩放) 
        $imgWidth = $imgInfo['width']; 
        $imgHeight = $imgInfo['height']; 
        if ($imgHeight > $imgWidth) { // 竖图 
            $newHeight = $thumbHeight; 
            $newWidth = ceil($imgWidth / ($imgHeight / $thumbHeight )); 
        }else if($imgHeight < $imgWidth) { // 横图 
            $newHeight = ceil($imgHeight / ($imgWidth / $thumbWidth )); 
            $newWidth = $thumbWidth; 
        }else if($imgHeight == $imgWidth) { // 等比例图 
            $newHeight = $thumbWidth; 
            $newWidth = $thumbWidth; 
        } 
        $bgimg = imagecreatetruecolor($newWidth,$newHeight); 
        $bg = imagecolorallocate($bgimg,0x00,0x00,0x00); 
        imagefill($bgimg,0,0,$bg); 
        $sampled = imagecopyresampled($bgimg,$img,0,0,0,0,$newWidth,$newHeight,$imgWidth,$imgHeight); 
        if(!$sampled ){ 
            $this->error = ' 缩略图生成失败'; 
            @unlink($filename); // 删除上传的图片 
            return FALSE; 
        } 
        $filename = basename($filename);

        $newFileName = substr($filename, 0, strrpos($filename, ".")) .'-'.$thumbWidth.'-'.$thumbHeight. $thumbTail . '.' . $extName ; // 新名字 
        $thumbPath = $this->public_dir . $this->thumbFolder . '/' . $newFileName; 
        switch ($extName){ 
            case 'jpg': 
                $result = imagejpeg($bgimg, $thumbPath); 
                break; 
            case 'gif': 
                $result = imagegif($bgimg, $thumbPath); 
                break; 
            case 'png': 
                $result = imagepng($bgimg, $thumbPath); 
                break; 
            default: // 上边判断类型出错时会创建一张空白图，并给出扩展名为jpg 
                $result = imagejpeg($bgimg, $thumbPath); 
        } 
        if ($result){ 
            $this->thumbPath = $thumbPath;
            $this->thumb_name = substr($this->thumbFolder . '/' . $newFileName,1);
            return $thumbPath; 
        }else{ 
            $this->error = ' 缩略图创建失败'; 
            @unlink($this->uploadFolder . '/' . $filename); // 删除上传的图片 
            return FALSE; 
        } 
    } // end thumb 
     
     // 说明：创建图片的存放目录 
    public function _mkdir(){ // 创建图片上传目录和缩略图目录 
        if(!is_dir($this->public_dir.$this->uploadFolder)){ 
            $mkdirResutlt = __mkdirs($this->public_dir.$this->uploadFolder); 
            if (!$mkdirResutlt){ 
                $this->error = ' 存放图片的目录创建失败'; 
                return FALSE; 
            } 
        } 
        if(!is_dir($this->public_dir.$this->thumbFolder) && TRUE == $this->autoThumb){ 
            $mkdirResutlt = __mkdirs($this->public_dir.$this->thumbFolder); 
            if (!$mkdirResutlt){ 
                $this->error = ' 存放缩略图的目录创建失败'; 
                return FALSE; 
            } 
        } 
    } 
} 