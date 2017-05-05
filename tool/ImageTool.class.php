<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

defined("ACC") || exit("暗戳戳的不要访问");
/***
水印 缩略图 验证码类
***/
class ImageTool {
	//分析图片的大小 return 数组
	public static function imageInfo($image) {
		//判断图片是否存在
		if (!file_exists($image)) {
			return false;
		} 
		$info = getimagesize($image);
		//判断是否是图片
		if ($info == false) {
			return false;
		}
		//此时info分析出来，是一个数组
		$img['width'] = $info[0];
		$img['height'] = $info[1];
		$tmp = explode("/", $info['mime']);
		$img['ext'] = $tmp[1];
		//echo $img['ext'];
		return $img;
	}

	//加水印功能 $water水印小图  $dst等操作图片 $save不填则默认替换原始图 $pos 默认右下角2
	public static function water($dst, $water, $save=NULL, $alpha = 50, $pos = 2) {
		//先保证2个文件存在
		if (!file_exists($dst)) {
			echo "目标图片不存在";
			return false;
		}
		if (!file_exists($water)) {
			echo "水印小图片不存在";
			return false;
		}
		//首先保证水印不能比待操作图片还大
		$dstinfo = self::imageInfo($dst);
		$waterinfo = self::imageInfo($water);
		if ($dstinfo['width'] < $waterinfo['width'] || $dstinfo['height'] < $waterinfo['height']) {
			echo "水印图片比待操作图片还要大了";
			return false;
		}
		//两张照片，读到画布上
		$dfun = 'imagecreatefrom'.$dstinfo['ext'];
		$wfun = 'imagecreatefrom'.$waterinfo['ext'];
		if (!function_exists($dfun) || !function_exists($wfun)) {
			echo "图片文件后缀无法识别";
			return false;
		}
		//动态加载函数
		$dstim = $dfun($dst); 
		$waterim = $wfun($water); 
		//根据水印的位置，计算粘贴的坐标
		$posx = 0; $posy = 0;
		switch ($pos) {
			case 0:
				$posx = 0;
				$posy = 0;
				break;
			case 1:
				$posx = $dstinfo['width'] - $waterinfo['width'];
				$posy = 0;
				break;
			case 2:
				$posx = $dstinfo['width'] - $waterinfo['width'];
				$posy = $dstinfo['height'] - $waterinfo['height'];
				break;
			case 3:
				$posx = 0;
				$posy = $dstinfo['height'] - $waterinfo['height'];
				break;
		}
		//加水印
		imagecopymerge($dstim, $waterim, $posx, $posy, 0, 0, $waterinfo['width'], $waterinfo['height'], $alpha);
		echo $posx,$posy;
		//保存图片
		if (!$save) {
			$save = $dst;
			unlink($dst);//删除原图
		}
		$createfunc = 'image'.$dstinfo['ext'];
		$createfunc($dstim,$save);
		//销毁
		imagedestroy($dstim);
		imagedestroy($waterim);
		return true;
	}

	//等比例缩放，两边留白
	public static function thumb($dst, $save, $width=200, $height=200) {
		//首先判断待处理的图片是否存在
		$dinfo = self::imageInfo($dst);
		if ($dinfo == false) {
			return false;
		}
		//计算缩放比例		
		$calc = min($width/$dinfo['width'], $height/$dinfo['height']);
		//创建原始画布
		$dfunc = "imagecreatefrom".$dinfo['ext'];
		$dim = $dfunc($dst);
		//创建缩略画布
		$tim = imagecreatetruecolor($width, $height);
		//创建白色填充缩略图
		$white = imagecolorallocate($tim, 255, 255, 255);
		//填充缩略画布
		imagefill($tim, 0, 0, $white);
		//复制并缩略
		$dwidth = (int)$dinfo['width']*$calc;
		$dheight = (int)$dinfo['height']*$calc;
		$paddingx = (int)($width-$dwidth) / 2;
		$paddingy = (int)($height - $dheight) / 2;
		imagecopyresampled($tim, $dim, $paddingx, $paddingy, 0, 0, $dwidth, $dheight,$dinfo['width'], $dinfo['height']);
		//保存图片
		if (!$save) {
			$save = $dst;
			unlink($dst);//删除原图
		}
		$createfunc = 'image'.$dinfo['ext'];
		$createfunc($tim,$save); 
		imagedestroy($tim);
		imagedestroy($dim);
		return true;
	}

    //写验证码
    /*
        author: dabao
    */
    public static function captcha($width=50,$height=25) {
            //造画布
            $image = imagecreatetruecolor($width,$height) ;
           
            //造背影色
            $gray = imagecolorallocate($image, 200, 200, 200);
           
            //填充背景
            imagefill($image, 0, 0, $gray);
           
            //造随机字体颜色
            $color = imagecolorallocate($image, mt_rand(0, 125), mt_rand(0, 125), mt_rand(0, 125)) ;
            //造随机线条颜色
            $color1 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
            $color2 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
            $color3 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
           
            //在画布上画线
            imageline($image, mt_rand(0, 50), mt_rand(0, 25), mt_rand(0, 50), mt_rand(0, 25), $color1) ;
            imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color2) ;
            imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color3) ;
           
            //在画布上写字
            $text = substr(str_shuffle('ABCDEFGHIJKMNPRSTUVWXYZabcdefghijkmnprstuvwxyz23456789'), 0,4) ;
            imagestring($image, 5, 7, 5, $text, $color) ;
           
            //显示、销毁
            header('content-type: image/jpeg');
            imagejpeg($image);
            imagedestroy($image);
    }
}




?>