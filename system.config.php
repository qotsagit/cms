<?php
define('MAINTENANCE_MODE',false);
//url indexy w tablicy po explodzie url
define('URL_CTRL',0);
define('URL_METHOD',1);
define('URL_PARAM',2);

// Field SEARCH
define('SEARCH','search');
// REWRITE ENGINE BEGIN
// dla rewrite engine
define('CTRL','ctrl');
define('METHOD','method');

// php ma zdefiniowane
//define('SORT_ASC',0);
//define('SORT_DESC',1);

// akcje
define('ACTION','action');  // ustawiamy dla formularzy
define('ACTION_ID','id');
define('ACTION_ID_PARENT','id_parent');
define('ACTION_PAGE','page');
define('ACTION_LIMIT','limit');
define('ACTION_ORDER_COLUMN_ID','order');
define('ACTION_ORDER_ASC','asc');

define('URL',"url");
//defaultowe wartości
define('DEFAULT_CTRL',"home");
define('DEFAULT_ID',0);
define('DEFAULT_LANG_ID',2);
define('DEFAULT_ASC',0);
define('DEFAULT_PAGE',1);
define('DEFAULT_ROLE_ID',1);
define('DEFAULT_ORDER_COLUMN_ID',0);
define('DEFAULT_METHOD', "index");
define('DEFAULT_LIMIT',30);
define('DEFAULT_TEMPLATE','listView');

//folders
define('CTRL_FOLDER',"ctrls");
//define('VIEWS_FOLDER',"views/");
define('TEMPLATE_FOLDER','templates');

//define('MODELS_FOLDER',"models/");

// ctrl
define('CTRL_HOME','home');
define('CTRL_REGISTER','register');
define('CTRL_CATEGORY','category');
define('CTRL_LANG','lang');
define('CTRL_MSG','msg');
define('CTRL_USER','user');
define('CTRL_LOGIN','login');
define('CTRL_LOGOUT','logout');
define('CTRL_CONTACT','contact');
define('CTRL_PASSWORD','password');
define('CTRL_PAGE','page');
define('CTRL_NEWS','news');
define('CTRL_PRODUCT','product');
define('CTRL_GALLERY','gallery');
define('CTRL_SETTINGS','settings');
define('CTRL_PAYMENT','payment');
define('CTRL_ROLE','role');
define('CTRL_BLOCK','block');
define('CTRL_MENU','menu');
define('CTRL_REGION','region');
define('CTRL_TASK','task');
define('CTRL_CUSTOMER','customer');
define('CTRL_OFFER','offer');
define('CTRL_ORDER','order');
define('CTRL_CONTENT','content');
define('CTRL_TEMPLATE','template');
define('CTRL_PROFILE','profile');
define('CTRL_BUY','buy');
define('CTRL_CALENDAR','calendar');
define('CTRL_IMAGE','image');
define('CTRL_NEWSLETTER','newsletter');

//method
define('METHOD_LIST','list');
define('METHOD_ADD','add');
define('METHOD_ADD_NEWS','add_news');
define('METHOD_SAVE','save');
define('METHOD_EDIT','edit');
define('METHOD_DELETE','delete');
define('METHOD_DELETE_CONFIRM','delete_confirm');
define('METHOD_OPTIONS','options');
define('METHOD_SEARCH','search');
define('METHOD_JSON','json');
define('METHOD_UPLOAD','upload');
define('METHOD_PREVIEW','preview');
define('METHOD_VIEW','view');   //podgląd formularza przed wysłaniem w formularzu wyceny kół
define('METHOD_COPY','copy');
define('METHOD_COPY_CONFIRM','copy_confirm');
// w buy
define('METHOD_TRUE','true');
define('METHOD_OK','ok');
define('METHOD_ERROR','error');


define('METHOD_LIMIT','limit');
define('METHOD_PAGE','page');
define('METHOD_ASC','asc');
define('METHOD_ORDER','order');
define('METHOD_PARENT','parent');
define('METHOD_LANG','lang');


//FORM login fields
define('LOGIN_EMAIL','email');
define('LOGIN_PASSWORD','password');
define('METHOD_LOGIN','login');
define('LOGIN_REMEMBER_ME','remember');

//FORM register fields
define('REGISTER_EMAIL','email');
define('REGISTER_PASSWORD','password');
define('REGISTER_FIRST_NAME','first_name');
define('REGISTER_LAST_NAME','last_name');
define('REGISTER_NEWSLETTER','newsletter');
define('REGISTER_CITY','city');
define('REGISTER_ZIP_CODE','zip');
define('REGISTER_PHONE','phone');

//FORM user settings fields
define('SETTINGS_FIRST_NAME','first_name');
define('SETTINGS_LAST_NAME','last_name');
define('SETTINGS_PHONE','phone');

//ALL FORM
define('ID','id');                      // dla wspólnego widoku Delete
define('IDSELECTED','selected[]');      // array zaznaczonych rekordów w checkbox
define('IDLANG','id_lang');
define('IDROLE','id_role');
define('IDCATEGORY','id_category');
define('IDMSG','id_msg');
define('IDUSER','id_user');
define('IDBLOCK','id_block');
define('IDREGION','id_region');
define('IDPARENT','id_parent');
define('IDMENU','id_menu');
define('IDTASK','id_task');
define('IDPAGE','id_page');
define('IDFILE','id_file');
define('IDCALENDAR','id_calendar');
define('AVATAR','avatar');

