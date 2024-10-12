
CREATE TABLE `test`
(
    `id`    int(11) NOT NULL AUTO_INCREMENT,
    `value` varchar(30) DEFAULT NULL,
    `int`   int(11) DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `test_detail`
(
    `pid`    int(11) DEFAULT NULL,
    `info`   text,
    `status` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `test_img`
(
    `id`      int(11) NOT NULL AUTO_INCREMENT,
    `test_id` int(11) DEFAULT NULL,
    `img_url` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY       `test_id_idx` (`test_id`),
    CONSTRAINT `test_id` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
