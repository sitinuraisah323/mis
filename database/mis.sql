PGDMP             
            x            mis    12.3    12.3 |    ?           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            ?           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            ?           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            ?           1262    16393    mis    DATABASE     ?   CREATE DATABASE mis WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE mis;
                postgres    false            ?            1259    16485    areas    TABLE     v  CREATE TABLE public.areas (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    area character varying(255) NOT NULL
);
    DROP TABLE public.areas;
       public         heap    postgres    false            ?           0    0    COLUMN areas.status    COMMENT     Y   COMMENT ON COLUMN public.areas.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    215            ?            1259    16483    areas_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.areas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.areas_id_seq;
       public          postgres    false    215            ?           0    0    areas_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.areas_id_seq OWNED BY public.areas.id;
          public          postgres    false    214            ?            1259    16534 	   customers    TABLE     ?  CREATE TABLE public.customers (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    no_cif character varying(255) NOT NULL,
    nik character varying(255) NOT NULL,
    name character varying(255),
    birth_date date NOT NULL,
    birth_place character varying(255) NOT NULL,
    gender character varying(255) DEFAULT 'UNKNOWN'::character varying NOT NULL,
    marital character varying(255) DEFAULT 'UNKNOWN'::character varying NOT NULL,
    address text,
    city character varying(255),
    province character varying(255),
    job character varying(255),
    citizenship character varying(255),
    mother_name character varying(255) NOT NULL,
    sibling_name character varying(255) NOT NULL,
    sibling_birth_date date NOT NULL,
    sibling_birth_place character varying(255) NOT NULL,
    sibling_address text NOT NULL,
    sibling_job character varying(255) NOT NULL,
    sibling_relation character varying(255)
);
    DROP TABLE public.customers;
       public         heap    postgres    false            ?           0    0    COLUMN customers.status    COMMENT     ]   COMMENT ON COLUMN public.customers.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    223            ?           0    0    COLUMN customers.gender    COMMENT     F   COMMENT ON COLUMN public.customers.gender IS 'MALE
FEMALE
UNKNOWN';
          public          postgres    false    223            ?           0    0    COLUMN customers.marital    COMMENT     U   COMMENT ON COLUMN public.customers.marital IS 'MARRIED
DISVORCED
SINGLE
UNKNOWN';
          public          postgres    false    223            ?            1259    16532    customers_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.customers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.customers_id_seq;
       public          postgres    false    223            ?           0    0    customers_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.customers_id_seq OWNED BY public.customers.id;
          public          postgres    false    222            ?            1259    16420 	   employees    TABLE     L  CREATE TABLE public.employees (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    nik integer NOT NULL,
    fullname character varying(255) NOT NULL,
    birth_date date NOT NULL,
    birth_place character varying(255) NOT NULL,
    gender character varying(255) DEFAULT 'UNKNOWN'::character varying NOT NULL,
    mobile character varying(255) NOT NULL,
    marital character varying DEFAULT 'UNKNOWN'::character varying,
    blood_group character varying(255) DEFAULT 'UNKNOWN'::character varying,
    address text,
    "position" character varying(255),
    id_unit integer NOT NULL
);
    DROP TABLE public.employees;
       public         heap    postgres    false            ?           0    0    COLUMN employees.status    COMMENT     _   COMMENT ON COLUMN public.employees.status IS 'PUBLISH
UNPUBLISH
DRAFT
DELETED
ARCHIVED
';
          public          postgres    false    205            ?           0    0    COLUMN employees.gender    COMMENT     F   COMMENT ON COLUMN public.employees.gender IS 'MALE
FEMALE
UNKNOWN';
          public          postgres    false    205            ?           0    0    COLUMN employees.marital    COMMENT     M   COMMENT ON COLUMN public.employees.marital IS 'MARRIED
DIVORCED
SINGLE
';
          public          postgres    false    205            ?           0    0    COLUMN employees.blood_group    COMMENT     V   COMMENT ON COLUMN public.employees.blood_group IS '+A
