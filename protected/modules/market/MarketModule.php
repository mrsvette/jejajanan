<?php

class MarketModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		$this->defaultController = 'products';

		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'class'=>'CErrorHandler',
				'errorAction'=>'/appadmin/default/error',
			),
			'user'=>array(
				'class'=>'CWebUser',
				'stateKeyPrefix'=>'jagungbakar',
				'loginUrl'=>Yii::app()->createUrl('appadmin/default/login'),
				'allowAutoLogin'=>true,
			),
		), false);

		//set view path
		$this->setLayoutPath(Yii::getPathOfAlias('application.modules.appadmin').'/views/layouts');
		// import the module-level models and components
		$this->setImport(array(
			'market.models.*',
			'market.components.*',
			'appadmin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if(!Extension::getIsInstalled(array('id'=>'market')))
				throw new CHttpException(404,'The requested page does not exist.');
			return true;
		}
		else
			return false;
	}

	public function install()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `tbl_mod_product` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `product_category_id` bigint(20) DEFAULT NULL,
		  `product_payment_id` bigint(20) DEFAULT NULL,
		  `form_id` bigint(20) DEFAULT NULL,
		  `title` varchar(255) DEFAULT NULL,
		  `slug` varchar(255) DEFAULT NULL,
		  `description` text,
		  `unit` varchar(50) DEFAULT 'product',
		  `active` tinyint(1) DEFAULT '1',
		  `status` varchar(50) DEFAULT 'enabled' COMMENT 'enabled, disabled',
		  `hidden` tinyint(1) DEFAULT '0',
		  `is_addon` tinyint(1) DEFAULT '0',
		  `setup` varchar(50) DEFAULT 'after_payment',
		  `addons` text,
		  `icon_url` varchar(255) DEFAULT NULL,
		  `allow_quantity_select` tinyint(1) DEFAULT '0',
		  `stock_control` tinyint(1) DEFAULT '0',
		  `quantity_in_stock` int(11) DEFAULT '0',
		  `plugin` varchar(255) DEFAULT NULL,
		  `plugin_config` text,
		  `upgrades` text,
		  `priority` bigint(20) DEFAULT NULL,
		  `config` text,
		  `type` varchar(255) DEFAULT NULL,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL DEFAULT '0',
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `slug` (`slug`),
		  KEY `product_type_idx` (`type`),
		  KEY `product_category_id_idx` (`product_category_id`),
		  KEY `product_payment_id_idx` (`product_payment_id`),
		  KEY `form_id_idx` (`form_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_product_category` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) DEFAULT NULL,
		  `slug` varchar(255) DEFAULT NULL,
		  `description` text,
		  `icon_url` varchar(255) DEFAULT NULL,
		  `icon_fa` varchar(128) DEFAULT NULL,
		  `childs` text,
		  `parents` text,
		  `level` int(11) DEFAULT '0',
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL DEFAULT '0',
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_product_images` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `product_id` int(11) NOT NULL,
		  `image` varchar(128) NOT NULL,
		  `thumb` varchar(128) DEFAULT NULL,
		  `src` varchar(128) NOT NULL,
		  `type` int(11) DEFAULT '0',
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_product_payment` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `type` varchar(30) DEFAULT NULL COMMENT 'free, once, recurrent',
		  `once_price` decimal(18,2) DEFAULT '0.00',
		  `once_setup_price` decimal(18,2) DEFAULT '0.00',
		  `w_price` decimal(18,2) DEFAULT '0.00',
		  `m_price` decimal(18,2) DEFAULT '0.00',
		  `q_price` decimal(18,2) DEFAULT '0.00',
		  `b_price` decimal(18,2) DEFAULT '0.00',
		  `a_price` decimal(18,2) DEFAULT '0.00',
		  `bia_price` decimal(18,2) DEFAULT '0.00',
		  `tria_price` decimal(18,2) DEFAULT '0.00',
		  `w_setup_price` decimal(18,2) DEFAULT '0.00',
		  `m_setup_price` decimal(18,2) DEFAULT '0.00',
		  `q_setup_price` decimal(18,2) DEFAULT '0.00',
		  `b_setup_price` decimal(18,2) DEFAULT '0.00',
		  `a_setup_price` decimal(18,2) DEFAULT '0.00',
		  `bia_setup_price` decimal(18,2) DEFAULT '0.00',
		  `tria_setup_price` decimal(18,2) DEFAULT '0.00',
		  `w_enabled` tinyint(1) DEFAULT '1',
		  `m_enabled` tinyint(1) DEFAULT '1',
		  `q_enabled` tinyint(1) DEFAULT '1',
		  `b_enabled` tinyint(1) DEFAULT '1',
		  `a_enabled` tinyint(1) DEFAULT '1',
		  `bia_enabled` tinyint(1) DEFAULT '1',
		  `tria_enabled` tinyint(1) DEFAULT '1',
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL DEFAULT '0',
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_promo` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `code` varchar(100) DEFAULT NULL,
		  `description` text,
		  `type` varchar(30) NOT NULL DEFAULT 'percentage' COMMENT 'absolute, percentage, trial',
		  `value` decimal(18,2) DEFAULT NULL,
		  `maxuses` int(11) DEFAULT '0',
		  `used` int(11) DEFAULT '0',
		  `freesetup` tinyint(1) DEFAULT '0',
		  `once_per_client` tinyint(1) DEFAULT '0',
		  `recurring` tinyint(1) DEFAULT '0',
		  `active` tinyint(1) DEFAULT '0',
		  `products` text,
		  `periods` text,
		  `start_at` varchar(35) DEFAULT NULL,
		  `end_at` varchar(35) DEFAULT NULL,
		  `created_at` varchar(35) DEFAULT NULL,
		  `updated_at` varchar(35) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `start_index_idx` (`start_at`),
		  KEY `end_index_idx` (`end_at`),
		  KEY `active_index_idx` (`active`),
		  KEY `code_index_idx` (`code`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_pay_gateway` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) DEFAULT NULL,
		  `gateway` varchar(255) DEFAULT NULL,
		  `accepted_currencies` text,
		  `enabled` tinyint(1) DEFAULT '1',
		  `allow_single` tinyint(1) DEFAULT '1',
		  `allow_recurrent` tinyint(1) DEFAULT '1',
		  `test_mode` tinyint(1) DEFAULT '0',
		  `config` text,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL DEFAULT '0',
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `aid` varchar(255) DEFAULT NULL COMMENT 'Alternative id for foreign systems',
		  `client_group_id` bigint(20) DEFAULT NULL,
		  `role` varchar(30) NOT NULL DEFAULT 'client' COMMENT 'client',
		  `email` varchar(255) DEFAULT NULL,
		  `password` varchar(255) DEFAULT NULL,
		  `salt` varchar(255) DEFAULT NULL,
		  `status` varchar(30) DEFAULT 'active' COMMENT 'active, suspended, canceled',
		  `email_approved` tinyint(1) DEFAULT NULL,
		  `tax_exempt` tinyint(1) DEFAULT '0',
		  `type` varchar(100) DEFAULT NULL,
		  `first_name` varchar(100) DEFAULT NULL,
		  `last_name` varchar(100) DEFAULT NULL,
		  `gender` varchar(20) DEFAULT NULL,
		  `birthday` date DEFAULT NULL,
		  `phone_cc` varchar(10) DEFAULT NULL,
		  `phone` varchar(100) DEFAULT NULL,
		  `company` varchar(100) DEFAULT NULL,
		  `company_vat` varchar(100) DEFAULT NULL,
		  `company_number` varchar(255) DEFAULT NULL,
		  `address_1` varchar(100) DEFAULT NULL,
		  `address_2` varchar(100) DEFAULT NULL,
		  `city` varchar(100) DEFAULT NULL,
		  `state` varchar(100) DEFAULT NULL,
		  `postcode` varchar(100) DEFAULT NULL,
		  `country` varchar(100) DEFAULT NULL,
		  `notes` text,
		  `currency` varchar(10) DEFAULT 'IDR',
		  `lang` varchar(10) DEFAULT 'ID',
		  `ip` varchar(45) DEFAULT NULL,
		  `date_entry` datetime DEFAULT NULL,
		  `date_update` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `email` (`email`),
		  KEY `alternative_id_idx` (`aid`),
		  KEY `client_group_id_idx` (`client_group_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client_balance` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `client_id` bigint(20) DEFAULT NULL,
		  `type` varchar(100) DEFAULT NULL,
		  `rel_id` int(11) DEFAULT NULL,
		  `amount` decimal(18,2) DEFAULT '0.00',
		  `description` text,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `client_id_idx` (`client_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client_group` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) DEFAULT NULL,
		  `description` text,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client_order` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `client_id` bigint(20) DEFAULT NULL,
		  `product_id` bigint(20) DEFAULT NULL,
		  `form_id` bigint(20) DEFAULT NULL,
		  `promo_id` bigint(20) DEFAULT NULL,
		  `promo_recurring` tinyint(1) DEFAULT NULL,
		  `promo_used` bigint(20) DEFAULT NULL,
		  `group_id` varchar(255) DEFAULT NULL,
		  `group_master` tinyint(1) DEFAULT '0',
		  `invoice_option` varchar(255) DEFAULT NULL,
		  `title` varchar(255) DEFAULT NULL,
		  `currency` varchar(20) DEFAULT NULL,
		  `unpaid_invoice_id` bigint(20) DEFAULT NULL,
		  `service_id` bigint(20) DEFAULT NULL,
		  `service_type` varchar(100) DEFAULT NULL,
		  `period` varchar(20) DEFAULT NULL,
		  `quantity` bigint(20) DEFAULT '1',
		  `unit` varchar(100) DEFAULT NULL,
		  `price` double(18,2) DEFAULT NULL,
		  `discount` double(18,2) DEFAULT NULL COMMENT 'first invoice discount',
		  `status` varchar(50) DEFAULT NULL,
		  `reason` varchar(255) DEFAULT NULL COMMENT 'suspend/cancel reason',
		  `notes` text,
		  `config` text,
		  `referred_by` varchar(255) DEFAULT NULL,
		  `expires_at` datetime DEFAULT NULL,
		  `activated_at` datetime DEFAULT NULL,
		  `suspended_at` datetime DEFAULT NULL,
		  `unsuspended_at` datetime DEFAULT NULL,
		  `canceled_at` datetime DEFAULT NULL,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) DEFAULT NULL,
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `client_id_idx` (`client_id`),
		  KEY `product_id_idx` (`product_id`),
		  KEY `form_id_idx` (`form_id`),
		  KEY `promo_id_idx` (`promo_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client_order_meta` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `client_order_id` bigint(20) DEFAULT NULL,
		  `name` varchar(255) DEFAULT NULL,
		  `value` text,
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `client_order_id_idx` (`client_order_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_client_password_reset` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `client_id` bigint(20) DEFAULT NULL,
		  `hash` varchar(100) DEFAULT NULL,
		  `ip` varchar(45) DEFAULT NULL,
		  `date_entry` datetime NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `client_id_idx` (`client_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_currency` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `title` varchar(50) DEFAULT NULL,
		  `code` varchar(3) DEFAULT NULL,
		  `is_default` tinyint(1) DEFAULT '0',
		  `conversion_rate` decimal(13,6) DEFAULT '1.000000',
		  `format` varchar(30) DEFAULT NULL,
		  `price_format` varchar(50) DEFAULT '1',
		  `created_at` varchar(35) DEFAULT NULL,
		  `updated_at` varchar(35) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_invoice` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `client_id` bigint(20) DEFAULT NULL,
		  `serie` varchar(50) DEFAULT NULL,
		  `nr` varchar(255) DEFAULT NULL,
		  `hash` varchar(255) DEFAULT NULL COMMENT 'To access via public link',
		  `currency` varchar(25) DEFAULT NULL,
		  `currency_rate` decimal(13,6) DEFAULT NULL,
		  `credit` double(18,2) DEFAULT NULL,
		  `base_income` double(18,2) DEFAULT NULL COMMENT 'Income in default currency',
		  `base_refund` double(18,2) DEFAULT NULL COMMENT 'Refund in default currency',
		  `refund` double(18,2) DEFAULT NULL,
		  `notes` text,
		  `text_1` text,
		  `text_2` text,
		  `status` varchar(50) DEFAULT 'unpaid' COMMENT 'paid, unpaid',
		  `seller_company` varchar(255) DEFAULT NULL,
		  `seller_company_vat` varchar(255) DEFAULT NULL,
		  `seller_company_number` varchar(255) DEFAULT NULL,
		  `seller_address` varchar(255) DEFAULT NULL,
		  `seller_phone` varchar(255) DEFAULT NULL,
		  `seller_email` varchar(255) DEFAULT NULL,
		  `buyer_first_name` varchar(255) DEFAULT NULL,
		  `buyer_last_name` varchar(255) DEFAULT NULL,
		  `buyer_company` varchar(255) DEFAULT NULL,
		  `buyer_company_vat` varchar(255) DEFAULT NULL,
		  `buyer_company_number` varchar(255) DEFAULT NULL,
		  `buyer_address` varchar(255) DEFAULT NULL,
		  `buyer_city` varchar(255) DEFAULT NULL,
		  `buyer_state` varchar(255) DEFAULT NULL,
		  `buyer_country` varchar(255) DEFAULT NULL,
		  `buyer_zip` varchar(255) DEFAULT NULL,
		  `buyer_phone` varchar(255) DEFAULT NULL,
		  `buyer_phone_cc` varchar(255) DEFAULT NULL,
		  `buyer_email` varchar(255) DEFAULT NULL,
		  `gateway_id` int(11) DEFAULT NULL,
		  `approved` tinyint(1) DEFAULT '0',
		  `taxname` varchar(255) DEFAULT NULL,
		  `taxrate` varchar(35) DEFAULT NULL,
		  `due_at` datetime DEFAULT NULL,
		  `reminded_at` datetime DEFAULT NULL,
		  `paid_at` datetime DEFAULT NULL,
		  `date_entry` datetime NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `hash` (`hash`),
		  KEY `client_id_idx` (`client_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tbl_mod_invoice_item` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `invoice_id` bigint(20) DEFAULT NULL,
		  `type` varchar(100) DEFAULT NULL,
		  `rel_id` text,
		  `task` varchar(100) DEFAULT NULL,
		  `status` varchar(100) DEFAULT NULL,
		  `title` varchar(255) DEFAULT NULL,
		  `period` varchar(10) DEFAULT NULL,
		  `quantity` bigint(20) DEFAULT NULL,
		  `unit` varchar(100) DEFAULT NULL,
		  `price` double(18,2) DEFAULT NULL,
		  `charged` tinyint(1) DEFAULT '0',
		  `taxed` tinyint(1) DEFAULT '0',
		  `date_entry` datetime NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `invoice_id_idx` (`invoice_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		
		$command = Yii::app()->db->createCommand($sql);
		$command->execute();
		return true;
	}

	public function fetchNavigation()
    {
        return array(
            'custom'=> array(
				array(
					'label'=>'<span class="ion-bag"></span> <span class="nav_title">'.Yii::t('menu','Market Place').'</span><b class="arrow icon-angle-down"></b>', 
					'url'=>'#', 
					'items'=>array(
						array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Products', 'url'=>array('/market/products/view')),
						array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Clients', 'url'=>array('/market/clients/view')),
						array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Orders', 'url'=>array('/market/orders/view')),
						array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Invoices', 'url'=>array('/market/invoices/view')),
					),
					'itemOptions'=>array('class'=>'nav-parent'),
					'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),
					'visible'=>!Yii::app()->user->isGuest && Extension::getIsInstalled(array('id'=>'market'))
				),
            ),
        );
    }
}
