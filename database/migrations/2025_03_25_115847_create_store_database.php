<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
		--
-- PostgreSQL database dump
--

-- Dumped from database version 13.17 (Debian 13.17-1.pgdg110+1)
-- Dumped by pg_dump version 13.17 (Debian 13.17-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: db; Type: SCHEMA; Schema: -; Owner: check_avtovo
--

CREATE SCHEMA db;


ALTER SCHEMA db OWNER TO check_avtovo;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: bus_models; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.bus_models (
    id integer,
    transporter character varying(255),
    transporter_id integer,
    bus_model character varying(150),
    driver character varying(200),
    driver_id integer,
    bus_number character varying(64),
    status smallint DEFAULT 1,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE db.bus_models OWNER TO check_avtovo;

--
-- Name: carriers; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.carriers (
    id integer NOT NULL,
    name character varying(255),
    bank_name character varying(255),
    mfo character varying(128),
    bank_account character varying(128),
    phone character varying(64),
    percent double precision,
    baggage_percent double precision,
    deleted_at character varying(128),
    inn character varying(64),
    vat_percent character varying(64),
    class_code character varying(64),
    package_code character varying(64),
    ipay_vendor_id character varying(64),
    status smallint DEFAULT 1,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE db.carriers OWNER TO check_avtovo;

--
-- Name: director; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.director (
    id integer NOT NULL,
    staff_id integer,
    org_id integer,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    document_id integer,
    given_date date,
    json_info character varying(255)
);


ALTER TABLE db.director OWNER TO check_avtovo;

--
-- Name: director_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.director_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.director_id_seq OWNER TO check_avtovo;

--
-- Name: director_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.director_id_seq OWNED BY db.director.id;


--
-- Name: dispatcher; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.dispatcher (
    id integer NOT NULL,
    staff_id integer,
    org_id integer,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    document_id integer,
    given_date date,
    json_info character varying(255)
);


ALTER TABLE db.dispatcher OWNER TO check_avtovo;

--
-- Name: dispatcher_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.dispatcher_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.dispatcher_id_seq OWNER TO check_avtovo;

--
-- Name: dispatcher_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.dispatcher_id_seq OWNED BY db.dispatcher.id;


--
-- Name: document; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.document (
    id integer NOT NULL,
    guid_id character varying(64),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    time_flight timestamp without time zone,
    table_flight_id integer,
    json_info character varying(255),
    sold_seats_count integer,
    seats_count integer,
    table_time_flight timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE db.document OWNER TO check_avtovo;

--
-- Name: document_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.document_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.document_id_seq OWNER TO check_avtovo;

--
-- Name: drivers; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.drivers (
    id integer NOT NULL,
    name_uz character varying(128),
    name_oz character varying(128),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    numserial character varying(32),
    json_info character varying(255),
    sort smallint
);


ALTER TABLE db.drivers OWNER TO check_avtovo;

--
-- Name: drivers_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.drivers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.drivers_id_seq OWNER TO check_avtovo;

--
-- Name: drivers_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.drivers_id_seq OWNED BY db.drivers.id;


--
-- Name: flights; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.flights (
    id integer NOT NULL,
    number character varying(64),
    name_uz character varying(255),
    comment text,
    deleted_at character varying(128),
    name_oz character varying(255),
    name_en character varying(255),
    deleted_by character varying(128),
    is_international boolean,
    distance integer,
    name_ru character varying(255),
    status smallint DEFAULT 1,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    num_drivers smallint,
    table_flight_id integer,
    json_info character varying(255)
);


ALTER TABLE db.flights OWNER TO check_avtovo;

--
-- Name: medical; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.medical (
    id integer NOT NULL,
    time_med_exam date,
    time_begin timestamp without time zone,
    time_end timestamp without time zone,
    org_id smallint,
    staff_id smallint,
    temperature real,
    pulse real,
    bpressure_begin smallint,
    bpressure_end smallint,
    diagnostic character varying(150),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status smallint,
    document_id integer NOT NULL,
    given_date date,
    driver_id integer,
    comment character varying(1000),
    json_info character varying(255)
);


ALTER TABLE db.medical OWNER TO check_avtovo;

--
-- Name: medical_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.medical_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.medical_id_seq OWNER TO check_avtovo;

--
-- Name: medical_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.medical_id_seq OWNED BY db.medical.id;


--
-- Name: old_api_dispatcher_view; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.old_api_dispatcher_view (
    id integer,
    status integer,
    name text,
    platform text,
    bus_driver text,
    bus_mark text,
    bus_number text,
    amount integer,
    terminal_amount integer,
    online_amount integer,
    passengers integer,
    baggage integer,
    route_id integer,
    eta text,
    atd text,
    transporter_name text,
    transporter_id integer
);


ALTER TABLE db.old_api_dispatcher_view OWNER TO check_avtovo;

--
-- Name: old_api_drivers; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.old_api_drivers (
    id integer,
    name text,
    email text,
    deleted_at text,
    type integer,
    status integer,
    phone text,
    api_token text,
    verified_phone text,
    verified text
);


ALTER TABLE db.old_api_drivers OWNER TO check_avtovo;

--
-- Name: old_api_stations; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.old_api_stations (
    id integer,
    location_id integer,
    name text,
    address text,
    locality text,
    landmark text,
    type text,
    status integer,
    name_uz text,
    name_en text,
    deleted_by text,
    api_status integer,
    code text
);


ALTER TABLE db.old_api_stations OWNER TO check_avtovo;

--
-- Name: orgs; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.orgs (
    id integer NOT NULL,
    name_uz character varying(255),
    name_oz character varying(255),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    json_info character varying(255)
);


ALTER TABLE db.orgs OWNER TO check_avtovo;

--
-- Name: orgs_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.orgs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.orgs_id_seq OWNER TO check_avtovo;

--
-- Name: orgs_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.orgs_id_seq OWNED BY db.orgs.id;


--
-- Name: roles; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.roles (
    id integer NOT NULL,
    name_uz character varying(64),
    name_oz character varying(64),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint,
    name character varying(64),
    json_info character varying(255)
);


ALTER TABLE db.roles OWNER TO check_avtovo;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.roles_id_seq OWNER TO check_avtovo;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.roles_id_seq OWNED BY db.roles.id;


--
-- Name: statuses_list; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.statuses_list (
    id integer NOT NULL,
    name character varying(128),
    status smallint DEFAULT 1,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE db.statuses_list OWNER TO check_avtovo;

--
-- Name: statuses_list_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.statuses_list_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.statuses_list_id_seq OWNER TO check_avtovo;

--
-- Name: statuses_list_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.statuses_list_id_seq OWNED BY db.statuses_list.id;


--
-- Name: table_flights; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.table_flights (
    id integer NOT NULL,
    table_time_flight timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    json_info character varying(255)
);


ALTER TABLE db.table_flights OWNER TO check_avtovo;

--
-- Name: table_times_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.table_times_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.table_times_id_seq OWNER TO check_avtovo;

--
-- Name: table_times_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.table_times_id_seq OWNED BY db.table_flights.id;


--
-- Name: technical; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.technical (
    id integer NOT NULL,
    govnumber character varying(20),
    flight_from smallint,
    flight_to smallint,
    vmodel_id smallint,
    org_id smallint,
    staff_id smallint,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1,
    document_id integer NOT NULL,
    flight_id smallint,
    given_date date,
    comment character varying(1000),
    driver_id character varying(32),
    json_info character varying(255),
    carrier_id integer,
    vmodel_name character varying(128),
    vehicle_id integer,
    flight_name_uz character varying(255),
    carrier_name character varying(255)
);


ALTER TABLE db.technical OWNER TO check_avtovo;

--
-- Name: TABLE technical; Type: COMMENT; Schema: db; Owner: check_avtovo
--

COMMENT ON TABLE db.technical IS 'Texosmotr';


--
-- Name: technical_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.technical_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.technical_id_seq OWNER TO check_avtovo;

--
-- Name: users; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.users (
    id integer NOT NULL,
    name_uz character varying(200),
    name_oz character varying(200),
    role_id smallint,
    org_id smallint,
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status smallint DEFAULT 1,
    username character varying(64),
    password character varying(64),
    json_info character varying(255),
    post_name_uz character(200),
    post_name_oz character(200)
);


ALTER TABLE db.users OWNER TO check_avtovo;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.users_id_seq OWNER TO check_avtovo;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.users_id_seq OWNED BY db.users.id;


--
-- Name: vmodels; Type: TABLE; Schema: db; Owner: check_avtovo
--

CREATE TABLE db.vmodels (
    id integer NOT NULL,
    name character varying(255),
    created_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status smallint DEFAULT 1
);


ALTER TABLE db.vmodels OWNER TO check_avtovo;

--
-- Name: vmodels_id_seq; Type: SEQUENCE; Schema: db; Owner: check_avtovo
--

CREATE SEQUENCE db.vmodels_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE db.vmodels_id_seq OWNER TO check_avtovo;

--
-- Name: vmodels_id_seq; Type: SEQUENCE OWNED BY; Schema: db; Owner: check_avtovo
--

ALTER SEQUENCE db.vmodels_id_seq OWNED BY db.vmodels.id;


--
-- Name: director id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.director ALTER COLUMN id SET DEFAULT nextval('db.director_id_seq'::regclass);


--
-- Name: dispatcher id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.dispatcher ALTER COLUMN id SET DEFAULT nextval('db.dispatcher_id_seq'::regclass);


--
-- Name: drivers id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.drivers ALTER COLUMN id SET DEFAULT nextval('db.drivers_id_seq'::regclass);


--
-- Name: medical id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.medical ALTER COLUMN id SET DEFAULT nextval('db.medical_id_seq'::regclass);


--
-- Name: orgs id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.orgs ALTER COLUMN id SET DEFAULT nextval('db.orgs_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.roles ALTER COLUMN id SET DEFAULT nextval('db.roles_id_seq'::regclass);


--
-- Name: statuses_list id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.statuses_list ALTER COLUMN id SET DEFAULT nextval('db.statuses_list_id_seq'::regclass);


--
-- Name: table_flights id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.table_flights ALTER COLUMN id SET DEFAULT nextval('db.table_times_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.users ALTER COLUMN id SET DEFAULT nextval('db.users_id_seq'::regclass);


--
-- Name: vmodels id; Type: DEFAULT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.vmodels ALTER COLUMN id SET DEFAULT nextval('db.vmodels_id_seq'::regclass);


--
-- Name: carriers carriers_second_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.carriers
    ADD CONSTRAINT carriers_second_pk PRIMARY KEY (id);


--
-- Name: director director_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.director
    ADD CONSTRAINT director_pk PRIMARY KEY (id);


--
-- Name: dispatcher dispatcher_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.dispatcher
    ADD CONSTRAINT dispatcher_pk PRIMARY KEY (id);


--
-- Name: document document_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.document
    ADD CONSTRAINT document_pk PRIMARY KEY (id);


--
-- Name: drivers drivers_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.drivers
    ADD CONSTRAINT drivers_pk PRIMARY KEY (id);


--
-- Name: flights flights_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.flights
    ADD CONSTRAINT flights_pk PRIMARY KEY (id);


--
-- Name: medical medical_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.medical
    ADD CONSTRAINT medical_pk PRIMARY KEY (id);


--
-- Name: orgs orgs_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.orgs
    ADD CONSTRAINT orgs_pk PRIMARY KEY (id);


--
-- Name: roles roles_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.roles
    ADD CONSTRAINT roles_pk PRIMARY KEY (id);


--
-- Name: statuses_list statuses_list_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.statuses_list
    ADD CONSTRAINT statuses_list_pk PRIMARY KEY (id);


--
-- Name: table_flights table_flights_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.table_flights
    ADD CONSTRAINT table_flights_pk PRIMARY KEY (id);


--
-- Name: technical technical_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.technical
    ADD CONSTRAINT technical_pk PRIMARY KEY (id);


--
-- Name: users users_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- Name: vmodels vmodels_pk; Type: CONSTRAINT; Schema: db; Owner: check_avtovo
--

ALTER TABLE ONLY db.vmodels
    ADD CONSTRAINT vmodels_pk PRIMARY KEY (id);


--
-- Name: director set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.director FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: dispatcher set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.dispatcher FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: document set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.document FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: drivers set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.drivers FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: medical set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.medical FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: orgs set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.orgs FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: roles set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.roles FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: table_flights set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.table_flights FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: technical set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.technical FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- Name: users set_updated_time; Type: TRIGGER; Schema: db; Owner: check_avtovo
--

CREATE TRIGGER set_updated_time BEFORE UPDATE ON db.users FOR EACH ROW EXECUTE FUNCTION public.update_updated_time();


--
-- PostgreSQL database dump complete
--


		");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		DB::unprepared("
            DROP TABLE IF EXISTS technical;
            DROP TABLE IF EXISTS medical;
            DROP TABLE IF EXISTS dispatcher;
            DROP TABLE IF EXISTS director;
            DROP TABLE IF EXISTS users;
            DROP TABLE IF EXISTS roles;
            DROP TABLE IF EXISTS carriers;
            DROP TABLE IF EXISTS document;
            DROP TABLE IF EXISTS flights;
            DROP TABLE IF EXISTS drivers;
            DROP TABLE IF EXISTS bus_models;
            DROP TABLE IF EXISTS orgs;
            DROP TABLE IF EXISTS roles;
        ");
    }
};
