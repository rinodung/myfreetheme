/**
 * Traditional Chinese translation
 * @author Yuwei Chuang <ywchuang.tw@gmail.com>
 * @version 2013-05-07
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.zh_TW = {
		translator : 'Yuwei Chuang &lt;ywchuang.tw@gmail.com&gt;',
		language   : '正體中文',
		direction  : 'ltr',
		dateFormat : 'M d, Y h:i A', // Mar 13, 2012 05:27 PM
		fancyDateFormat : '$1 H:i',
		messages   : {
			
			/********************************** errors **********************************/
			'error'                : '錯誤',
			'errUnknown'           : '未知的錯誤.',
			'errUnknownCmd'        : '未知的指令.',
			'errJqui'              : '無效的 jQuery UI 設定. 必須包含 Selectable, draggable 以及 droppable 元件.',
			'errNode'              : 'elFinder 需要能建立 DOM 元素.',
			'errURL'               : '無效的 elFinder 設定! 尚未設定 URL 選項.',
			'errAccess'            : '拒絕存取.',
			'errConnect'           : '無法連線至後端.',
			'errAbort'             : '連線中斷.',
			'errTimeout'           : '連線逾時.',
			'errNotFound'          : '後端不存在.',
			'errResponse'          : '無效的後端回復.',
			'errConf'              : '無效的後端設定.',
			'errJSON'              : '未安裝 PHP JSON 模組.',
			'errNoVolumes'         : '無可讀取的 volumes.',
			'errCmdParams'         : '無效的參數, 指令: "$1".',
			'errDataNotJSON'       : '資料不是 JSON 格式.',
			'errDataEmpty'         : '沒有資料.',
			'errCmdReq'            : '後端請求需要命令名稱.',
			'errOpen'              : '無法打開 "$1".',
			'errNotFolder'         : '非資料夾.',
			'errNotFile'           : '非檔案.',
			'errRead'              : '無法讀取 "$1".',
			'errWrite'             : '無法寫入 "$1".',
			'errPerm'              : '無權限.',
			'errLocked'            : '"$1" 被鎖定,不能重新命名, 移動或删除.',
			'errExists'            : '檔案 "$1" 已經存在了.',
			'errInvName'           : '無效的檔案名稱.',
			'errFolderNotFound'    : '未找到資料夾.',
			'errFileNotFound'      : '未找到檔案.',
			'errTrgFolderNotFound' : '未找到目標資料夾 "$1".',
			'errPopup'             : '連覽器攔截了彈跳視窗. 請在瀏覽器選項允許彈跳視窗.',
			'errMkdir'             : '不能建立資料夾 "$1".',
			'errMkfile'            : '不能建立檔案 "$1".',
			'errRename'            : '不能重新命名 "$1".',
			'errCopyFrom'          : '不允許從 volume "$1" 複製.',
			'errCopyTo'            : '不允複製到 volume "$1".',
			'errUpload'            : '上船錯誤.',
			'errUploadFile'        : '無法上傳 "$1".',
			'errUploadNoFiles'     : '未找到要上傳的檔案.',
			'errUploadTotalSize'   : '資料超過了最大允許大小.',
			'errUploadFileSize'    : '檔案超過了最大允許大小.',
			'errUploadMime'        : '不允許的檔案類型.',
			'errUploadTransfer'    : '"$1" 傳輸錯誤.', 
			'errNotReplace'        : '"$1" 已經存在此位置, 不能被其他的替换.', // new
			'errReplace'           : '無法替换 "$1".',
			'errSave'              : '無法保存 "$1".',
			'errCopy'              : '無法複製 "$1".',
			'errMove'              : '無法移動 "$1".',
			'errCopyInItself'      : '無法移動 "$1" 到原有位置.',
			'errRm'                : '無法删除 "$1".',
			'errRmSrc'             : '無法删除來源檔案.',
			'errExtract'           : '無法從 "$1" 解壓縮檔案.',
			'errArchive'           : '無法建立壓縮膽案.',
			'errArcType'           : '不支援的壓縮格式.',
			'errNoArchive'         : '檔案不是壓縮檔案, 或者不支援該壓缩格式.',
			'errCmdNoSupport'      : '後端不支援該指令.',
			'errReplByChild'       : '資料夾 “$1” 不能被它所包含的檔案(資料夾)替换.',
			'errArcSymlinks'       : '出于安全上的考量，禁止解壓縮檔案包含不允許的檔案名稱.',
			'errArcMaxSize'        : '壓縮檔案超過最大允許檔案大小範圍.',
			'errResize'            : '無法重新調整大小 "$1".',
			'errUsupportType'      : '不支援的檔案格式.',
			'errNotUTF8Content'    : '檔案 "$1" 不是 UTF-8 格式, 不能編輯.',  // added 9.11.2011
			'errNetMount'          : '無法掛載 "$1".', // added 17.04.2012
			'errNetMountNoDriver'  : '不支援該通訊協議.',     // added 17.04.2012
			'errNetMountFailed'    : '掛載失敗.',         // added 17.04.2012
			'errNetMountHostReq'   : '需要指定主機位置.', // added 18.04.2012
			/******************************* commands names ********************************/
			'cmdarchive'   : '建立壓縮檔案',
			'cmdback'      : '後退',
			'cmdcopy'      : '複製',
			'cmdcut'       : '剪下',
			'cmddownload'  : '下載',
			'cmdduplicate' : '建立副本',
			'cmdedit'      : '編輯檔案',
			'cmdextract'   : '從壓縮檔案解壓縮',
			'cmdforward'   : '前進',
			'cmdgetfile'   : '選擇檔案',
			'cmdhelp'      : '關於本軟體',
			'cmdhome'      : '首頁',
			'cmdinfo'      : '查看關於',
			'cmdmkdir'     : '建立資料夾',
			'cmdmkfile'    : '建立文字檔案',
			'cmdopen'      : '打開',
			'cmdpaste'     : '貼上',
			'cmdquicklook' : '預覽',
			'cmdreload'    : '更新',
			'cmdrename'    : '重新命名',
			'cmdrm'        : '删除',
			'cmdsearch'    : '搜尋檔案',
			'cmdup'        : '移到上一層資料夾',
			'cmdupload'    : '上傳檔案',
			'cmdview'      : '查看',
			'cmdresize'    : '重新調整大小',
			'cmdsort'      : '排序',
			'cmdnetmount'  : '掛載 net volume', // added 18.04.2012
			
			/*********************************** buttons ***********************************/ 
			'btnClose'  : '關閉',
			'btnSave'   : '儲存',
			'btnRm'     : '删除',
			'btnApply'  : '使用',
			'btnCancel' : '取消',
			'btnNo'     : '否',
			'btnYes'    : '是',
			'btnMount'  : '掛載',  // added 18.04.2012
			/******************************** notifications ********************************/
			'ntfopen'     : '打開資料夾',
			'ntffile'     : '打開檔案',
			'ntfreload'   : '更新資料夾内容',
			'ntfmkdir'    : '建立資料夾',
			'ntfmkfile'   : '建立檔案',
			'ntfrm'       : '删除檔案',
			'ntfcopy'     : '複製檔案',
			'ntfmove'     : '移動檔案',
			'ntfprepare'  : '準備複製檔案',
			'ntfrename'   : '重新命名檔案',
			'ntfupload'   : '上傳檔案',
			'ntfdownload' : '下載檔案',
			'ntfsave'     : '儲存檔案',
			'ntfarchive'  : '建立壓縮檔案',
			'ntfextract'  : '從壓縮檔案解壓縮',
			'ntfsearch'   : '搜尋檔案',
			'ntfresize'   : '正在更改尺寸',
			'ntfsmth'     : '正在忙 >_<',
			'ntfloadimg'  : '正在讀取圖片',
      		'ntfnetmount' : '正在掛載 net volume', // added 18.04.2012
			
			/************************************ dates **********************************/
			'dateUnknown' : '未知',
			'Today'       : '今天',
			'Yesterday'   : '昨天',
			'Jan'         : '一月',
			'Feb'         : '二月',
			'Mar'         : '三月',
			'Apr'         : '四月',
			'May'         : '五月',
			'Jun'         : '六月',
			'Jul'         : '七月',
			'Aug'         : '八月',
			'Sep'         : '九月',
			'Oct'         : '十月',
			'Nov'         : '十一月',
			'Dec'         : '十二月',
			'January'     : '一月',
			'February'    : '二月',
			'March'       : '三月',
			'April'       : '四月',
			'May'         : '五月',
			'June'        : '六月',
			'July'        : '七月',
			'August'      : '八月',
			'September'   : '九月',
			'October'     : '十月',
			'November'    : '十一月',
			'December'    : '十二月',
			'Sunday'      : '星期日',
			'Monday'      : '星期一',
			'Tuesday'     : '星期二',
			'Wednesday'   : '星期三',
			'Thursday'    : '星期四',
			'Friday'      : '星期五',
			'Saturday'    : '星期六',
			'Sun'         : '周日', 
			'Mon'         : '周一', 
			'Tue'         : '周二', 
			'Wed'         : '周三', 
			'Thu'         : '周四', 
			'Fri'         : '周五', 
			'Sat'         : '周六',
			/******************************** sort variants ********************************/
			'sortnameDirsFirst' : '按名稱 (資料夾在最前)', 
			'sortkindDirsFirst' : '按類型 (資料夾在最前)', 
			'sortsizeDirsFirst' : '按大小 (資料夾在最前)', 
			'sortdateDirsFirst' : '按日期 (資料夾在最前)', 
			'sortname'          : '按名稱', 
			'sortkind'          : '按類型', 
			'sortsize'          : '按大小',
			'sortdate'          : '按日期',

			/********************************** messages **********************************/
			'confirmReq'      : '請確認',
			'confirmRm'       : '確定要删除檔案嗎?<br/>該操作不可回復!',
			'confirmRepl'     : '用新的檔案替换原有檔案?',
			'apllyAll'        : '全部使用',
			'name'            : '名稱',
			'size'            : '大小',
			'perms'           : '權限',
			'modify'          : '修改于',
			'kind'            : '類別',
			'read'            : '讀取',
			'write'           : '寫入',
			'noaccess'        : '無權限',
			'and'             : '和',
			'unknown'         : '未知',
			'selectall'       : '選擇所有檔案',
			'selectfiles'     : '選擇檔案',
			'selectffile'     : '選擇第一個檔案',
			'selectlfile'     : '選擇最後一個檔案',
			'viewlist'        : '列表檢視',
			'viewicons'       : '圖示檢視',
			'places'          : '位置',
			'calc'            : '計算', 
			'path'            : '路徑',
			'aliasfor'        : '别名',
			'locked'          : '鎖定',
			'dim'             : '尺寸',
			'files'           : '檔案',
			'folders'         : '資料夾',
			'items'           : '項目',
			'yes'             : '是',
			'no'              : '否',
			'link'            : '連結',
			'searcresult'     : '搜尋结果',  
			'selected'        : '選取的項目',
			'about'           : '關於',
			'shortcuts'       : '快捷鍵',
			'help'            : '幫助',
			'webfm'           : '網路檔案總管',
			'ver'             : '版本',
			'protocolver'     : '協定版本',
			'homepage'        : '首頁',
			'docs'            : '文件',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Follow us on twitter',
			'facebook'        : 'Join us on facebook',
			'team'            : '團隊',
			'chiefdev'        : '首席開發者',
			'developer'       : '開發者',
			'contributor'     : '貢獻者',
			'maintainer'      : '維護者',
			'translator'      : '翻譯',
			'icons'           : '圖示',
			'dontforget'      : '别忘了帶上你擦汗的毛巾',
			'shortcutsof'     : '快捷鍵已禁用',
			'dropFiles'       : '把檔案拖到此處',
			'or'              : '或者',
			'selectForUpload' : '選擇要上傳的檔案',
			'moveFiles'       : '移動檔案',
			'copyFiles'       : '複製檔案',
			'rmFromPlaces'    : '從位置中删除',
			'untitled folder' : '未命名資料夾',
			'untitled file.txt' : '未命名檔案.txt',
			'aspectRatio'     : '保持比例',
			'scale'           : '寬高比',
			'width'           : '寬',
			'height'          : '高',
			'mode'            : '模式',
			'resize'          : '重新調整大小',
			'crop'            : '裁切',
			'rotate'          : '旋轉',
			'rotate-cw'       : '順時針旋轉90度',
			'rotate-ccw'      : '逆時針旋轉90度',
			'degree'          : '度',
			'port'            : '接口', // added 18.04.2012
			'user'            : '使用者', // added 18.04.2012
			'pass'            : '密碼', // added 18.04.2012
			
			/********************************** mimetypes **********************************/
			'kindUnknown'     : '未知',
			'kindFolder'      : '資料夾',
			'kindAlias'       : '别名',
			'kindAliasBroken' : '錯誤的别名',
			// applications
			'kindApp'         : '應用程式',
			'kindPostscript'  : 'Postscript 文件',
			'kindMsOffice'    : 'Microsoft Office 文件',
			'kindMsWord'      : 'Microsoft Word 文件',
			'kindMsExcel'     : 'Microsoft Excel 文件',
			'kindMsPP'        : 'Microsoft Powerpoint 簡報',
			'kindOO'          : 'Open Office 文件',
			'kindAppFlash'    : 'Flash 應用程式',
			'kindPDF'         : 'Portable Document Format (PDF)',
			'kindTorrent'     : 'Bittorrent 檔案',
			'kind7z'          : '7z 壓縮檔案',
			'kindTAR'         : 'TAR 壓縮檔案',
			'kindGZIP'        : 'GZIP 壓縮檔案',
			'kindBZIP'        : 'BZIP 壓縮檔案',
			'kindZIP'         : 'ZIP 壓縮檔案',
			'kindRAR'         : 'RAR 壓縮檔案',
			'kindJAR'         : 'Java JAR 檔案',
			'kindTTF'         : 'True Type 字體',
			'kindOTF'         : 'Open Type 字體',
			'kindRPM'         : 'RPM 封裝',
			// texts
			'kindText'        : '文字檔案',
			'kindTextPlain'   : '純文字',
			'kindPHP'         : 'PHP 程式碼',
			'kindCSS'         : 'CSS',
			'kindHTML'        : 'HTML 文件',
			'kindJS'          : 'Javascript 程式碼',
			'kindRTF'         : '富文字格式(RTF)',
			'kindC'           : 'C 程式碼',
			'kindCHeader'     : 'C 標頭檔',
			'kindCPP'         : 'C++ 程式碼',
			'kindCPPHeader'   : 'C++ 標頭檔',
			'kindShell'       : 'Unix Shell 脚本',
			'kindPython'      : 'Python 程式碼',
			'kindJava'        : 'Java 程式碼',
			'kindRuby'        : 'Ruby 程式碼',
			'kindPerl'        : 'Perl 程式碼',
			'kindSQL'         : 'SQL 脚本',
			'kindXML'         : 'XML 文件',
			'kindAWK'         : 'AWK 程式碼',
			'kindCSV'         : '逗號分隔值檔案(CSV)',
			'kindDOCBOOK'     : 'Docbook XML 文件',
			// images
			'kindImage'       : '圖片',
			'kindBMP'         : 'BMP 圖片',
			'kindJPEG'        : 'JPEG 圖片',
			'kindGIF'         : 'GIF 圖片',
			'kindPNG'         : 'PNG 圖片',
			'kindTIFF'        : 'TIFF 圖片',
			'kindTGA'         : 'TGA 圖片',
			'kindPSD'         : 'Adobe Photoshop 圖片',
			'kindXBITMAP'     : 'X bitmap 圖片',
			'kindPXM'         : 'Pixelmator 圖片',
			// media
			'kindAudio'       : '聲音',
			'kindAudioMPEG'   : 'MPEG 聲音',
			'kindAudioMPEG4'  : 'MPEG-4 聲音',
			'kindAudioMIDI'   : 'MIDI 聲音',
			'kindAudioOGG'    : 'Ogg Vorbis 聲音',
			'kindAudioWAV'    : 'WAV 聲音',
			'AudioPlaylist'   : 'MP3 播放列表',
			'kindVideo'       : '影片',
			'kindVideoDV'     : 'DV 影片',
			'kindVideoMPEG'   : 'MPEG 影片',
			'kindVideoMPEG4'  : 'MPEG-4 影片',
			'kindVideoAVI'    : 'AVI 影片',
			'kindVideoMOV'    : 'Quick Time 影片',
			'kindVideoWM'     : 'Windows Media 影片',
			'kindVideoFlash'  : 'Flash 影片',
			'kindVideoMKV'    : 'Matroska 影片',
			'kindVideoOGG'    : 'Ogg 影片'
		}
	}
}
