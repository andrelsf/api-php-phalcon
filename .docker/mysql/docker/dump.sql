create table robotics.robots (
 id    int(10)      unsigned         not null auto_increment,
 name  varchar(200) collate utf8_bin not null,
 type  varchar(20)  collate utf8_bin not null,
 year  smallint(4)  unsigned         not null,
 PRIMARY KEY (id)
);