<?php

class Rutools
{

	public $return_data = "";
	public static $name         = 'Russian Utilites';
  public static $version      = '2.0.0';
  public static $author       = 'Dmitriy Nyashkin';
  public static $author_url   = 'http://fdcore.com/';
  public static $description  = 'Плагин для работы с русскими датами и плюрализацией';
  public static $typography   = FALSE;

	public function __construct()
	{
		include_once PATH_THIRD.'rutools/php_rutils/RUtils.php';
		date_default_timezone_set("Europe/Moscow");  // на всякий случай фикс

	}

	function plural() {

		include_once PATH_THIRD.'rutools/php_rutils/Numeral.php';

		$variants  = ee()->TMPL->fetch_param('variants');
		$count 	   = ee()->TMPL->fetch_param('num');
		$only_text = ee()->TMPL->fetch_param('only_text');

		$variants = explode(',', $variants);

		if($only_text == 'yes') return RUtils::numeral()->choosePlural($count, $variants);

		return RUtils::numeral()->getPlural($count, $variants);
	}

	function sum_string() {

		include_once PATH_THIRD.'rutools/php_rutils/Numeral.php';

		$variants = ee()->TMPL->fetch_param('variants');
		$count = intval(ee()->TMPL->fetch_param('num'));
		$sex = strtolower(ee()->TMPL->fetch_param('sex'));

		$variants = explode(',', $variants);

		if($sex == 'male'){
			return RUtils::numeral()->sumString($count, RUtils::MALE, $variants);
		}

		if($sex == 'female'){
			return RUtils::numeral()->sumString($count, RUtils::FEMALE, $variants);
		}

		if($sex == 'neuter'){
			return RUtils::numeral()->sumString($count, RUtils::NEUTER, $variants);
		}

		return RUtils::numeral()->sumString($count, RUtils::NEUTER, $variants);

	}

	function number_words(){

		include_once PATH_THIRD.'rutools/php_rutils/Numeral.php';

		$count = ee()->TMPL->fetch_param('num');

		$numeral = RUtils::numeral();

		return $numeral->getInWords($count);
	}

	function get_rubles() {

		include_once PATH_THIRD.'rutools/php_rutils/Numeral.php';

		$num = ee()->TMPL->fetch_param('num');

		return RUtils::numeral()->getRubles($num);
	}

	/*
		Вывод форматированой даты


		{exp:rutools:date format="Я покакал d F в H:i"}

		- format (default Y.m.d H:i)
		- date (default now) - unixtime or string date
		- offset - смещение времени на промежуток, например +1 day, +1 hour, -2 month ...

	*/
	function date() {

		include_once PATH_THIRD.'rutools/php_rutils/Dt.php';
		include_once PATH_THIRD.'rutools/php_rutils/struct/TimeParams.php';

		$date   = ee()->TMPL->fetch_param('date', null);
		$format = ee()->TMPL->fetch_param('format', 'Y.m.d H:i');
		$offset = ee()->TMPL->fetch_param('offset'); // +2 day, -10 hour ...

		$params = new TimeParams();

		if($offset) $date = strtotime($offset, $date);

		$params->date = $date;
		$params->format = $format;
		$params->monthInflected = true;

		return RUtils::dt()->ruStrFTime($params);

	}

	// {exp:rutools:timeleft date="1397475973"}

	function timeleft() {

		include_once PATH_THIRD.'rutools/php_rutils/Numeral.php';
		include_once PATH_THIRD.'rutools/php_rutils/Dt.php';
		include_once PATH_THIRD.'rutools/php_rutils/struct/TimeParams.php';

		$date = ee()->TMPL->fetch_param('date', time());

		return RUtils::dt()->distanceOfTimeInWords($date);
	}

	// {exp:rutools:get_age date="2000-01-01"} лет назад
	// {exp:rutools:get_age date="1397475973"} лет

	function get_age() {

		include_once PATH_THIRD . 'rutools/php_rutils/Dt.php';
		include_once PATH_THIRD . 'rutools/php_rutils/struct/TimeParams.php';

		$date = ee()->TMPL->fetch_param('date');

		if(is_numeric($date) > 0) $birthDate = intval($date); else $birthDate = strtotime($date);

		try  {

			return RUtils::dt()->getAge($birthDate);

		} catch (\InvalidArgumentException $e) {

			show_error($e->getMessage());

		}

	}

	function time_interval(){
		include_once PATH_THIRD . 'rutools/php_rutils/Numeral.php';
		include_once PATH_THIRD . 'rutools/php_rutils/Dt.php';
		include_once PATH_THIRD . 'rutools/php_rutils/struct/TimeParams.php';

		$from = ee()->TMPL->fetch_param('from');
		$to = ee()->TMPL->fetch_param('to');
		$accuracy = ee()->TMPL->fetch_param('accuracy');

		switch ($accuracy) {
			case 'minute':
				$accuracy = RUtils::ACCURACY_MINUTE;
				break;
			case 'years':
				$accuracy = RUtils::ACCURACY_YEAR;
				break;
			case 'months':
				$accuracy = RUtils::ACCURACY_MONTH;
				break;
			case 'days':
				$accuracy = RUtils::ACCURACY_DAY;
				break;
			case 'hours':
				$accuracy = RUtils::ACCURACY_HOUR;
				break;
			default:
				$accuracy = RUtils::ACCURACY_MINUTE;
		}

		return RUtils::dt()->distanceOfTimeInWords($to, $from, $accuracy);
	}

	function translify() {

		include_once PATH_THIRD . 'rutools/php_rutils/Translit.php';

		$text = ee()->TMPL->fetch_param('text');

		return RUtils::translit()->translify($text);

	}

	function detranslify() {

		include_once PATH_THIRD . 'rutools/php_rutils/Translit.php';

		$text = ee()->TMPL->fetch_param('text');

		return RUtils::translit()->detranslify($text);

	}

	function slugify() {

		include_once PATH_THIRD . 'rutools/php_rutils/Translit.php';

		$text = ee()->TMPL->fetch_param('text');

		return RUtils::translit()->slugify($text);
	}

}
