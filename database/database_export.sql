-- SQLite Export
-- Generated: 2026-06-30 11:03:33

PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

-- Table: academic_years
CREATE TABLE "academic_years" ("id" integer primary key autoincrement not null, "name" varchar not null, "is_active" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime);


-- Table: agendas
CREATE TABLE "agendas" ("id" integer primary key autoincrement not null, "title" varchar not null, "event_date" date not null, "description" text, "created_at" datetime, "updated_at" datetime, "end_date" date);


-- Table: articles
CREATE TABLE "articles" ("id" integer primary key autoincrement not null, "title" varchar not null, "image" varchar, "excerpt" text not null, "content" text not null, "published_at" date not null, "created_at" datetime, "updated_at" datetime, "slug" varchar not null);


-- Table: cache
CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));


-- Table: cache_locks
CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));


-- Table: classrooms
CREATE TABLE "classrooms" ("id" integer primary key autoincrement not null, "nama_kelas" varchar not null, "teacher_id" integer, "academic_year_id" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("teacher_id") references "teachers"("id") on delete set null, foreign key("academic_year_id") references "academic_years"("id") on delete cascade);


-- Table: competencies
CREATE TABLE "competencies" ("id" integer primary key autoincrement not null, "name" varchar not null, "description" text, "created_at" datetime, "updated_at" datetime);


-- Table: documents
CREATE TABLE "documents" ("id" integer primary key autoincrement not null, "student_id" integer not null, "akta_kelahiran" varchar, "kartu_keluarga" varchar, "ijazah_tk" varchar, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "students"("id") on delete cascade);


-- Table: facilities
CREATE TABLE "facilities" ("id" integer primary key autoincrement not null, "name" varchar not null, "image" varchar, "created_at" datetime, "updated_at" datetime);


-- Table: failed_jobs
CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);


-- Table: hero_images
CREATE TABLE "hero_images" ("id" integer primary key autoincrement not null, "image" varchar not null, "alt_text" varchar, "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Table: job_batches
CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));


-- Table: jobs
CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);


-- Table: lpad_students
CREATE TABLE "lpad_students" ("id" integer primary key autoincrement not null, "no_induk" varchar not null, "nama_lengkap" varchar not null, "tanggal_lahir" date not null, "created_at" datetime, "updated_at" datetime);


-- Table: migrations
CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);

INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('4', '2026_03_11_123021_create_academic_years_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('5', '2026_03_11_123022_create_classrooms_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('6', '2026_03_11_123022_create_ppdb_registrations_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('7', '2026_03_11_123022_create_teachers_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('8', '2026_03_11_123023_create_student_parents_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('9', '2026_03_11_123023_create_students_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('10', '2026_03_11_123024_create_competencies_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('11', '2026_03_11_123024_create_posts_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('12', '2026_03_11_123024_create_student_grades_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('13', '2026_03_17_221849_create_hero_images_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('14', '2026_04_24_171102_create_principals_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('15', '2026_04_24_171103_create_agendas_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('16', '2026_04_24_171103_create_articles_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('17', '2026_04_24_171103_create_staff_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('18', '2026_04_24_171104_create_facilities_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('19', '2026_04_24_211419_create_school_profiles_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('20', '2026_04_25_065942_create_vision_missions_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('21', '2026_04_25_074446_create_school_identities_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('22', '2026_04_30_000001_create_lpad_students_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('23', '2026_04_30_000002_create_reports_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('24', '2026_04_30_000003_create_report_narratives_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('25', '2026_04_30_100000_extend_ppdb_registrations_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('26', '2026_05_04_000001_add_role_to_users_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('27', '2026_05_04_000002_extend_students_table_for_ppdb', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('28', '2026_05_04_000003_extend_student_parents_table_for_ppdb', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('29', '2026_05_04_000004_create_documents_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('30', '2026_05_04_000005_create_registrations_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('31', '2026_05_05_192211_make_nis_nullable_in_students_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('32', '2026_05_06_171202_make_ppdb_id_nullable_in_student_parents_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('33', '2026_05_06_171810_make_no_hp_ortu_nullable_in_student_parents_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('34', '2026_05_06_200851_add_google_sso_to_users_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('35', '2026_05_07_000001_add_google_sso_columns_to_users_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('36', '2026_05_07_000002_add_photo_to_teachers_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('37', '2026_05_12_155335_add_slug_to_articles_table', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('38', '2026_05_21_030722_backfill_null_slugs_in_articles', '1');
INSERT INTO "migrations" (\"id\", \"migration\", \"batch\") VALUES ('39', '2026_05_30_000001_add_end_date_to_agendas_table', '2');

-- Table: password_reset_tokens
CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));


-- Table: posts
CREATE TABLE "posts" ("id" integer primary key autoincrement not null, "title" varchar not null, "slug" varchar not null, "content" text not null, "image" text, "created_at" datetime, "updated_at" datetime);


-- Table: ppdb_registrations
CREATE TABLE "ppdb_registrations" ("id" integer primary key autoincrement not null, "no_pendaftaran" varchar not null, "nama_lengkap" varchar not null, "nama_panggilan" varchar, "jenis_kelamin" varchar check ("jenis_kelamin" in ('L', 'P')) not null, "tempat_lahir" varchar not null, "tanggal_lahir" date not null, "nik" varchar not null, "alamat_jalan" text not null, "status" varchar not null default 'pending', "created_at" datetime, "updated_at" datetime, "nomor_pendaftaran" varchar, "nama_siswa" varchar, "agama" varchar, "kewarganegaraan" varchar default 'WNI', "anak_ke" integer, "jml_saudara_kandung" integer, "jml_saudara_tiri" integer, "jml_saudara_angkat" integer, "bahasa_sehari_hari" varchar, "berat_badan" float, "tinggi_badan" float, "golongan_darah" varchar, "riwayat_penyakit" varchar, "alamat" text, "no_hp" varchar, "tinggal_bersama" varchar, "nama_ayah" varchar, "tempat_lahir_ayah" varchar, "tanggal_lahir_ayah" date, "nama_ibu" varchar, "tempat_lahir_ibu" varchar, "tanggal_lahir_ibu" date, "pendidikan_ayah" varchar, "pendidikan_ibu" varchar, "pekerjaan_ayah" varchar, "pekerjaan_ibu" varchar, "nama_wali" varchar, "pendidikan_wali" varchar, "hubungan_anak_wali" varchar, "pekerjaan_wali" varchar);


-- Table: principals
CREATE TABLE "principals" ("id" integer primary key autoincrement not null, "name" varchar not null, "image" varchar, "message" text not null, "created_at" datetime, "updated_at" datetime);

INSERT INTO "principals" (\"id\", \"name\", \"image\", \"message\", \"created_at\", \"updated_at\") VALUES ('1', 'Kotijah, S.Pd', NULL, 'Assalamualaikum Wr. Wb. Selamat datang di TK Puspitasari Kaliwatubumi. Kami berkomitmen memberikan pendidikan terbaik bagi anak usia dini dengan landasan nilai-nilai Islami yang kuat...', '2026-05-28 14:10:34', '2026-05-28 14:10:34');

-- Table: registrations
CREATE TABLE "registrations" ("id" integer primary key autoincrement not null, "student_id" integer not null, "status" varchar check ("status" in ('draft', 'submitted', 'verified', 'rejected', 'accepted', 'not_accepted')) not null default 'draft', "notes" text, "verified_by" integer, "verified_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "students"("id") on delete cascade, foreign key("verified_by") references "users"("id") on delete set null);


-- Table: report_narratives
CREATE TABLE "report_narratives" ("id" integer primary key autoincrement not null, "report_id" integer not null, "elemen_agama_budi_pekerti" text, "elemen_jati_diri" text, "elemen_literasi_steam" text, "projek_p5" text, "created_at" datetime, "updated_at" datetime, foreign key("report_id") references "reports"("id") on delete cascade);


-- Table: reports
CREATE TABLE "reports" ("id" integer primary key autoincrement not null, "lpad_student_id" integer not null, "tahun_ajaran" varchar not null, "semester" varchar check ("semester" in ('1', '2')) not null, "bb" float not null, "tb" float not null, "lingkar_kepala" float not null, "kondisi_mata" varchar not null, "kondisi_telinga" varchar not null, "kondisi_hidung" varchar not null, "kondisi_gigi" varchar not null, "kondisi_kulit" varchar not null, "sakit" integer not null default '0', "izin" integer not null default '0', "alpa" integer not null default '0', "komentar_ortu" text, "created_at" datetime, "updated_at" datetime, foreign key("lpad_student_id") references "lpad_students"("id") on delete cascade);


-- Table: school_identities
CREATE TABLE "school_identities" ("id" integer primary key autoincrement not null, "school_name" varchar not null default 'TK Puspitasari', "npsn" varchar, "status" varchar not null default 'Swasta', "education_form" varchar not null default 'TK', "ownership_status" varchar not null default 'Yayasan', "establishment_decree" varchar, "establishment_date" date, "operational_decree" varchar, "operational_date" date, "address" varchar, "hamlet" varchar, "village" varchar, "district" varchar, "regency" varchar, "province" varchar, "postal_code" varchar, "created_at" datetime, "updated_at" datetime);

INSERT INTO "school_identities" (\"id\", \"school_name\", \"npsn\", \"status\", \"education_form\", \"ownership_status\", \"establishment_decree\", \"establishment_date\", \"operational_decree\", \"operational_date\", \"address\", \"hamlet\", \"village\", \"district\", \"regency\", \"province\", \"postal_code\", \"created_at\", \"updated_at\") VALUES ('1', 'TK PUSPITASARI', '20353717', 'Swasta', 'TK', 'Yayasan', '079.45/IO3.26/D5/1998;8Agustus 1998', '1998-08-08 00:00:00', '562.60/119/111/2021', '2021-03-03 00:00:00', 'Jalan Abean RT 01 RW 05 Desa Kaliwatubumi Kecamatan Butuh Kabupaten Purworejo', 'Abean RT 01 RW 05', 'Kaliwatubumi', 'Kec. Butuh', 'Kab. Purworejo', 'Jawa Tengah', '54264', '2026-05-28 13:50:18', '2026-05-28 13:50:18');

-- Table: school_profiles
CREATE TABLE "school_profiles" ("id" integer primary key autoincrement not null, "title" varchar not null, "feature_image" varchar, "content" text not null, "created_at" datetime, "updated_at" datetime);

INSERT INTO "school_profiles" (\"id\", \"title\", \"feature_image\", \"content\", \"created_at\", \"updated_at\") VALUES ('1', 'Profil TK Puspitasari', NULL, '<p><strong>TK PUSPITASARI</strong> merupakan salah satu sekolah jenjang TK berstatus Swasta yang berada di wilayah Kec. Butuh, Kab. Purworejo, Jawa Tengah. TK PUSPITASARI didirikan pada tanggal 8 Agustus 1998 dengan Nomor SK Pendirian 079.45/IO3.26/D5/1998;8Agustus 1998 yang berada dalam naungan Kementerian Pendidikan dan Kebudayaan. Kepala Sekolah TK PUSPITASARI saat ini adalah Kotijah,s. Pd. Operator yang bertanggung jawab adalah Sukowati.</p><p>Dengan adanya keberadaan TK PUSPITASARI, diharapkan dapat memberikan kontribusi dalam mencerdaskan anak bangsa di wilayah Kec. Butuh, Kab. Purworejo.</p><h3 class="text-xl font-semibold text-gray-800 mt-4 mb-2">Informasi & Tata Kelola Sekolah</h3><ul><li><strong>Pendiri / Yayasan:</strong> Hj. Siti Jariyah</li><li><strong>Alamat Lengkap:</strong> Jalan Abean RT 01 RW 05 Desa Kaliwatubumi Kecamatan Butuh Kabupaten Purworejo</li><li><strong>Jumlah Guru / Staf:</strong> 2 orang (Sumber Daya Manusia)</li><li><strong>Jumlah Siswa Saat Ini:</strong> 20 siswa (Laki-laki: 12 anak, Perempuan: 8 anak)</li><li><strong>Hari Operasional:</strong> Senin sampai Sabtu</li><li><strong>Jam Masuk Guru:</strong> 07:00 WIB</li><li><strong>Jam Masuk Siswa:</strong> 07:30 WIB</li><li><strong>Jam Pulang Siswa:</strong> 10:00 WIB</li><li><strong>Posisi Pengembang IT (Kerja Praktik):</strong> Muhammad Irfan Fadhila</li></ul>', '2026-05-28 13:50:18', '2026-05-28 13:50:18');

-- Table: sessions
CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));


-- Table: staff
CREATE TABLE "staff" ("id" integer primary key autoincrement not null, "name" varchar not null, "position" varchar not null, "image" varchar, "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);

INSERT INTO "staff" (\"id\", \"name\", \"position\", \"image\", \"is_active\", \"created_at\", \"updated_at\") VALUES ('1', 'Kotijah, S.Pd', 'Kepala Sekolah & Guru', NULL, '1', '2026-05-28 14:10:34', '2026-05-28 14:10:34');
INSERT INTO "staff" (\"id\", \"name\", \"position\", \"image\", \"is_active\", \"created_at\", \"updated_at\") VALUES ('2', 'Sukowati, S. Pd.', 'Admin Sekolah & Guru', NULL, '1', '2026-05-28 14:10:34', '2026-05-28 14:10:34');

-- Table: student_grades
CREATE TABLE "student_grades" ("id" integer primary key autoincrement not null, "student_id" integer not null, "academic_year_id" integer not null, "competency_id" integer not null, "grade" varchar not null, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "students"("id") on delete cascade, foreign key("academic_year_id") references "academic_years"("id") on delete cascade, foreign key("competency_id") references "competencies"("id") on delete cascade);


-- Table: student_parents
CREATE TABLE "student_parents" ("id" integer primary key autoincrement not null, "ppdb_registration_id" integer, "nama_ayah" varchar, "nama_ibu" varchar, "no_hp_ortu" varchar, "penghasilan" varchar, "created_at" datetime, "updated_at" datetime, "student_id" integer, "tempat_lahir_ayah" varchar, "tanggal_lahir_ayah" date, "pendidikan_ayah" varchar, "pekerjaan_ayah" varchar, "tempat_lahir_ibu" varchar, "tanggal_lahir_ibu" date, "pendidikan_ibu" varchar, "pekerjaan_ibu" varchar, "nama_wali" varchar, "pendidikan_wali" varchar, "hubungan_wali" varchar, "pekerjaan_wali" varchar, foreign key("ppdb_registration_id") references ppdb_registrations("id") on delete cascade on update no action, foreign key("student_id") references students("id") on delete cascade on update no action);


-- Table: students
CREATE TABLE "students" ("id" integer primary key autoincrement not null, "nis" varchar, "ppdb_registration_id" integer, "classroom_id" integer, "status" varchar, "created_at" datetime, "updated_at" datetime, "user_id" integer, "nama_lengkap" varchar, "nama_panggilan" varchar, "jenis_kelamin" varchar, "tempat_lahir" varchar, "tanggal_lahir" date, "agama" varchar, "kewarganegaraan" varchar not null default ('WNI'), "anak_ke" integer, "jumlah_saudara_kandung" integer, "jumlah_saudara_tiri" integer, "jumlah_saudara_angkat" integer, "bahasa_sehari_hari" varchar, "berat_badan" float, "tinggi_badan" float, "golongan_darah" varchar, "riwayat_penyakit" text, "alamat" text, "no_hp" varchar, "tinggal_bersama" varchar default ('orang_tua'), foreign key("user_id") references users("id") on delete cascade on update no action, foreign key("ppdb_registration_id") references ppdb_registrations("id") on delete cascade on update no action, foreign key("classroom_id") references classrooms("id") on delete set null on update no action);


-- Table: teachers
CREATE TABLE "teachers" ("id" integer primary key autoincrement not null, "nama" varchar not null, "jabatan" varchar, "foto" text, "bio" text, "created_at" datetime, "updated_at" datetime, "photo" varchar);

INSERT INTO "teachers" (\"id\", \"nama\", \"jabatan\", \"foto\", \"bio\", \"created_at\", \"updated_at\", \"photo\") VALUES ('1', 'Kotijah, S.Pd', 'Kepala Sekolah & Guru', NULL, NULL, '2026-05-28 13:55:30', '2026-05-28 13:55:30', NULL);
INSERT INTO "teachers" (\"id\", \"nama\", \"jabatan\", \"foto\", \"bio\", \"created_at\", \"updated_at\", \"photo\") VALUES ('2', 'Sukowati, S. Pd.', 'Admin Sekolah & Guru', NULL, NULL, '2026-05-28 13:55:30', '2026-05-28 13:55:30', NULL);

-- Table: users
CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar, "remember_token" varchar, "created_at" datetime, "updated_at" datetime, "role" varchar not null default ('user'), "google_id" varchar, "avatar" varchar);

INSERT INTO "users" (\"id\", \"name\", \"email\", \"email_verified_at\", \"password\", \"remember_token\", \"created_at\", \"updated_at\", \"role\", \"google_id\", \"avatar\") VALUES ('1', 'Admin', 'admin@gmail.com', NULL, '$2y$12$1GB65ccEFBrAznEmEibT5ex6dtx4octiapJBqRAz9vEDA1lo6vldW', NULL, '2026-05-28 02:48:32', '2026-05-28 14:10:34', 'admin', NULL, NULL);

-- Table: vision_missions
CREATE TABLE "vision_missions" ("id" integer primary key autoincrement not null, "title" varchar not null, "feature_image" varchar, "content" text not null, "created_at" datetime, "updated_at" datetime);

INSERT INTO "vision_missions" (\"id\", \"title\", \"feature_image\", \"content\", \"created_at\", \"updated_at\") VALUES ('1', 'Visi & Misi', NULL, '<h3 class="text-xl font-bold text-gray-900 mt-4 mb-2">Visi</h3><p>Mewujudkan anak didik yang Cerdas, Taqwa, dan Kreatif bersama kami di Kaliwatubumi.</p><h3 class="text-xl font-bold text-gray-900 mt-6 mb-2">Misi</h3><ol><li>Menanamkan nilai-nilai keagamaan dan budi pekerti luhur sejak usia dini.</li><li>Menyelenggarakan proses pembelajaran yang menyenangkan, kreatif, dan inovatif sesuai tahap tumbuh kembang anak.</li><li>Mengembangkan potensi diri anak secara optimal untuk mempersiapkan jenjang pendidikan selanjutnya.</li></ol>', '2026-05-28 13:50:18', '2026-05-28 13:50:18');

CREATE INDEX "sessions_user_id_index" on "sessions" ("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions" ("last_activity");
CREATE INDEX "cache_expiration_index" on "cache" ("expiration");
CREATE INDEX "cache_locks_expiration_index" on "cache_locks" ("expiration");
CREATE INDEX "jobs_queue_reserved_at_available_at_index" on "jobs" ("queue", "reserved_at", "available_at");
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs" ("uuid");
CREATE UNIQUE INDEX "ppdb_registrations_no_pendaftaran_unique" on "ppdb_registrations" ("no_pendaftaran");
CREATE UNIQUE INDEX "ppdb_registrations_nik_unique" on "ppdb_registrations" ("nik");
CREATE UNIQUE INDEX "posts_slug_unique" on "posts" ("slug");
CREATE UNIQUE INDEX "lpad_students_no_induk_unique" on "lpad_students" ("no_induk");
CREATE UNIQUE INDEX "ppdb_registrations_nomor_pendaftaran_unique" on "ppdb_registrations" ("nomor_pendaftaran");
CREATE UNIQUE INDEX "students_nis_unique" on "students" ("nis");
CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE UNIQUE INDEX "users_google_id_unique" on "users" ("google_id");
CREATE UNIQUE INDEX "articles_slug_unique" on "articles" ("slug");

COMMIT;
