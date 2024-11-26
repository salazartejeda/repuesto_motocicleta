	<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Language: English
 * Module: SMS
 *
 * Last edited:
 * 23rd October 2017
 *
 * Package:
 * Stock Manage Advance v3.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 * You also can share your language files by emailing to saleem@tecdiary.com
 * Thank you
 */

// Please keep the translation  line length below 150 as only 160 character per sms or it will be multiple sms charges
// Available variable options for sales related sms:
// 1. {customer} for Customer Company/Contact Person
// 2. {sale_reference} for sale reference number
// 3. {grand_total} for sale grand total amount
//
// Payment related sms:
// 1. {payment_reference} for payment reference
// 2. {amount} for payment amount
//
// Delivery related sms:
// 1. {delivery_reference} for deliver reference
// 2. (received_by} for delivery received by field

	$lang['sale_added']       = 'Estimado {customer}, su pedido (Ref. {sale_reference}) ha sido recibido, por favor proceda al pago por un monto de {grand_total}. Gracias';
	$lang['payment_received'] = 'Estimado {customer}, su pago (Ref. {payment_reference}, Amt: {amount}) ha sido recibido, estaremos procesando su pedido en breve. Gracias';
	$lang['delivering']       = 'Estimado {customer}, estamos enviando su pedido (Ref. {delivery_reference}).';
	$lang['delived']          = 'Estimado {customer}, su pedido (Ref. {sale_reference}) ha sido recibido por {received_by}.';
