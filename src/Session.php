<?php
/**
 * PHP library for handling sessions.
 *
 * @author    cangak  <cangak.stres@gmail.com>
 * @copyright 2019 (c) cangak - Session
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/cangak/Session
 * @since     1.0.0
 */
namespace Cangak\Session;

class Session {

	private static $sessionMulai = false;

	public function register($time, $array) {
		if (self::$sessionMulai == false) {
			session_set_cookie_params($this->newTime());
			session_start();
			foreach ($array as $key => $value) {
				$_SESSION['session_id'] = session_id();
				$_SESSION[$key] = $value;
				$_SESSION['session_start'] = $this->newTime();
				$_SESSION['session_time'] = intval($time);
			}
			return self::$sessionMulai = true;
		}

		return false;

	}

	public function islogin() {
		if (!empty($_SESSION['session_id']) and isset($_SESSION['username']) and ($_SESSION['username'] != '')) {
			return true;
		} else {
			return false;
		}
	}

	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public function get($key) {
		return $_SESSION[$key];
	}

	public function getSession() {
		return $_SESSION;
	}
	public function getSessionId() {
		return $_SESSION['session_id'];
	}
	public function getusernmae() {
		return $_SESSION['username'];
	}
	public function getlevel() {
		return $_SESSION['level'];
	}
	public function getlengkap() {
		return $_SESSION['namalengkap'];
	}
	public function timeout_session() {
		if ($_SESSION['session_start'] < $this->timeNow()) {
			return true;
		} else {
			return false;
		}
	}

	public function renew() {
		$_SESSION['session_start'] = $this->newTime();
	}

	private function timeNow() {
		$currentHour = date('H');
		$currentMin = date('i');
		$currentSec = date('s');
		$currentMon = date('m');
		$currentDay = date('d');
		$currentYear = date('y');
		return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
	}

	private function newTime() {
		if (isset($_SESSION['session_time']) and $_SESSION['session_time'] != '') {
			$currentHour = date('H');
		}

		$currentMin = date('i');
		$currentSec = date('s');
		$currentMon = date('m');
		$currentDay = date('d');
		$currentYear = date('y');
		$stime = $currentMin + 60;
		return mktime(date('H'), $stime, $currentSec, $currentMon, $currentDay, $currentYear);
	}

	public function end() {
		session_destroy();
		$_SESSION = array();
		return self::$sessionMulai = false;
	}
}