+B
+AB
+O
-A
-B
-AB
-B';
          public          postgres    false    205            ?            1259    16396    master    TABLE     M  CREATE TABLE public.master (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer
);
    DROP TABLE public.master;
       public         heap    postgres    false            ?           0    0    COLUMN master.status    COMMENT     Z   COMMENT ON COLUMN public.master.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    203            ?            1259    16394    employees_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.employees_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.employees_id_seq;
       public          postgres    false    203            ?           0    0    employees_id_seq    SEQUENCE OWNED BY     B   ALTER SEQUENCE public.employees_id_seq OWNED BY public.master.id;
          public          postgres    false    202            ?            1259    16418    employees_id_seq1    SEQUENCE     ?   CREATE SEQUENCE public.employees_id_seq1
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.employees_id_seq1;
       public          postgres    false    205            ?           0    0    employees_id_seq1    SEQUENCE OWNED BY     F   ALTER SEQUENCE public.employees_id_seq1 OWNED BY public.employees.id;
          public          postgres    false    204            ?            1259    16472    levels_privileges    TABLE     ?  CREATE TABLE public.levels_privileges (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_level integer NOT NULL,
    id_menu integer NOT NULL,
    can_access character varying(255) DEFAULT 'DENIED'::character varying NOT NULL
);
 %   DROP TABLE public.levels_privileges;
       public         heap    postgres    false            ?           0    0    COLUMN levels_privileges.status    COMMENT     e   COMMENT ON COLUMN public.levels_privileges.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    213            ?           0    0 #   COLUMN levels_privileges.can_access    COMMENT     P   COMMENT ON COLUMN public.levels_privileges.can_access IS 'READ
WRITE
DENIED';
          public          postgres    false    213            ?            1259    16470    level_privileges_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.level_privileges_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.level_privileges_id_seq;
       public          postgres    false    213            ?           0    0    level_privileges_id_seq    SEQUENCE OWNED BY     T   ALTER SEQUENCE public.level_privileges_id_seq OWNED BY public.levels_privileges.id;
          public          postgres    false    212            ?            1259    16447    levels    TABLE     x  CREATE TABLE public.levels (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    level character varying(255) NOT NULL
);
    DROP TABLE public.levels;
       public         heap    postgres    false            ?           0    0    COLUMN levels.status    COMMENT     Z   COMMENT ON COLUMN public.levels.status IS 'PUBLISH
UNPUBLISH
DRAFT
ARCHIVED
DELETED';
          public          postgres    false    209            ?            1259    16445    levels_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.levels_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.levels_id_seq;
       public          postgres    false    209            ?           0    0    levels_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.levels_id_seq OWNED BY public.levels.id;
          public          postgres    false    208            ?            1259    16459    menus    TABLE     ?  CREATE TABLE public.menus (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_parent integer DEFAULT 0 NOT NULL,
    name character varying(255) NOT NULL
);
    DROP TABLE public.menus;
       public         heap    postgres    false            ?           0    0    COLUMN menus.status    COMMENT     R   COMMENT ON COLUMN public.menus.status IS 'PUBLISH
UNPUBLISH
DELETED
ARCHIVED';
          public          postgres    false    211            ?            1259    16457    menus_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.menus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.menus_id_seq;
       public          postgres    false    211            ?           0    0    menus_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;
          public          postgres    false    210            ?            1259    16522    stle    TABLE     ?  CREATE TABLE public.stle (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    date_start date NOT NULL,
    date_end date NOT NULL,
    day_distance integer NOT NULL,
    amount real NOT NULL
);
    DROP TABLE public.stle;
       public         heap    postgres    false            ?           0    0    COLUMN stle.status    COMMENT     X   COMMENT ON COLUMN public.stle.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    221            ?            1259    16520    stle_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.stle_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.stle_id_seq;
       public          postgres    false    221            ?           0    0    stle_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.stle_id_seq OWNED BY public.stle.id;
          public          postgres    false    220            ?            1259    16497    units    TABLE     ?  CREATE TABLE public.units (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_area integer NOT NULL,
    code character varying(255) NOT NULL,
    name character varying(255) NOT NULL
);
    DROP TABLE public.units;
       public         heap    postgres    false            ?           0    0    COLUMN units.status    COMMENT     Y   COMMENT ON COLUMN public.units.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    217            ?            1259    16548    units_dailycashs    TABLE     ;  CREATE TABLE public.units_dailycashs (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_unit integer NOT NULL,
    date date NOT NULL,
    description text NOT NULL,
    cash_code character varying(255) NOT NULL,
    amount real NOT NULL,
    type character varying(255) DEFAULT 'CASH_IN'::character varying
);
 $   DROP TABLE public.units_dailycashs;
       public         heap    postgres    false            ?           0    0    COLUMN units_dailycashs.status    COMMENT     d   COMMENT ON COLUMN public.units_dailycashs.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    225            ?           0    0    COLUMN units_dailycashs.type    COMMENT     G   COMMENT ON COLUMN public.units_dailycashs.type IS 'CASH_IN
