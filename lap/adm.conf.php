<?php
//ini_set("dispay_errors",1);
$_table_prefix="adm_";


$_config['host']="localhost";
$_config['user']="mrcoco";
$_config['pass']="northface";
$_config['dbname']="presensi";
$_config['redirect_page']="logout.php";


$_config['site']="Presensi Online Universitas Negeri Yogyakarta";
$_config['site_url']="http://192.168.209.12/";



$lang['err_db_host']="Host down";
$lang['err_db_db']="Db not exist";
$lang['err_db_res']="invalid resource";
$lang['err_db_syntax']="syntax error";

$lang['err_auth_error']="Query error";

$_config['menu']['adm_profile']=array("adm_profile","Ganti Password","adm.profile.php");
$_config['menu']['adm_libur']=array("adm_libur","Libur Nasional","adm.libur.php");
$_config['menu']['adm_pegawai']=array("adm_pegawai","Daftar Pegawai","adm.pegawai.php");
$_config['menu']['daftar_pegawai']=array("daftar_pegawai","Daftar Pegawai","pegawai.php");
$_config['menu']['daft_pegawai_p']=array("daft_pegawai_p","Daftar Pegawai","adm.pegawai_p.php");
$_config['menu']['ijin']=array("ijin","Daftar izin","ijin.php");
$_config['menu']['adm_ijin']=array("adm_ijin","Daftar izin","adm.ijin.php");
//$_config['menu']['adm_tugas']=array("adm_tugas","Izin Tugas / Dinas","adm.tugas.php");
$_config['menu']['tugas']=array("tugas","Izin Tugas / Dinas","tugas.php");
$_config['menu']['presensi_manual']=array("presensi_manual","Presensi Manual","presensi.manual.php");
$_config['menu']['adm_manual']=array("adm_manual","Presensi Manual","adm.manual.php");
$_config['menu']['view_dosen']=array("view_dosen","Daftar Presensi Dosen","adm.view.dosen.php");
$_config['menu']['view_karyawan']=array("view_karyawan","Daftar Presensi Karyawan","adm.view.kar.php");
$_config['menu']['rekap_dosen']=array("rekap_dosen","Rekap Dosen (bulanan)","adm.daftar.dosen.php");
$_config['menu']['rekap_karyawan']=array("rekap_karyawan","Rekap Karyawan (bulanan)","adm.daftar.kar.php");
$_config['menu']['rekap_ft']=array("rekap_ft","Rekap Karyawan FT","adm.daftar.karFT.php");
$_config['menu']['rekap_cleaning']=array("rekap_cleaning","Rekap Cleaning Service","adm.cleaning.php");
$_config['menu']['rekap_pkl']=array("rekap_pkl","Rekap Siswa PKL","adm.pkl.php");
$_config['menu']['cetak_karyawan']=array("cetak_karyawan","Cetak Presensi Karyawan Bulanan","adm.rekap.karyawan.php");
$_config['menu']['cetak_rekap_all']=array("cetak_rekap_all","Cetak Presensi Karyawan Bulanan*","adm.rekap.all.php");
$_config['menu']['cetak_rekap_hk']=array("cetak_rekap_hk","Cetak Presensi Karyawan Hari berjalan","adm.rekap.hk.php");
$_config['menu']['cetak_rekap_hk_all']=array("cetak_rekap_hk_all","Cetak Presensi Karyawan Hari berjalan*","adm.rekap.hk.all.php");
$_config['menu']['cetak_dosen']=array("cetak_dosen","Cetak Presensi Dosen","adm.rekap.dosen.php");
$_config['menu']['hadir_jur']=array("hadir_jur","Cetak Rekap Dosen (harian)","adm.rekap.dos.php");
$_config['menu']['matrix_dosen']=array("matrix_dosen","Cetak Matrix Dosen","adm.matrik.dos.php");
$_config['menu']['matrix_karyawan']=array("matrix_karyawan","Cetak Matrix Karyawan","adm.matrik.kar.php");
$_config['menu']['hadir_dosen']=array("hadir_dosen","Jumlah Kehadiran Dosen","adm.hadir.dosen.php");
$_config['menu']['hadir_karyawan']=array("hadir_karyawan","Jumlah Kehadiran Karyawan","adm.hadir.kar.php");
//$_config['menu']['daftar_pegawai']=array("daftar_pegawai","Daftar Pegawai","pegawai.php");
$_config['menu']['all_dosen']=array("all_dosen","Daftar Presensi Dosen*","adm.all.php?jab=Dosen");
$_config['menu']['all_karyawan']=array("all_karyawan","Daftar Presensi karyawan*","adm.all.php?jab=Karyawan");
$_config['menu']['adm_satpam']=array("adm_satpam","Daftar Presensi Satpam","adm.satpam.php");
$_config['menu']['adm_rekap_satpam']=array("adm_rekap_satpam","Rekap Presensi Satpam","adm.rekap.satpm.php");
$_config['menu']['dafall_dosen']=array("dafall_dosen","Rekap Presensi Dosen*","adm.dall.php?jab=Dosen");
$_config['menu']['dafall_karyawan']=array("dafall_karyawan","Rekap Presensi Karyawan*","adm.dall.php?jab=Karyawan");
$_config['menu']['mall_dosen']=array("mall_dosen","Matrix Presensi Dosen*","adm.mall.php?jab=Dosen");
$_config['menu']['mall_karyawan']=array("mall_karyawan","Matrix Presensi Karyawan*","adm.mall.php?jab=Karyawan");
$_config['menu']['statistik']=array("statistik","statistik","statistik.php");
$_config['menu']['statkehadiran']=array("statkehadiran","Statistik Kehadiran","_statistik.php");
$_config['menu']['news']=array("news","Berita Terbaru*","adm.news.php");
$_config['menu']['rekap_bag']=array("rekap_bag","Rekap Biro/Fakultas","rekap.bag.php");
$_config['menu']['adm_mahasiswa']=array("adm_mahasiswa","Daftar Mahasiswa","daftar.mhs.php");
$_config['menu']['adm_rekap_mhs']=array("adm_rekap_mas","Presensi TA Harian","rekap.mhs.php");
$_config['menu']['adm_rekap_bul']=array("adm_rekap_bul","Presensi TA Bulanan","rekap.ta.bulanan.php");
$_config['menu']['adm_rekap_per']=array("adm_rekap_per","Presensi TA Personal","rekap.ta.person.php");
$_config['menu']['dosen_dr']=array("dosen_dr","Rekap Dosen Dr","adm.dosen.dr.php");
$_config['menu']['changelog']=array("changelog","Changelog version","adm.changelog.php");
$_config['menu']['testimoni']=array("testimoni","Testimoni","adm.testimoni.php");
?>