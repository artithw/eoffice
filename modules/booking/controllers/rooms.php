<?php
/**
 * @filesource modules/booking/controllers/rooms.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Booking\Rooms;

use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=booking-rooms.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{

  /**
   * ตารางรายการ สินค้า.
   *
   * @param Request $request
   *
   * @return string
   */
  public function render(Request $request)
  {
    // ข้อความ title bar
    $this->title = Language::trans('{LNG_List of} {LNG_Room}');
    // เลือกเมนู
    $this->menu = 'booking';
    // สมาชิก
    if (Login::isMember()) {
      // แสดงผล
      $section = Html::create('section', array(
          'class' => 'content_bg',
      ));
      // breadcrumbs
      $breadcrumbs = $section->add('div', array(
        'class' => 'breadcrumbs',
      ));
      $ul = $breadcrumbs->add('ul');
      $ul->appendChild('<li><span class="icon-calendar">{LNG_Room}</span></li>');
      $ul->appendChild('<li><span>{LNG_List of}</span></li>');
      $section->add('header', array(
        'innerHTML' => '<h2 class="icon-list">'.$this->title.'</h2>',
      ));
      // แสดงตาราง
      $section->appendChild(createClass('Booking\Rooms\View')->render($request));

      return $section->render();
    }
    // 404

    return \Index\Error\Controller::execute($this);
  }
}