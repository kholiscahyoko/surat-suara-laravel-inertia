<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),


    // custom config
    'menu' =>[
        'pemilu' => [
            "home" => [
                "name" => "Halaman Utama",
                "href" => "/pemilu"
            ],
            "pilkada" => [
                "name" => "Pilkada",
                "href" => "/pilkada",
                "highlight" => true
            ],
            "wilayah" => [
                "name" => "Wilayah",
                "href" => "/wilayah"
            ],
            "dapil" => [
                "name" => "Dapil",
                "href" => "/dapil"
            ],
            "calon" => [
                "name" => "Calon",
                "href" => "/calon"
            ],
            "cari" => [
                "name" => "Cari",
                "href" => "/cari"
            ],
        ],
        'pilkada' => [
            "home" => [
                "name" => "Halaman Utama",
                "href" => "/"
            ],
            "pemilu" => [
                "name" => "Pemilu",
                "href" => "/pemilu",
                "highlight" => true
            ],
            "wilayah" => [
                "name" => "Wilayah",
                "href" => "/pilkada/wilayah"
            ],
            "calon" => [
                "name" => "Calon",
                "href" => "/pilkada/calon"
            ],
            "cari" => [
                "name" => "Cari",
                "href" => "/cari"
            ],
        ]
    ],
    'meta' => [
        'home' => ["title" => "Website daftar calon legislatif terlengkap"],
        'cari' => ["title" => "Cari Nama Caleg, Calon Kepala Daerah, Wilayah, Daerah Pemilihan", "description" => "Temukan Nama Calon Legislatif, Kepala Daerah, Surat Suara, Wilayah, Daerah Pemilihan, Semuanya Disini"],
        'calon' => ["title" => "Cari Nama Calon Anggota Legislatif", "description" => "Temukan Nama Calon Legislatif Pilihanmu Disini"],
        'dapil' => ["title" => "Cari Berdasarkan Dapil", "description" => "Cari Surat Suara Berdasarkan Nama Daerah Pemilihan Disini, Pemilihan Calon Anggota Legislatif"],
        'wilayah' => ["title" => "Cari Surat Suara Pemilu Berdasarkan Wilayah", "description" => "Cari Surat Suara Pemilu 2024 Berdasarkan Wilayahmu Disini, Pemilihan Presiden dan Calon Anggota Legislatif"],
        'surat-suara' => [
            'pilpres' => ["title" => "Surat Suara Pemilu Capres dan Cawapres", "description" => "Surat Suara Pemilihan Umum Presiden dan Wakil Presiden Republik Indonesia Tahun 2024"],
            'dpd' => ["title" => "Surat Suara Pemilu Calon Dewan Perwakilan Daerah", "description" => "Surat Suara Pemilihan Umum Anggota Dewan Perwakilan Daerah Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil]"],
            'dpr' => ["title" => "Surat Suara Pemilu Calon Dewan Perwakilan Rakyat", "description" => "Surat Suara Pemilihan Umum Anggota Dewan Perwakilan Rakyat Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil]"],
            'dprdp' => ["title" => "Surat Suara Pemilu Calon Dewan Perwakilan Rakyat Daerah Provinsi", "description" => "Surat Suara Pemilihan Umum Anggota Dewan Perwakilan Rakyat Daerah Provinsi [nama_wilayah] Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil]"],
            'dprdk' => ["title" => "Surat Suara Pemilu Calon Dewan Perwakilan Rakyat Daerah Kabupaten Kota", "description" => "Surat Suara Pemilihan Umum Anggota Dewan Perwakilan Rakyat Daerah [nama_wilayah] Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil]"],
        ],
        'real-count' => [
            'pilpres' => ["title" => "Real Count Capres dan Cawapres", "description" => "Real Count Pemilihan Umum Presiden dan Wakil Presiden Republik Indonesia Tahun 2024"],
            'dpd' => ["title" => "Real Count Dewan Perwakilan Daerah", "description" => "Real Count Pemilihan Umum Anggota Dewan Perwakilan Daerah Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil] Cek Disini"],
            'dpr' => ["title" => "Real Count Dewan Perwakilan Rakyat", "description" => "Real Count Pemilihan Umum Anggota Dewan Perwakilan Rakyat Republik Indonesia Tahun 2024 Daerah Pemilihan [nama_dapil] Cek Disini"],
            'dprdp' => ["title" => "Real Count Dewan Perwakilan Rakyat Daerah Provinsi", "description" => "Real Count Pemilihan Umum Anggota Dewan Perwakilan Rakyat Daerah Provinsi [nama_wilayah] Tahun 2024 Daerah Pemilihan [nama_dapil] Cek Disini "],
            'dprdk' => ["title" => "Real Count Dewan Perwakilan Rakyat Daerah Kabupaten Kota", "description" => "Real Count Pemilihan Umum Anggota Dewan Perwakilan Rakyat Daerah [nama_wilayah] Tahun 2024 Daerah Pemilihan [nama_dapil] Cek Disini"],
        ],
        'calon-lolos' => [
            'home' => ["title" => "Website daftar calon kepala daerah terlengkap"],
            'dpd' => ["title" => "Calon Dewan Perwakilan Daerah Terpilih", "description" => "Ini Dia Daftar Calon Terpilih Pemilu DPD RI Provinsi [nama_dapil] Tahun 2024 Berdasarkan Perhitungan Sementara, Cek Disini"],
            'dpr' => ["title" => "Calon Dewan Perwakilan Rakyat Terpilih", "description" => "Ini Dia Daftar Cek Disini Calon Terpilih Pemilu DPR RI Tahun 2024 Daerah Pemilihan [nama_dapil] Berdasarkan Perhitungan Sementara, Cek Disini"],
            'dprdp' => ["title" => "Calon Dewan Perwakilan Rakyat Daerah Provinsi Terpilih", "description" => "Ini Dia Daftar Calon Terpilih Pemilu DPRD Provinsi [nama_wilayah] Tahun 2024 Daerah Pemilihan [nama_dapil] Berdasarkan Perhitungan Sementara, Cek Disini"],
            'dprdk' => ["title" => "Calon Perwakilan Rakyat Daerah Kabupaten Kota Terpilih", "description" => "Ini Dia Daftar Calon Terpilih Pemilu DPRD [nama_wilayah] Tahun 2024 Daerah Pemilihan [nama_dapil] Berdasarkan Perhitungan Sementara, Cek Disini"],
        ],
        'pilkada' => [
            'home' => ["title" => "Website daftar calon kepala daerah terlengkap"],
            'calon' => ["title" => "Cari Nama Calon Kepala Daerah", "description" => "Temukan Nama Calon Kepala Daerah Pilihanmu Disini"],
            'wilayah' => ["title" => "Cari Surat Suara Pilkada Berdasarkan Wilayah", "description" => "Cari Surat Suara Pilkada Seluruh Indonesia Berdasarkan Wilayahmu Disini"],
            'surat-suara' => [
                'gubernur' => ["title" => "Lihat Surat Suara Cagub dan Cawagub Pilkada [wilayah]", "description" => "Surat Suara Pilkada Gubernur dan Wakil Gubernur [wilayah] Tahun 2024 disini"],
                'walikota' => ["title" => "Lihat Surat Suara Cawalkot dan Cawawalkot Pilkada [wilayah]", "description" => "Surat Suara Pilkada Walikota dan Wakil Walikota [wilayah] Tahun 2024 disini"],
                'bupati' => ["title" => "Lihat Surat Suara Cabup dan Cawabup Pilkada [wilayah]", "description" => "Surat Suara Pilkada Bupati dan Wakil Bupati [wilayah] Tahun 2024 disini"],
            ],
            'realcount' => [
                'gubernur' => ["title" => "Lihat Realcount Pilkada [wilayah]", "description" => "Realcount Pilkada Gubernur dan Wakil Gubernur [wilayah] Tahun 2024 disini"],
                'walikota' => ["title" => "Lihat Realcount Pilkada [wilayah]", "description" => "Realcount Pilkada Walikota dan Wakil Walikota [wilayah] Tahun 2024 disini"],
                'bupati' => ["title" => "Lihat Realcount Pilkada [wilayah]", "description" => "Realcount Pilkada Bupati dan Wakil Bupati [wilayah] Tahun 2024 disini"],
            ],
            'profil-calon' => [
                "title" => "Profil [nama_calon]",
                "description" => "Profil Lengkap [nama_calon]. Tanggal Lahir, Alamat, Agama, Riwayat Pendidikan, Riwayat Organisasi Calon [title] [wilayah] Pemilihan Kepala Daerah Tahun 2024, Masa Bakti 2025 - 2029 disini"
            ],
            'pasangan-calon' => [
                "title" => "Pasangan [nama_paslon]",
                "description" => "Info Lengkap [nama_paslon], Visi Misi Calon [title] [wilayah] Pemilihan Kepala Daerah Tahun 2024, Masa Bakti 2025 - 2029 disini"
            ],
            'agenda-kampanye' => [
                "title" => "Agenda Kampanye [nama_paslon]",
                "description" => "Riwayat Agenda Kampanye [nama_paslon], Calon [title] [wilayah] Pemilihan Kepala Daerah Tahun 2024, Masa Bakti 2025 - 2029 disini"
            ],
        ]

    ],
    'profil_data_last_access' => "20240630", 
];