CASH_OUT';
          public          postgres    false    225            ?            1259    16495    units_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.units_id_seq;
       public          postgres    false    217            ?           0    0    units_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.units_id_seq OWNED BY public.units.id;
          public          postgres    false    216            ?            1259    16605    units_loaninstallments    TABLE     ?  CREATE TABLE public.units_loaninstallments (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    no_sbk character varying(255) NOT NULL,
    id_customer integer DEFAULT 0 NOT NULL,
    date_sbk date NOT NULL,
    date_repayment date NOT NULL,
    money_loan real DEFAULT 0 NOT NULL,
    periode integer NOT NULL,
    capital_lease real DEFAULT 0 NOT NULL,
    description_1 text,
    description_2 text,
    description_3 text,
    description_4 text
);
 *   DROP TABLE public.units_loaninstallments;
       public         heap    postgres    false            ?           0    0 $   COLUMN units_loaninstallments.status    COMMENT     j   COMMENT ON COLUMN public.units_loaninstallments.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    233            ?            1259    16603    units_loaninstallments_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_loaninstallments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.units_loaninstallments_id_seq;
       public          postgres    false    233            ?           0    0    units_loaninstallments_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.units_loaninstallments_id_seq OWNED BY public.units_loaninstallments.id;
          public          postgres    false    232            ?            1259    16573    units_mortages    TABLE     ?  CREATE TABLE public.units_mortages (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    no_sbk character varying(255) NOT NULL,
    nic character varying(255) NOT NULL,
    id_customer integer NOT NULL,
    date_sbk date NOT NULL,
    deadline date NOT NULL,
    date_auction date NOT NULL,
    estimation real DEFAULT 0 NOT NULL,
    amout_loan real DEFAULT 0 NOT NULL,
    amount_admin real NOT NULL,
    capital_lease double precision DEFAULT 0 NOT NULL,
    periode integer DEFAULT 0 NOT NULL,
    installment integer DEFAULT 0 NOT NULL,
    interest real DEFAULT 0 NOT NULL,
    status_transaction character varying(255) NOT NULL,
    description_1 text,
    description_2 text NOT NULL,
    description_3 text NOT NULL,
    description_4 text NOT NULL
);
 "   DROP TABLE public.units_mortages;
       public         heap    postgres    false            ?           0    0    COLUMN units_mortages.status    COMMENT     b   COMMENT ON COLUMN public.units_mortages.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    229            ?            1259    16571    units_mortages_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_mortages_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.units_mortages_id_seq;
       public          postgres    false    229            ?           0    0    units_mortages_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.units_mortages_id_seq OWNED BY public.units_mortages.id;
          public          postgres    false    228            ?            1259    16561    units_regularpawns    TABLE     p  CREATE TABLE public.units_regularpawns (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    no_sbk character varying(255) NOT NULL,
    nic character varying(255),
    id_customer integer NOT NULL,
    date_sbk date NOT NULL,
    deadline date NOT NULL,
    amount real NOT NULL,
    date_auction date NOT NULL,
    estimation real NOT NULL,
    admin real NOT NULL
);
 &   DROP TABLE public.units_regularpawns;
       public         heap    postgres    false                        0    0     COLUMN units_regularpawns.status    COMMENT     f   COMMENT ON COLUMN public.units_regularpawns.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    227            ?            1259    16559    units_regular_pawns_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_regular_pawns_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.units_regular_pawns_id_seq;
       public          postgres    false    227                       0    0    units_regular_pawns_id_seq    SEQUENCE OWNED BY     X   ALTER SEQUENCE public.units_regular_pawns_id_seq OWNED BY public.units_regularpawns.id;
          public          postgres    false    226            ?            1259    16591    units_repayments    TABLE     ?  CREATE TABLE public.units_repayments (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    no_sbk character varying(255) NOT NULL,
    id_customer integer NOT NULL,
    date_sbk date NOT NULL,
    date_repayment date NOT NULL,
    money_loan real DEFAULT 0 NOT NULL,
    periode integer NOT NULL,
    capital_lease real DEFAULT 0 NOT NULL,
    status_transaction character varying(255) NOT NULL,
    description_1 text,
    description_2 text NOT NULL,
    description_3 text,
    description_4 text
);
 $   DROP TABLE public.units_repayments;
       public         heap    postgres    false                       0    0    COLUMN units_repayments.status    COMMENT     d   COMMENT ON COLUMN public.units_repayments.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    231            ?            1259    16589    units_repayments_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_repayments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.units_repayments_id_seq;
       public          postgres    false    231                       0    0    units_repayments_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.units_repayments_id_seq OWNED BY public.units_repayments.id;
          public          postgres    false    230            ?            1259    16510    units_targets    TABLE     ?  CREATE TABLE public.units_targets (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_unit integer NOT NULL,
    month integer NOT NULL,
    year integer NOT NULL,
    amount real NOT NULL
);
 !   DROP TABLE public.units_targets;
       public         heap    postgres    false                       0    0    COLUMN units_targets.status    COMMENT     a   COMMENT ON COLUMN public.units_targets.status IS 'PUBLISH
