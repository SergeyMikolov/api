<?php
namespace App\Domains;

/**
 * Class SubscriptionsTypesDomains
 * @package App\Domains
 */
class SubscriptionsTypesDomains
{
	const DAILY         = 'DAILY';  		# 'Разовый'
	const MONTHLY       = 'MONTHLY';  		# 'Месячный'
	const QUARTERLY     = 'QUARTERLY';  	# '3 месяца'
	const SEMI_ANNUAL   = 'SEMI_ANNUAL'; 	# '6 месяцов'
	const ANNUAL        = 'ANNUAL';  		# 'Год'
	const ALL_INCLUSIVE = 'ALL_INCLUSIVE';  # 'Всё включено на месяц'

	/**
	 * @var array
	 */
	public static $items = [
		self::DAILY,
		self::MONTHLY,
		self::QUARTERLY,
		self::SEMI_ANNUAL,
		self::ANNUAL,
		self::ALL_INCLUSIVE,
	];
}