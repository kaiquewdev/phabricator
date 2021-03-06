ALTER TABLE phabricator_differential.differential_revision
  ADD mailKey VARCHAR(40) binary NOT NULL;

ALTER TABLE phabricator_maniphest.maniphest_task
  ADD mailKey VARCHAR(40) binary NOT NULL;

CREATE TABLE phabricator_metamta.metamta_receivedmail (
  id int unsigned not null primary key auto_increment,
  headers longblob not null,
  bodies longblob not null,
  attachments longblob not null,
  relatedPHID varchar(64) binary,
  key(relatedPHID),
  authorPHID varchar(64) binary,
  key(authorPHID),
  message longblob,
  dateCreated int unsigned not null,
  dateModified int unsigned not null
) engine=innodb;