UNPUBLISH
ARCHIVED
DELETED
DRAFT';
          public          postgres    false    219            ?            1259    16508    units_targets_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_targets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.units_targets_id_seq;
       public          postgres    false    219                       0    0    units_targets_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.units_targets_id_seq OWNED BY public.units_targets.id;
          public          postgres    false    218            ?            1259    16546    units_trasactions_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.units_trasactions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.units_trasactions_id_seq;
       public          postgres    false    225                       0    0    units_trasactions_id_seq    SEQUENCE OWNED BY     T   ALTER SEQUENCE public.units_trasactions_id_seq OWNED BY public.units_dailycashs.id;
          public          postgres    false    224            ?            1259    16435    users    TABLE     ?  CREATE TABLE public.users (
    id integer NOT NULL,
    status character varying DEFAULT 'PUBLISH'::character varying,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_create integer,
    user_update integer,
    id_employee integer NOT NULL,
    id_level integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL
);
    DROP TABLE public.users;
       public         heap    postgres    false                       0    0    COLUMN users.status    COMMENT     Y   COMMENT ON COLUMN public.users.status IS 'PUBLISH
UNPUBLISH
DRAFT
ARCHIVED
DELETED';
          public          postgres    false    207            ?            1259    16433    users_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    207                       0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    206                       2604    16488    areas id    DEFAULT     d   ALTER TABLE ONLY public.areas ALTER COLUMN id SET DEFAULT nextval('public.areas_id_seq'::regclass);
 7   ALTER TABLE public.areas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    214    215    215                       2604    16537    customers id    DEFAULT     l   ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.customers_id_seq'::regclass);
 ;   ALTER TABLE public.customers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222    223            ?
           2604    16423    employees id    DEFAULT     m   ALTER TABLE ONLY public.employees ALTER COLUMN id SET DEFAULT nextval('public.employees_id_seq1'::regclass);
 ;   ALTER TABLE public.employees ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    205    204    205            ?
           2604    16450 	   levels id    DEFAULT     f   ALTER TABLE ONLY public.levels ALTER COLUMN id SET DEFAULT nextval('public.levels_id_seq'::regclass);
 8   ALTER TABLE public.levels ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    208    209    209                       2604    16475    levels_privileges id    DEFAULT     {   ALTER TABLE ONLY public.levels_privileges ALTER COLUMN id SET DEFAULT nextval('public.level_privileges_id_seq'::regclass);
 C   ALTER TABLE public.levels_privileges ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    213    213            ?
           2604    16405 	   master id    DEFAULT     i   ALTER TABLE ONLY public.master ALTER COLUMN id SET DEFAULT nextval('public.employees_id_seq'::regclass);
 8   ALTER TABLE public.master ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    203    202    203            ?
           2604    16462    menus id    DEFAULT     d   ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);
 7   ALTER TABLE public.menus ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    211    210    211                       2604    16525    stle id    DEFAULT     b   ALTER TABLE ONLY public.stle ALTER COLUMN id SET DEFAULT nextval('public.stle_id_seq'::regclass);
 6   ALTER TABLE public.stle ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    220    221            
           2604    16500    units id    DEFAULT     d   ALTER TABLE ONLY public.units ALTER COLUMN id SET DEFAULT nextval('public.units_id_seq'::regclass);
 7   ALTER TABLE public.units ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    217    217                       2604    16551    units_dailycashs id    DEFAULT     {   ALTER TABLE ONLY public.units_dailycashs ALTER COLUMN id SET DEFAULT nextval('public.units_trasactions_id_seq'::regclass);
 B   ALTER TABLE public.units_dailycashs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    224    225            5           2604    16608    units_loaninstallments id    DEFAULT     ?   ALTER TABLE ONLY public.units_loaninstallments ALTER COLUMN id SET DEFAULT nextval('public.units_loaninstallments_id_seq'::regclass);
 H   ALTER TABLE public.units_loaninstallments ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    232    233    233            %           2604    16576    units_mortages id    DEFAULT     v   ALTER TABLE ONLY public.units_mortages ALTER COLUMN id SET DEFAULT nextval('public.units_mortages_id_seq'::regclass);
 @   ALTER TABLE public.units_mortages ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    228    229    229            !           2604    16564    units_regularpawns id    DEFAULT        ALTER TABLE ONLY public.units_regularpawns ALTER COLUMN id SET DEFAULT nextval('public.units_regular_pawns_id_seq'::regclass);
 D   ALTER TABLE public.units_regularpawns ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    226    227            1           2604    16594    units_repayments id    DEFAULT     z   ALTER TABLE ONLY public.units_repayments ALTER COLUMN id SET DEFAULT nextval('public.units_repayments_id_seq'::regclass);
 B   ALTER TABLE public.units_repayments ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    231    230    231                       2604    16513    units_targets id    DEFAULT     t   ALTER TABLE ONLY public.units_targets ALTER COLUMN id SET DEFAULT nextval('public.units_targets_id_seq'::regclass);
 ?   ALTER TABLE public.units_targets ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    218    219            ?
           2604    16438    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    206    207    207            ?          0    16485    areas 
   TABLE DATA           e   COPY public.areas (id, status, date_create, date_update, user_create, user_update, area) FROM stdin;
    public          postgres    false    215   \?       ?          0    16534 	   customers 
   TABLE DATA           ?  COPY public.customers (id, status, date_create, date_update, user_create, user_update, no_cif, nik, name, birth_date, birth_place, gender, marital, address, city, province, job, citizenship, mother_name, sibling_name, sibling_birth_date, sibling_birth_place, sibling_address, sibling_job, sibling_relation) FROM stdin;
    public          postgres    false    223   y?       ?          0    16420 	   employees 
   TABLE DATA           ?   COPY public.employees (id, status, date_create, date_update, user_create, user_update, nik, fullname, birth_date, birth_place, gender, mobile, marital, blood_group, address, "position", id_unit) FROM stdin;
    public          postgres    false    205   ??       ?          0    16447    levels 
   TABLE DATA           g   COPY public.levels (id, status, date_create, date_update, user_create, user_update, level) FROM stdin;
    public          postgres    false    209   ??       ?          0    16472    levels_privileges 
   TABLE DATA           ?   COPY public.levels_privileges (id, status, date_create, date_update, user_create, user_update, id_level, id_menu, can_access) FROM stdin;
    public          postgres    false    213   Т       ?          0    16396    master 
   TABLE DATA           `   COPY public.master (id, status, date_create, date_update, user_create, user_update) FROM stdin;
    public          postgres    false    203   ??       ?          0    16459    menus 
   TABLE DATA           p   COPY public.menus (id, status, date_create, date_update, user_create, user_update, id_parent, name) FROM stdin;
    public          postgres    false    211   3?       ?          0    16522    stle 
   TABLE DATA           ?   COPY public.stle (id, status, date_create, date_update, user_create, user_update, date_start, date_end, day_distance, amount) FROM stdin;
    public          postgres    false    221   P?       ?          0    16497    units 
   TABLE DATA           t   COPY public.units (id, status, date_create, date_update, user_create, user_update, id_area, code, name) FROM stdin;
    public          postgres    false    217   m?       ?          0    16548    units_dailycashs 
   TABLE DATA           ?   COPY public.units_dailycashs (id, status, date_create, date_update, user_create, user_update, id_unit, date, description, cash_code, amount, type) FROM stdin;
    public          postgres    false    225   ??       ?          0    16605    units_loaninstallments 
   TABLE DATA           ?   COPY public.units_loaninstallments (id, status, date_create, date_update, user_create, user_update, no_sbk, id_customer, date_sbk, date_repayment, money_loan, periode, capital_lease, description_1, description_2, description_3, description_4) FROM stdin;
    public          postgres    false    233   ??       ?          0    16573    units_mortages 
   TABLE DATA           I  COPY public.units_mortages (id, status, date_create, date_update, user_create, user_update, no_sbk, nic, id_customer, date_sbk, deadline, date_auction, estimation, amout_loan, amount_admin, capital_lease, periode, installment, interest, status_transaction, description_1, description_2, description_3, description_4) FROM stdin;
    public          postgres    false    229   ģ       ?          0    16561    units_regularpawns 
   TABLE DATA           ?   COPY public.units_regularpawns (id, status, date_create, date_update, user_create, user_update, no_sbk, nic, id_customer, date_sbk, deadline, amount, date_auction, estimation, admin) FROM stdin;
    public          postgres    false    227   ??       ?          0    16591    units_repayments 
   TABLE DATA             COPY public.units_repayments (id, status, date_create, date_update, user_create, user_update, no_sbk, id_customer, date_sbk, date_repayment, money_loan, periode, capital_lease, status_transaction, description_1, description_2, description_3, description_4) FROM stdin;
    public          postgres    false    231   ??       ?          0    16510    units_targets 
   TABLE DATA           ?   COPY public.units_targets (id, status, date_create, date_update, user_create, user_update, id_unit, month, year, amount) FROM stdin;
    public          postgres    false    219   ?       ?          0    16435    users 
   TABLE DATA           ?   COPY public.users (id, status, date_create, date_update, user_create, user_update, id_employee, id_level, username, password) FROM stdin;
    public          postgres    false    207   8?       	           0    0    areas_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.areas_id_seq', 1, false);
          public          postgres    false    214            
           0    0    customers_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.customers_id_seq', 1, false);
          public          postgres    false    222                       0    0    employees_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.employees_id_seq', 1, true);
          public          postgres    false    202                       0    0    employees_id_seq1    SEQUENCE SET     @   SELECT pg_catalog.setval('public.employees_id_seq1', 1, false);
          public          postgres    false    204                       0    0    level_privileges_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.level_privileges_id_seq', 1, false);
          public          postgres    false    212                       0    0    levels_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.levels_id_seq', 1, false);
          public          postgres    false    208                       0    0    menus_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.menus_id_seq', 1, false);
          public          postgres    false    210                       0    0    stle_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.stle_id_seq', 1, false);
          public          postgres    false    220                       0    0    units_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.units_id_seq', 1, false);
          public          postgres    false    216                       0    0    units_loaninstallments_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.units_loaninstallments_id_seq', 1, false);
          public          postgres    false    232                       0    0    units_mortages_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.units_mortages_id_seq', 1, false);
          public          postgres    false    228                       0    0    units_regular_pawns_id_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.units_regular_pawns_id_seq', 1, false);
          public          postgres    false    226                       0    0    units_repayments_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.units_repayments_id_seq', 1, false);
          public          postgres    false    230                       0    0    units_targets_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.units_targets_id_seq', 1, false);
          public          postgres    false    218                       0    0    units_trasactions_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.units_trasactions_id_seq', 1, false);
          public          postgres    false    224                       0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 1, false);
          public          postgres    false    206            =           2606    16407    master employees_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.master
    ADD CONSTRAINT employees_pkey PRIMARY KEY (id);
 ?   ALTER TABLE ONLY public.master DROP CONSTRAINT employees_pkey;
       public            postgres    false    203            ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?   6   x?3?t	rt?4202?50?5?T0??26?26?3?0532?&?i?i????? ???      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?      ?      x?????? ? ?     