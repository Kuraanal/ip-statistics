-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Généré le : Mercredi 23 Avril 2009 à 08:41
-- Version du serveur: 4.1.13
-- Version de PHP: 5.0.4
-- 
-- Base de données: `ip_stat`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `adr_ip`
-- 

CREATE TABLE `adr_ip` (
  `adr_ip_ip` varchar(15) NOT NULL default '',
  `adr_ip_lan` varchar(15) NOT NULL default '',
  `adr_ip_time` varchar(255) NOT NULL default '',
  KEY `adr_ip_ip` (`adr_ip_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

-- 
-- Structure de la table `reseaux`
-- 

CREATE TABLE `reseaux` (
  `lan_id` smallint(3) NOT NULL auto_increment,
  `lan_ip` varchar(15) NOT NULL default '',
  `lan_mask` varchar(15) NOT NULL default '',
  `lan_name` varchar(75) NOT NULL default '',
  `lan_site` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`lan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;


-- --------------------------------------------------------

-- 
-- Structure de la table `routers`
-- 

CREATE TABLE `routers` (
  `router_id` smallint(3) NOT NULL auto_increment,
  `router_ip` varchar(15) NOT NULL default '',
  `router_comm` varchar(50) NOT NULL default '',
  `router_name` varchar(70) NOT NULL default '',
  PRIMARY KEY  (`router_id`),
  KEY `router_ip` (`router_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

-- 
-- Structure de la table `user`
-- 

CREATE TABLE `user` (
  `user_id` smallint(3) NOT NULL auto_increment,
  `user_name` varchar(125) NOT NULL default '',
  `user_pass` varchar(255) NOT NULL default '',
  `user_isadmin` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;