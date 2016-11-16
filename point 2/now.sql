SELECT data.date, data.value, info.name, info.desc   FROM data,link,info WHERE link.info_id = info.id AND link.data_id = data.id

CREATE TABLE `info` (
        `id` int(11) NOT NULL auto_increment,
        `name` varchar(255) default NULL,
        `desc` text default NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `data` (
        `id` int(11) NOT NULL auto_increment,
        `date` date default NULL,
        `value` INT(11) default NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `link` (
        `info_id` int(11) NOT NULL,
        `data_id` int(11) NOT NULL,
        FOREIGN KEY (info_id) REFERENCES info(id)
          ON UPDATE RESTRICT
          ON DELETE CASCADE,
        FOREIGN KEY (data_id) REFERENCES data(id)
          ON UPDATE RESTRICT
          ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;