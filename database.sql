use catalog;

create table CATEGORY
(
   CATID                int not null  comment '',
   NAME                 varchar(20)  comment '',
   primary key (CATID)
);

create table PRODUCT
(
   PRODUCTID            int not null  comment '',
   PRODNAME             varchar(20)  comment '',
   PRICE                bigint  comment '',
   primary key (PRODUCTID)
);

create table USERS
(
   USERNAME            varchar(20) not null  comment '',
   PASSWORD             varchar(20)  comment '',
  
   primary key (USERNAME)
);


create table COLLECTION
(
   PRODUCTID            int not null  comment '',
   CATID                int not null  comment '',
   primary key (PRODUCTID, CATID)
);

alter table GROUP add constraint FK_COLLECTION_COLLECTION_PRODUCT foreign key (PRODUCTID)
      references PRODUCT (PRODUCTID) on delete restrict on update restrict;

alter table GROUP add constraint FK_COLLECTION_RELATIONS_CATEGORY foreign key (CATID)
      references CATEGORY (CATID) on delete restrict on update restrict;

