CREATE TABLE public.cars (
     id serial NOT NULL,
     model_name varchar(100) NULL,
     model_type varchar(100) NULL,
     model_brand varchar(100) NULL,
     model_year varchar(4) NULL,
     model_date_added timestamp NULL,
     model_date_modified timestamp NULL DEFAULT CURRENT_TIMESTAMP,
     CONSTRAINT cars_pkey PRIMARY KEY (id)
);