// FORM user new,edit
define('USER_NICK','nick');
define('USER_EMAIL','email');
define('USER_FIRST_NAME','first_name');
define('USER_LAST_NAME','last_name');
define('USER_PHONE','phone');
define('USER_ACTIVE','active');
define('USER_PASSWORD','password');
define('USER_STATUS','status');
define('USER_OLD_PASSWORD','old_password');

define('STATUS_NOT_ACTIVE',0);
define('STATUS_ACTIVE',1);

define('USER_TYPE_USER',1);
define('USER_TYPE_CUSTOMER',0);

//Statuses for Portfolio content_type
define('STATUS_EXTRA_NOT_ACTIVE',0);
define('STATUS_EXTRA_IMAGE',1); //only images
define('STATUS_EXTRA_LOGO',2); //only logos
define('STATUS_EXTRA_IMAGE_LOGO',3); //images & logos


//Content types
define('CONTENT_PAGE',0);
define('CONTENT_PORTFOLIO',1);
define('CONTENT_NEWS',2);

//FORM content new,edit
define('CONTENT_IDCONTENT','id_content');
define('CONTENT_TITLE','title');
define('CONTENT_TEXT','text'); // NIE ZMIENIAĆ BO NIE ZAŁADUJE SIĘ CKEDITOR

//FORM category
define('CATEGORY_IDCATEGORY','category');
define('CATEGORY_NAME','name');

//FORM role
define('ROLE_NAME','name');

//FORM lang
define('LANG_NAME','name');
define('LANG_CODE','code');
define('LANG_STATUS','status');

//FORM msg
define('MSG_CONST','const');
define('MSG_DEFAULT_VALUE','default_value');
define('MSG_USER_VALUE','user_value');

//FORM password
define('PASSWORD','password');
define('REPEAT_PASSWORD','repeat_password');

//FORM block
define('BLOCK_TITLE','title');
define('BLOCK_TEXT','text');
define('BLOCK_STATUS','status');

//FORM region
define('REGION_NAME','name');

//FORM menu
define('MENU_NAME','name');
define('MENU_URL','url');
define('MENU_PAGE','page');
define('MENU_STATUS','status');
define('MENU_POSITION','position');

//FORM task
define('TASK_NAME','name');
define('TASK_STATUS','status');
define('TASK_TEXT','text');

//FORM page
define('PAGE_ID_LANG','page_id_lang');
define('PAGE_ID_PARENT','page_id_parent');
define('PAGE_TITLE','title');
define('PAGE_TEXT','text');
define('PAGE_URL','url');
define('PAGE_URL_ADDRESS','url_address');
define('PAGE_TEMPLATE','template');
define('PAGE_STATUS','status');
define('PAGE_STATUS_EXTRA','status_extra');
define('PAGE_CONTENT_TYPE','content_type');
define('PAGE_PRICE','price');
define('PAGE_META_TITLE','meta_title');
define('PAGE_META_DESCRIPTION','meta_desc');
define('PAGE_POSITION','position');

//FORM template
define('TEMPLATE_NAME','name');
define('TEMPLATE_OLD_NAME','old_file');
define('TEMPLATE_CONTENT','content');

//FORM contact
define('CONTACT_FIRST_NAME','first_name');
define('CONTACT_LAST_NAME','last_name');
define('CONTACT_EMAIL','email');
define('CONTACT_PHONE','phone');
define('CONTACT_SUBJECT','subject');
define('CONTACT_MESSAGE','message');
define('CONTACT_NEWSLETTER','newsletter');

//FORM settings
define('SETTINGS_IDLANG','idlang');
define('SETTINGS_EMAIL','email');

//FORM calendar
define('CALENDAR_START_DATE','start');
define('CALENDAR_END_DATE','end');
define('CALENDAR_NAME','name');
define('CALENDAR_TEXT','text');

//FORM pricing
define('PRICING_FIRST_NAME','first_name');
define('PRICING_LAST_NAME','last_name');
define('PRICING_PHONE','phone');
define('PRICING_EMAIL','email');
define('PRICING_COLOR','color');
define('PRICING_WHEEL','wheel');
define('PRICING_BUDGET','budget');
define('PRICING_YOUR_WEIGHT','your_weight');
define('PRICING_EXPECTED_WEIGHT','expected_weight');
define('PRICING_SIZE','size');
define('PRICING_BRAKE','brake');
define('PRICING_MOUNTING','mounting');
define('PRICING_PURPOSE_MTB','purpose_mtb');
define('PRICING_PURPOSE_ROAD','purpose_road');
define('PRICING_TIRE','tire');
define('PRICING_AXIS_FRONT','axis_front');
define('PRICING_AXIS_REAR','axis_rear');
define('PRICING_CASSETTE_MTB','cassette_mtb');
define('PRICING_CASSETTE_ROAD','cassette_road');
define('PRICING_SEALANT','sealant');
define('PRICING_COMMENT','comment');


define('_DEFAULT_LANG_ID_',1); //defaultowy język systemu 1 = english z bazy

//typy pól w Input
define('FIELD_TYPE_INPUT', 0);
define('FIELD_TYPE_EMAIL', 1);

//email status
define('EMAIL_VALID',0);
define('EMAIL_EXISTS',1);
define('EMAIL_NOT_VALID',2);
//define("EMAIL_LINK","<a href=".SITE_URL."/confirm/%s>%s</a>");

define('LANG_EN',1);
define('LANG_PL',2);

//statusy validacji
define('VALIDATION_NONE','0');
define('VALIDATION_TRUE','1');
define('VALIDATION_FALSE','2');
