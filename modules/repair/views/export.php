<?php
/**
 * @filesource modules/repair/views/export.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Repair\Export;

use Kotchasan\Date;
use Kotchasan\File;
use Kotchasan\Language;
use Kotchasan\Template;

/**
 * พิมพ์รายละเอียดการซ่อม
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{

  /**
   * module=repair-get.
   *
   * @return string
   */
  public function render($index)
  {
    // URL สำหรับดูรายละเอียดการซ่อม
    $url = WEB_URL.'index.php?module=repair-detail&amp;id='.$index->id;
    // QR Code
    $qrcode_file = DATA_FOLDER.'repair/'.$index->id.'/qr.png';
    $filename = ROOT_PATH.$qrcode_file;
    if (!file_exists($filename)) {
      if (File::makeDirectory(ROOT_PATH.DATA_FOLDER.'repair/'.$index->id.'/')) {
        // include qrlib
        require '../../phpqrcode/qrlib.php';
        // create QR Code
        \QRcode::png($url, $filename, 'H', 2, 2);
      } else {
        // ไม่สามารถสร้างไดเร็คทอรี่ได้
        $filename = 'skin/img/blank.gif';
      }
    }
    // template
    $template = Template::createFromFile(ROOT_PATH.'modules/repair/views/print.html');
    $template->add(array(
      '/%COMPANY%/' => self::$cfg->web_title,
      '/%JOB_ID%/' => $index->id,
      '/%NAME%/' => $index->name,
      '/%PHONE%/' => $index->phone,
      '/%EQUIPMENT%/' => $index->equipment,
      '/%SERIAL%/' => $index->serial,
      '/%JOB_DESCRIPTION%/' => nl2br($index->job_description),
      '/%CREATE_DATE%/' => Date::format($index->create_date, 'd M Y'),
      '/%COMMENT%/' => $index->comment,
      '/%URL%/' => $url,
      '/%QRCODE%/' => WEB_URL.$qrcode_file,
      '/{WEBURL}/' => WEB_URL,
    ));

    return Language::trans($template->render());
  }
}