<?php

class DateTimeView {

	/**
	 * Create date time string
	 *
	 * Should be displayed on all pages
	 *
	 * @return string and are in date time format
	 */
	public function show() {

		$timeString = date('l, \t\h\e jS \of F Y, \T\h\e \t\i\m\e \i\s H:i:s');

		return '<p>' . $timeString . '</p>';
	}
}
