<?php

namespace app\common\logic;

/**
 * @title 文件上传公共类
 * @description 接口说明:文件上传公共类,
 */
class Upload
{
	private $fileSave;
	public function __construct($fileSave = "")
	{
		$this->fileSave = $fileSave && is_string($fileSave) ? $fileSave : UPLOAD_DEFAULT;
		if (!is_dir($this->fileSave)) {
			mkdir($this->fileSave);
		}
		if (!is_writable($this->fileSave)) {
			chmod($this->fileSave, 493);
		}
	}
	/**
	 * 单文件上传
	 * @param $file :文件
	 * @param $type :文件验证类型
	 * @param $is_file :是否是文件
	 * @param $origin :是否使用源文件名
	 * @param $split :文件名分隔符
	 * @return
	 * @author wyh
	 * @time 2020/04/03
	 */
	public function uploadHandle($file, $is_file = false, $origin = true, $split = "^")
	{
		$re = [];
		if (is_array($file)) {
			return false;
		}
		if ($is_file) {
			$type = "file";
			$data = ["file" => $file];
		} else {
			$type = "image";
			$data = ["image" => $file];
		}
		if ($is_file) {
			$validate = new \app\admin\validate\EmailTemplateValidate();
			if (!$validate->scene("upload")->check($data)) {
				$re["status"] = 400;
				$re["msg"] = $validate->getError();
				return $re;
			}
		} else {
			$validate = new \app\common\validate\UploadValidate();
			if (!$validate->scene($type)->check($data)) {
				$re["status"] = 400;
				$re["msg"] = $validate->getError();
				if ($re["msg"] === "image不是有效的图像文件") {
					$re["msg"] = "不支持的附件格式";
				}
				return $re;
			}
		}
		$uploadPath = $file->getRealPath();
		$uploadMime = $file->getMime();
		$originalName = $file->getInfo("name");
		if (!self::isUploadContentSafe($uploadPath, $uploadMime, $is_file, $originalName)) {
			$re["status"] = 400;
			$re["msg"] = "不支持的附件内容";
			return $re;
		}
		if ($origin) {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time() . $split . $originalName);
		} else {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time());
		}
		if ($info) {
			$savename = $info->getSaveName();
			$re["status"] = 200;
			$re["savename"] = $savename;
			$re["origin_name"] = $originalName;
		} else {
			$re["status"] = 400;
			$re["msg"] = $file->getError();
		}
		return $re;
	}
	public static function isUploadContentSafe($path, $mime, $is_file, $originalName = "")
	{
		if (!is_string($path) || !is_file($path) || !is_readable($path)) {
			return false;
		}
		if ($originalName !== "" && !self::isUploadNameSafe($originalName)) {
			return false;
		}
		$reportedMime = strtolower(trim((string) $mime));
		$detectedMime = self::detectMime($path);
		$blockedMimes = [
			"text/html",
			"application/xhtml+xml",
			"application/x-httpd-php",
			"application/x-php",
			"text/x-php",
			"text/x-shellscript",
			"application/x-executable",
		];
		if (in_array($reportedMime, $blockedMimes, true) || in_array($detectedMime, $blockedMimes, true)) {
			return false;
		}
		$imageInfo = @getimagesize($path);
		$isImage = is_array($imageInfo) && isset($imageInfo[2]) && in_array($imageInfo[2], [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true);
		if (!$is_file && !$isImage) {
			return false;
		}
		if ($originalName !== "") {
			$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
			$imageExtensions = ["gif", "jpg", "jpeg", "png"];
			if ($isImage !== in_array($extension, $imageExtensions, true)) {
				return false;
			}
			if ($isImage && !self::imageExtensionMatchesType($extension, $imageInfo[2])) {
				return false;
			}
		}
		return true;
	}
	private static function isUploadNameSafe($name)
	{
		if (!is_string($name) || $name === "" || strpos($name, "\0") !== false || basename($name) !== $name || strpos($name, "/") !== false || strpos($name, "\\") !== false) {
			return false;
		}
		$lowerName = strtolower($name);
		if ($lowerName === ".htaccess" || $lowerName === ".user.ini") {
			return false;
		}
		return !preg_match('/\.(?:php\d*|phtml?|pht|phar|inc|asp|aspx|asa|cer|jsp|jspx|jsw|jsv|cfm|cfc|cgi|pl|py|sh|bash|zsh|exe|dll|com|bat|cmd|msi)(?:\.|$)/i', $name);
	}
	private static function detectMime($path)
	{
		if (!function_exists("finfo_open")) {
			return "";
		}
		$finfo = @finfo_open(FILEINFO_MIME_TYPE);
		if ($finfo === false) {
			return "";
		}
		$mime = @finfo_file($finfo, $path);
		finfo_close($finfo);
		return strtolower(trim((string) $mime));
	}
	private static function imageExtensionMatchesType($extension, $type)
	{
		if ($type === IMAGETYPE_GIF) {
			return $extension === "gif";
		}
		if ($type === IMAGETYPE_JPEG) {
			return in_array($extension, ["jpg", "jpeg"], true);
		}
		return $type === IMAGETYPE_PNG && $extension === "png";
	}
	/**
	 * 单文件上传
	 * @param $file :文件
	 * @param $type :文件验证类型
	 * @param $is_file :是否是文件
	 * @param $origin :是否使用源文件名
	 * @param $split :文件名分隔符
	 * @return
	 * @author wyh
	 * @time 2020/04/03
	 */
	public function uploadHandles1($file, $is_file = false, $origin = true, $split = "^")
	{
		$re = [];
		if (is_array($file)) {
			return false;
		}
		if ($is_file) {
			$type = "file";
			$data = ["file" => $file];
		} else {
			$type = "image";
			$data = ["image" => $file];
		}
		if ($is_file) {
			$validate = ["size" => 52428800];
			$info = $file->validate($validate);
			if (!$info) {
				$result["status"] = 406;
				$result["msg"] = $file->getError();
				return $result;
			}
		} else {
			$validate = new \app\common\validate\UploadValidate();
			if (!$validate->scene($type)->check($data)) {
				$re["status"] = 400;
				$re["msg"] = $validate->getError();
				if ($re["msg"] === "image不是有效的图像文件") {
					$re["msg"] = "不支持的附件格式";
				}
				return $re;
			}
		}
		$originalName = $file->getInfo("name");
		if (!self::isUploadContentSafe($file->getRealPath(), $file->getMime(), $is_file, $originalName)) {
			return ["status" => 400, "msg" => "不支持的附件内容"];
		}
		if ($origin) {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time() . $split . $originalName);
		} else {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time());
		}
		if ($info) {
			$savename = $info->getSaveName();
			$re["status"] = 200;
			$re["savename"] = $savename;
			$re["origin_name"] = $originalName;
		} else {
			$re["status"] = 400;
			$re["msg"] = $file->getError();
		}
		return $re;
	}
	/**
	 * 单文件上传
	 * @param $file :文件
	 * @param $type :文件验证类型
	 * @param $is_file :是否是文件
	 * @param $origin :是否使用源文件名
	 * @param $split :文件名分隔符
	 * @return
	 * @author wyh
	 * @time 2020/04/03
	 */
	public function uploadHandles($file, $is_file = false, $origin = true, $split = "^")
	{
		$re = [];
		if (is_array($file)) {
			return false;
		}
		if ($is_file) {
			$type = "file";
			$data = ["file" => $file];
		} else {
			$type = "image";
			$data = ["image" => $file];
		}
		if ($is_file) {
			$validate = ["size" => 52428800, "ext" => "rar,zip,png,jpg,jpeg,gif,doc,docx,key,number,pages,pdf,ppt,pptx,txt,rtf,vcf,xls,xlsx"];
			$info = $file->validate($validate);
			if (!$info) {
				$result["status"] = 406;
				$result["msg"] = $file->getError();
				return $result;
			}
		} else {
			$validate = new \app\common\validate\UploadValidate();
			if (!$validate->scene($type)->check($data)) {
				$re["status"] = 400;
				$re["msg"] = $validate->getError();
				if ($re["msg"] === "image不是有效的图像文件") {
					$re["msg"] = "不支持的附件格式";
				}
				return $re;
			}
		}
		$originalName = $file->getInfo("name");
		if (!self::isUploadContentSafe($file->getRealPath(), $file->getMime(), $is_file, $originalName)) {
			return ["status" => 400, "msg" => "不支持的附件内容"];
		}
		if ($origin) {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time() . $split . $originalName);
		} else {
			$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time());
		}
		if ($info) {
			$savename = $info->getSaveName();
			$re["status"] = 200;
			$re["savename"] = $savename;
			$re["origin_name"] = $originalName;
		} else {
			$re["status"] = 400;
			$re["msg"] = $file->getError();
		}
		return $re;
	}
	/**
	 * 多文件上传
	 * @param $file :文件
	 * @param $type :文件验证类型
	 * @param $origin :是否使用源文件名
	 * @param $split :文件名分隔符
	 * @return
	 * @author wyh
	 * @time 2020/04/03
	 */
	public function uploadMultiHandle($files, $origin = true, $split = "^")
	{
		$re = [];
		if (!is_array($files)) {
			return false;
		}
		foreach ($files as $file) {
			$data = ["file" => $file];
			$validate = new \app\common\validate\UploadValidate();
			if (!$validate->scene("file")->check($data)) {
				$re["status"] = 400;
				$re["msg"] = $validate->getError();
				if (!empty($re["savename"])) {
					$addresses = explode(",", $re["savename"]);
					foreach ($addresses as $address) {
						$path = $this->fileSave . $address;
						if (file_exists($path)) {
							unset($info);
							@unlink($path);
							unset($re["savename"]);
						}
					}
				}
				return $re;
			}
			$originalName = $file->getInfo("name");
			if (!self::isUploadContentSafe($file->getRealPath(), $file->getMime(), true, $originalName)) {
				self::deleteSavedFiles($this->fileSave, isset($re["savename"]) ? $re["savename"] : "");
				return ["status" => 400, "msg" => "不支持的附件内容"];
			}
			if ($origin) {
				$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time() . $split . $originalName);
			} else {
				$info = $file->rule("uniqid")->move($this->fileSave, md5(uniqid()) . time());
			}
			if ($info) {
				if (!isset($savename)) {
					$savename = $info->getSaveName();
				} else {
					$savename = $savename . "," . $info->getSaveName();
				}
				$re["status"] = 200;
				$re["savename"] = $savename;
			} else {
				$re["status"] = 400;
				$re["msg"] = $file->getError();
				self::deleteSavedFiles($this->fileSave, isset($re["savename"]) ? $re["savename"] : "");
				unset($re["savename"]);
				return $re;
			}
		}
		return $re;
	}
	private static function deleteSavedFiles($directory, $saveNames)
	{
		foreach (array_filter(explode(",", (string) $saveNames)) as $saveName) {
			$path = rtrim($directory, "/\\") . DIRECTORY_SEPARATOR . $saveName;
			if (is_file($path)) {
				@unlink($path);
			}
		}
	}
	/**
	 * 时间 2020/4/27 15:42
	 * @param string $file - 要移动的文件
	 * @param string $path - 移动地址
	 * @return  array $res- 成功返回提交完整地址， 失败返回erorr地址
	 * @author liyongjun
	 */
	public function moveTo($file, $path)
	{
		if (is_array($file)) {
			$ret = [];
			foreach ($file as $v) {
				$tmp = $this->moveTo($v, $path);
				if (isset($tmp["error"])) {
					return $tmp;
				}
				$ret[] = $tmp;
			}
			return $ret;
		}
		if (!is_string($file)) {
			return ["error" => "文件名无效"];
		}
		$file = htmlspecialchars_decode($file, ENT_QUOTES);
		if ($file === "" || strpos($file, "\0") !== false || strpos($file, "/") !== false || strpos($file, "\\") !== false || basename($file) !== $file || !preg_match('/^[a-f0-9]{32}[0-9]{10,}(?:\^[^\x00\/\\\\]+|\.[A-Za-z0-9]{1,16})?$/u', $file)) {
			return ["error" => "文件名无效"];
		}
		$source_base = realpath(UPLOAD_DEFAULT);
		if ($source_base === false) {
			return ["error" => "临时文件目录不存在"];
		}
		if (!is_dir($path) && !mkdir($path, 0755, true)) {
			return ["error" => "目标目录创建失败"];
		}
		$target_base = realpath($path);
		if ($target_base === false) {
			return ["error" => "目标目录不存在"];
		}
		$newfile = rtrim($target_base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;
		if (is_file($newfile) && !is_link($newfile)) {
			return $file;
		}
		if (file_exists($newfile) || is_link($newfile)) {
			return ["error" => "目标文件异常"];
		}
		$filepath = realpath($source_base . DIRECTORY_SEPARATOR . $file);
		$source_prefix = rtrim($source_base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		if ($filepath === false || !is_file($filepath) || is_link($filepath) || strncmp($filepath, $source_prefix, strlen($source_prefix)) !== 0) {
			return ["error" => "文件不存在"];
		}
		try {
			if (copy($filepath, $newfile)) {
				unlink($filepath);
				return $file;
			}
		} catch (\Exception $e) {
			return ["error" => $e->getMessage()];
		}
		return ["error" => "移动失败"];
	}
}
