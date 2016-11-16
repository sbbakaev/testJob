SELECT * FROM data,link,info WHERE link.info_id = info.id AND link.data_id = data.id

CREATE TABLE `info` (
        `id` int(11) NOT NULL auto_increment,
        `name` varchar(255) default NULL,
        `desc` text default NULL,
        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `data` (
        `id` int(11) NOT NULL auto_increment,
        `date` date default NULL,
        `value` INT(11) default NULL,
        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `link` (
        `data_id` int(11) NOT NULL,
        `info_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;