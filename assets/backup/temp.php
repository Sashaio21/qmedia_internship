#
# Магазин qmedia Database Dump
# MODX Version:1.4.35
# 
# Host: 
# Generation Time: 20-01-2025 10:38:35
# Server version: 10.4.32-MariaDB
# PHP Version: 8.2.12
# Database: `qmedia`
# Description: 
#

# --------------------------------------------------------

SET @old_sql_mode := @@sql_mode;
SET @new_sql_mode := @old_sql_mode;
SET @new_sql_mode := TRIM(BOTH ',' FROM REPLACE(CONCAT(',',@new_sql_mode,','),',NO_ZERO_DATE,'  ,','));
SET @new_sql_mode := TRIM(BOTH ',' FROM REPLACE(CONCAT(',',@new_sql_mode,','),',NO_ZERO_IN_DATE,',','));
SET @@sql_mode := @new_sql_mode ;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;


# --------------------------------------------------------



# --------------------------------------------------------

#
# Table structure for table `f743_active_user_locks`
#

DROP TABLE IF EXISTS `f743_active_user_locks`;
CREATE TABLE `f743_active_user_locks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sid` varchar(32) NOT NULL DEFAULT '',
  `internalKey` int(9) NOT NULL DEFAULT 0,
  `elementType` int(1) NOT NULL DEFAULT 0,
  `elementId` int(10) NOT NULL DEFAULT 0,
  `lasthit` int(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_element_id` (`elementType`,`elementId`,`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2034 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data about locked elements.';



# --------------------------------------------------------

#
# Table structure for table `f743_active_user_sessions`
#

DROP TABLE IF EXISTS `f743_active_user_sessions`;
CREATE TABLE `f743_active_user_sessions` (
  `sid` varchar(32) NOT NULL DEFAULT '',
  `internalKey` int(9) NOT NULL DEFAULT 0,
  `lasthit` int(20) NOT NULL DEFAULT 0,
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data about valid user sessions.';



# --------------------------------------------------------

#
# Table structure for table `f743_active_users`
#

DROP TABLE IF EXISTS `f743_active_users`;
CREATE TABLE `f743_active_users` (
  `sid` varchar(32) NOT NULL DEFAULT '',
  `internalKey` int(9) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL DEFAULT '',
  `lasthit` int(20) NOT NULL DEFAULT 0,
  `action` varchar(10) NOT NULL DEFAULT '',
  `id` int(10) DEFAULT NULL,
  PRIMARY KEY (`sid`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data about last user action.';



# --------------------------------------------------------

#
# Table structure for table `f743_categories`
#

DROP TABLE IF EXISTS `f743_categories`;
CREATE TABLE `f743_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL DEFAULT '',
  `rank` int(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categories to be used snippets,tv,chunks, etc';



# --------------------------------------------------------

#
# Table structure for table `f743_document_groups`
#

DROP TABLE IF EXISTS `f743_document_groups`;
CREATE TABLE `f743_document_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `document_group` int(10) NOT NULL DEFAULT 0,
  `document` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_dg_id` (`document_group`,`document`),
  KEY `document` (`document`),
  KEY `document_group` (`document_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_documentgroup_names`
#

DROP TABLE IF EXISTS `f743_documentgroup_names`;
CREATE TABLE `f743_documentgroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(245) NOT NULL DEFAULT '',
  `private_memgroup` tinyint(4) DEFAULT 0 COMMENT 'determine whether the document group is private to manager users',
  `private_webgroup` tinyint(4) DEFAULT 0 COMMENT 'determines whether the document is private to web users',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_event_log`
#

DROP TABLE IF EXISTS `f743_event_log`;
CREATE TABLE `f743_event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) DEFAULT 0,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1- information, 2 - warning, 3- error',
  `user` int(11) NOT NULL DEFAULT 0 COMMENT 'link to user table',
  `usertype` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 - manager, 1 - web',
  `source` varchar(50) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stores event and error logs';



# --------------------------------------------------------

#
# Table structure for table `f743_manager_log`
#

DROP TABLE IF EXISTS `f743_manager_log`;
CREATE TABLE `f743_manager_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `timestamp` int(20) NOT NULL DEFAULT 0,
  `internalKey` int(10) NOT NULL DEFAULT 0,
  `username` varchar(255) DEFAULT NULL,
  `action` int(10) NOT NULL DEFAULT 0,
  `itemid` varchar(10) DEFAULT '0',
  `itemname` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(46) DEFAULT NULL,
  `useragent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3853 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains a record of user interaction.';



# --------------------------------------------------------

#
# Table structure for table `f743_manager_users`
#

DROP TABLE IF EXISTS `f743_manager_users`;
CREATE TABLE `f743_manager_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains login information for backend users.';



# --------------------------------------------------------

#
# Table structure for table `f743_member_groups`
#

DROP TABLE IF EXISTS `f743_member_groups`;
CREATE TABLE `f743_member_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_group` int(10) NOT NULL DEFAULT 0,
  `member` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_group_member` (`user_group`,`member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_membergroup_access`
#

DROP TABLE IF EXISTS `f743_membergroup_access`;
CREATE TABLE `f743_membergroup_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `membergroup` int(10) NOT NULL DEFAULT 0,
  `documentgroup` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_membergroup_names`
#

DROP TABLE IF EXISTS `f743_membergroup_names`;
CREATE TABLE `f743_membergroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(245) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_content`
#

DROP TABLE IF EXISTS `f743_site_content`;
CREATE TABLE `f743_site_content` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'document',
  `contentType` varchar(50) NOT NULL DEFAULT 'text/html',
  `pagetitle` varchar(255) NOT NULL DEFAULT '',
  `longtitle` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(245) DEFAULT '',
  `link_attributes` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link attriubtes',
  `published` int(1) NOT NULL DEFAULT 0,
  `pub_date` int(20) NOT NULL DEFAULT 0,
  `unpub_date` int(20) NOT NULL DEFAULT 0,
  `parent` int(10) NOT NULL DEFAULT 0,
  `isfolder` int(1) NOT NULL DEFAULT 0,
  `introtext` text DEFAULT NULL COMMENT 'Used to provide quick summary of the document',
  `content` mediumtext DEFAULT NULL,
  `richtext` tinyint(1) NOT NULL DEFAULT 1,
  `template` int(10) NOT NULL DEFAULT 0,
  `menuindex` int(10) NOT NULL DEFAULT 0,
  `searchable` int(1) NOT NULL DEFAULT 1,
  `cacheable` int(1) NOT NULL DEFAULT 1,
  `createdby` int(10) NOT NULL DEFAULT 0,
  `createdon` int(20) NOT NULL DEFAULT 0,
  `editedby` int(10) NOT NULL DEFAULT 0,
  `editedon` int(20) NOT NULL DEFAULT 0,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `deletedon` int(20) NOT NULL DEFAULT 0,
  `deletedby` int(10) NOT NULL DEFAULT 0,
  `publishedon` int(20) NOT NULL DEFAULT 0 COMMENT 'Date the document was published',
  `publishedby` int(10) NOT NULL DEFAULT 0 COMMENT 'ID of user who published the document',
  `menutitle` varchar(255) NOT NULL DEFAULT '' COMMENT 'Menu title',
  `donthit` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Disable page hit count',
  `privateweb` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Private web document',
  `privatemgr` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Private manager document',
  `content_dispo` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-inline, 1-attachment',
  `hidemenu` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Hide document from menu',
  `alias_visible` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `parent` (`parent`),
  KEY `aliasidx` (`alias`),
  KEY `typeidx` (`type`),
  FULLTEXT KEY `content_ft_idx` (`pagetitle`,`description`,`content`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains the site document tree.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_htmlsnippets`
#

DROP TABLE IF EXISTS `f743_site_htmlsnippets`;
CREATE TABLE `f743_site_htmlsnippets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Chunk',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `editor_name` varchar(50) NOT NULL DEFAULT 'none',
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Cache option',
  `snippet` mediumtext DEFAULT NULL,
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  `disabled` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Disables the snippet',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains the site chunks.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_module_access`
#

DROP TABLE IF EXISTS `f743_site_module_access`;
CREATE TABLE `f743_site_module_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL DEFAULT 0,
  `usergroup` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Module users group access permission';



# --------------------------------------------------------

#
# Table structure for table `f743_site_module_depobj`
#

DROP TABLE IF EXISTS `f743_site_module_depobj`;
CREATE TABLE `f743_site_module_depobj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL DEFAULT 0,
  `resource` int(11) NOT NULL DEFAULT 0,
  `type` int(2) NOT NULL DEFAULT 0 COMMENT '10-chunks, 20-docs, 30-plugins, 40-snips, 50-tpls, 60-tvs',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Module Dependencies';



# --------------------------------------------------------

#
# Table structure for table `f743_site_modules`
#

DROP TABLE IF EXISTS `f743_site_modules`;
CREATE TABLE `f743_site_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '0',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `disabled` tinyint(4) NOT NULL DEFAULT 0,
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `wrap` tinyint(4) NOT NULL DEFAULT 0,
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT 'url to module icon',
  `enable_resource` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'enables the resource file feature',
  `resourcefile` varchar(255) NOT NULL DEFAULT '' COMMENT 'a physical link to a resource file',
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  `guid` varchar(32) NOT NULL DEFAULT '' COMMENT 'globally unique identifier',
  `enable_sharedparams` tinyint(4) NOT NULL DEFAULT 0,
  `properties` text DEFAULT NULL,
  `modulecode` mediumtext DEFAULT NULL COMMENT 'module boot up code',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Site Modules';



# --------------------------------------------------------

#
# Table structure for table `f743_site_plugin_events`
#

DROP TABLE IF EXISTS `f743_site_plugin_events`;
CREATE TABLE `f743_site_plugin_events` (
  `pluginid` int(10) NOT NULL,
  `evtid` int(10) NOT NULL DEFAULT 0,
  `priority` int(10) NOT NULL DEFAULT 0 COMMENT 'determines plugin run order',
  PRIMARY KEY (`pluginid`,`evtid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Links to system events';



# --------------------------------------------------------

#
# Table structure for table `f743_site_plugins`
#

DROP TABLE IF EXISTS `f743_site_plugins`;
CREATE TABLE `f743_site_plugins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Plugin',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Cache option',
  `plugincode` mediumtext DEFAULT NULL,
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `properties` text DEFAULT NULL COMMENT 'Default Properties',
  `disabled` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Disables the plugin',
  `moduleguid` varchar(32) NOT NULL DEFAULT '' COMMENT 'GUID of module from which to import shared parameters',
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains the site plugins.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_snippets`
#

DROP TABLE IF EXISTS `f743_site_snippets`;
CREATE TABLE `f743_site_snippets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT 'Snippet',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `cache_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Cache option',
  `snippet` mediumtext DEFAULT NULL,
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `properties` text DEFAULT NULL COMMENT 'Default Properties',
  `moduleguid` varchar(32) NOT NULL DEFAULT '' COMMENT 'GUID of module from which to import shared parameters',
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  `disabled` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Disables the snippet',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains the site snippets.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_templates`
#

DROP TABLE IF EXISTS `f743_site_templates`;
CREATE TABLE `f743_site_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `templatename` varchar(100) NOT NULL DEFAULT '',
  `templatealias` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL DEFAULT 'Template',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT 'url to icon file',
  `template_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-page,1-content',
  `content` mediumtext DEFAULT NULL,
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `selectable` tinyint(4) NOT NULL DEFAULT 1,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains the site templates.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_tmplvar_access`
#

DROP TABLE IF EXISTS `f743_site_tmplvar_access`;
CREATE TABLE `f743_site_tmplvar_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tmplvarid` int(10) NOT NULL DEFAULT 0,
  `documentgroup` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for template variable access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_site_tmplvar_contentvalues`
#

DROP TABLE IF EXISTS `f743_site_tmplvar_contentvalues`;
CREATE TABLE `f743_site_tmplvar_contentvalues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tmplvarid` int(10) NOT NULL DEFAULT 0 COMMENT 'Template Variable id',
  `contentid` int(10) NOT NULL DEFAULT 0 COMMENT 'Site Content Id',
  `value` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_tvid_contentid` (`tmplvarid`,`contentid`),
  KEY `idx_tmplvarid` (`tmplvarid`),
  KEY `idx_id` (`contentid`),
  FULLTEXT KEY `value_ft_idx` (`value`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Site Template Variables Content Values Link Table';



# --------------------------------------------------------

#
# Table structure for table `f743_site_tmplvar_templates`
#

DROP TABLE IF EXISTS `f743_site_tmplvar_templates`;
CREATE TABLE `f743_site_tmplvar_templates` (
  `tmplvarid` int(10) NOT NULL DEFAULT 0 COMMENT 'Template Variable id',
  `templateid` int(11) NOT NULL DEFAULT 0,
  `rank` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tmplvarid`,`templateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Site Template Variables Templates Link Table';



# --------------------------------------------------------

#
# Table structure for table `f743_site_tmplvars`
#

DROP TABLE IF EXISTS `f743_site_tmplvars`;
CREATE TABLE `f743_site_tmplvars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `caption` varchar(80) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `editor_type` int(11) NOT NULL DEFAULT 0 COMMENT '0-plain text,1-rich text,2-code editor',
  `category` int(11) NOT NULL DEFAULT 0 COMMENT 'category id',
  `locked` tinyint(4) NOT NULL DEFAULT 0,
  `elements` text DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `display` varchar(20) NOT NULL DEFAULT '' COMMENT 'Display Control',
  `display_params` text DEFAULT NULL COMMENT 'Display Control Properties',
  `default_text` text DEFAULT NULL,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `indx_rank` (`rank`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Site Template Variables';



# --------------------------------------------------------

#
# Table structure for table `f743_system_eventnames`
#

DROP TABLE IF EXISTS `f743_system_eventnames`;
CREATE TABLE `f743_system_eventnames` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `service` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'System Service number',
  `groupname` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='System Event Names.';



# --------------------------------------------------------

#
# Table structure for table `f743_system_settings`
#

DROP TABLE IF EXISTS `f743_system_settings`;
CREATE TABLE `f743_system_settings` (
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`setting_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains Content Manager settings.';



# --------------------------------------------------------

#
# Table structure for table `f743_user_attributes`
#

DROP TABLE IF EXISTS `f743_user_attributes`;
CREATE TABLE `f743_user_attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `internalKey` int(10) NOT NULL DEFAULT 0,
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `role` int(10) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `mobilephone` varchar(100) NOT NULL DEFAULT '',
  `blocked` int(1) NOT NULL DEFAULT 0,
  `blockeduntil` int(11) NOT NULL DEFAULT 0,
  `blockedafter` int(11) NOT NULL DEFAULT 0,
  `logincount` int(11) NOT NULL DEFAULT 0,
  `lastlogin` int(11) NOT NULL DEFAULT 0,
  `thislogin` int(11) NOT NULL DEFAULT 0,
  `failedlogincount` int(10) NOT NULL DEFAULT 0,
  `sessionid` varchar(100) NOT NULL DEFAULT '',
  `dob` int(10) NOT NULL DEFAULT 0,
  `gender` int(1) NOT NULL DEFAULT 0 COMMENT '0 - unknown, 1 - Male 2 - female',
  `country` varchar(5) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(25) NOT NULL DEFAULT '',
  `zip` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT 'link to photo',
  `comment` text DEFAULT NULL,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  `verified` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `userid` (`internalKey`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains information about the backend users.';



# --------------------------------------------------------

#
# Table structure for table `f743_user_messages`
#

DROP TABLE IF EXISTS `f743_user_messages`;
CREATE TABLE `f743_user_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL DEFAULT '',
  `subject` varchar(60) NOT NULL DEFAULT '',
  `message` text DEFAULT NULL,
  `sender` int(10) NOT NULL DEFAULT 0,
  `recipient` int(10) NOT NULL DEFAULT 0,
  `private` tinyint(4) NOT NULL DEFAULT 0,
  `postdate` int(20) NOT NULL DEFAULT 0,
  `messageread` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains messages for the Content Manager messaging system.';



# --------------------------------------------------------

#
# Table structure for table `f743_user_roles`
#

DROP TABLE IF EXISTS `f743_user_roles`;
CREATE TABLE `f743_user_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `frames` int(1) NOT NULL DEFAULT 0,
  `home` int(1) NOT NULL DEFAULT 0,
  `view_document` int(1) NOT NULL DEFAULT 0,
  `new_document` int(1) NOT NULL DEFAULT 0,
  `save_document` int(1) NOT NULL DEFAULT 0,
  `publish_document` int(1) NOT NULL DEFAULT 0,
  `delete_document` int(1) NOT NULL DEFAULT 0,
  `empty_trash` int(1) NOT NULL DEFAULT 0,
  `action_ok` int(1) NOT NULL DEFAULT 0,
  `logout` int(1) NOT NULL DEFAULT 0,
  `help` int(1) NOT NULL DEFAULT 0,
  `messages` int(1) NOT NULL DEFAULT 0,
  `new_user` int(1) NOT NULL DEFAULT 0,
  `edit_user` int(1) NOT NULL DEFAULT 0,
  `logs` int(1) NOT NULL DEFAULT 0,
  `edit_parser` int(1) NOT NULL DEFAULT 0,
  `save_parser` int(1) NOT NULL DEFAULT 0,
  `edit_template` int(1) NOT NULL DEFAULT 0,
  `settings` int(1) NOT NULL DEFAULT 0,
  `credits` int(1) NOT NULL DEFAULT 0,
  `new_template` int(1) NOT NULL DEFAULT 0,
  `save_template` int(1) NOT NULL DEFAULT 0,
  `delete_template` int(1) NOT NULL DEFAULT 0,
  `edit_snippet` int(1) NOT NULL DEFAULT 0,
  `new_snippet` int(1) NOT NULL DEFAULT 0,
  `save_snippet` int(1) NOT NULL DEFAULT 0,
  `delete_snippet` int(1) NOT NULL DEFAULT 0,
  `edit_chunk` int(1) NOT NULL DEFAULT 0,
  `new_chunk` int(1) NOT NULL DEFAULT 0,
  `save_chunk` int(1) NOT NULL DEFAULT 0,
  `delete_chunk` int(1) NOT NULL DEFAULT 0,
  `empty_cache` int(1) NOT NULL DEFAULT 0,
  `edit_document` int(1) NOT NULL DEFAULT 0,
  `change_password` int(1) NOT NULL DEFAULT 0,
  `error_dialog` int(1) NOT NULL DEFAULT 0,
  `about` int(1) NOT NULL DEFAULT 0,
  `category_manager` int(1) NOT NULL DEFAULT 0,
  `file_manager` int(1) NOT NULL DEFAULT 0,
  `assets_files` int(1) NOT NULL DEFAULT 0,
  `assets_images` int(1) NOT NULL DEFAULT 0,
  `save_user` int(1) NOT NULL DEFAULT 0,
  `delete_user` int(1) NOT NULL DEFAULT 0,
  `save_password` int(11) NOT NULL DEFAULT 0,
  `edit_role` int(1) NOT NULL DEFAULT 0,
  `save_role` int(1) NOT NULL DEFAULT 0,
  `delete_role` int(1) NOT NULL DEFAULT 0,
  `new_role` int(1) NOT NULL DEFAULT 0,
  `access_permissions` int(1) NOT NULL DEFAULT 0,
  `bk_manager` int(1) NOT NULL DEFAULT 0,
  `new_plugin` int(1) NOT NULL DEFAULT 0,
  `edit_plugin` int(1) NOT NULL DEFAULT 0,
  `save_plugin` int(1) NOT NULL DEFAULT 0,
  `delete_plugin` int(1) NOT NULL DEFAULT 0,
  `new_module` int(1) NOT NULL DEFAULT 0,
  `edit_module` int(1) NOT NULL DEFAULT 0,
  `save_module` int(1) NOT NULL DEFAULT 0,
  `delete_module` int(1) NOT NULL DEFAULT 0,
  `exec_module` int(1) NOT NULL DEFAULT 0,
  `view_eventlog` int(1) NOT NULL DEFAULT 0,
  `delete_eventlog` int(1) NOT NULL DEFAULT 0,
  `new_web_user` int(1) NOT NULL DEFAULT 0,
  `edit_web_user` int(1) NOT NULL DEFAULT 0,
  `save_web_user` int(1) NOT NULL DEFAULT 0,
  `delete_web_user` int(1) NOT NULL DEFAULT 0,
  `web_access_permissions` int(1) NOT NULL DEFAULT 0,
  `view_unpublished` int(1) NOT NULL DEFAULT 0,
  `import_static` int(1) NOT NULL DEFAULT 0,
  `export_static` int(1) NOT NULL DEFAULT 0,
  `remove_locks` int(1) NOT NULL DEFAULT 0,
  `display_locks` int(1) NOT NULL DEFAULT 0,
  `change_resourcetype` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains information describing the user roles.';



# --------------------------------------------------------

#
# Table structure for table `f743_user_settings`
#

DROP TABLE IF EXISTS `f743_user_settings`;
CREATE TABLE `f743_user_settings` (
  `user` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`user`,`setting_name`),
  KEY `setting_name` (`setting_name`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains backend user settings.';



# --------------------------------------------------------

#
# Table structure for table `f743_web_groups`
#

DROP TABLE IF EXISTS `f743_web_groups`;
CREATE TABLE `f743_web_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `webgroup` int(10) NOT NULL DEFAULT 0,
  `webuser` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_group_user` (`webgroup`,`webuser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for web access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_web_user_attributes`
#

DROP TABLE IF EXISTS `f743_web_user_attributes`;
CREATE TABLE `f743_web_user_attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `internalKey` int(10) NOT NULL DEFAULT 0,
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `role` int(10) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `mobilephone` varchar(100) NOT NULL DEFAULT '',
  `blocked` int(1) NOT NULL DEFAULT 0,
  `blockeduntil` int(11) NOT NULL DEFAULT 0,
  `blockedafter` int(11) NOT NULL DEFAULT 0,
  `logincount` int(11) NOT NULL DEFAULT 0,
  `lastlogin` int(11) NOT NULL DEFAULT 0,
  `thislogin` int(11) NOT NULL DEFAULT 0,
  `failedlogincount` int(10) NOT NULL DEFAULT 0,
  `sessionid` varchar(100) NOT NULL DEFAULT '',
  `dob` int(10) NOT NULL DEFAULT 0,
  `gender` int(1) NOT NULL DEFAULT 0 COMMENT '0 - unknown, 1 - Male 2 - female',
  `country` varchar(25) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(25) NOT NULL DEFAULT '',
  `zip` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(100) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT 'link to photo',
  `comment` text DEFAULT NULL,
  `createdon` int(11) NOT NULL DEFAULT 0,
  `editedon` int(11) NOT NULL DEFAULT 0,
  `verified` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `userid` (`internalKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains information for web users.';



# --------------------------------------------------------

#
# Table structure for table `f743_web_user_settings`
#

DROP TABLE IF EXISTS `f743_web_user_settings`;
CREATE TABLE `f743_web_user_settings` (
  `webuser` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL DEFAULT '',
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`webuser`,`setting_name`),
  KEY `setting_name` (`setting_name`),
  KEY `webuserid` (`webuser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains web user settings.';



# --------------------------------------------------------

#
# Table structure for table `f743_web_users`
#

DROP TABLE IF EXISTS `f743_web_users`;
CREATE TABLE `f743_web_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `cachepwd` varchar(100) NOT NULL DEFAULT '' COMMENT 'Store new unconfirmed password',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# --------------------------------------------------------

#
# Table structure for table `f743_webgroup_access`
#

DROP TABLE IF EXISTS `f743_webgroup_access`;
CREATE TABLE `f743_webgroup_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `webgroup` int(10) NOT NULL DEFAULT 0,
  `documentgroup` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for web access permissions.';



# --------------------------------------------------------

#
# Table structure for table `f743_webgroup_names`
#

DROP TABLE IF EXISTS `f743_webgroup_names`;
CREATE TABLE `f743_webgroup_names` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(245) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Contains data used for web access permissions.';


#
# Dumping data for table `f743_active_user_locks`
#

INSERT INTO `f743_active_user_locks` VALUES
  ('2033','q8kshc0e57u3q56gprfl4tleao','1','7','1','1737365892');

#
# Dumping data for table `f743_active_user_sessions`
#

INSERT INTO `f743_active_user_sessions` VALUES
  ('q8kshc0e57u3q56gprfl4tleao','1','1737365915','127.0.0.1');

#
# Dumping data for table `f743_active_users`
#

INSERT INTO `f743_active_users` VALUES
  ('sstu4it2tvrdca6b27b7o5r2u1','1','admin','1736949099','67','22'),
  ('q8kshc0e57u3q56gprfl4tleao','1','admin','1737365915','93',NULL);

#
# Dumping data for table `f743_categories`
#

INSERT INTO `f743_categories` VALUES
  ('1','SEO','0'),
  ('2','Templates','0'),
  ('3','Js','0'),
  ('4','Manager and Admin','0'),
  ('5','Content','0'),
  ('6','Navigation','0'),
  ('7','Шаблоны страниц','0'),
  ('8','qmedia','0');

#
# Dumping data for table `f743_document_groups`
#

#
# Dumping data for table `f743_documentgroup_names`
#

#
# Dumping data for table `f743_event_log`
#
