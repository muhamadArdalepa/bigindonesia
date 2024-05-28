<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                [
                    'name' => 'Aiman Taha',
                    'email' => 'aimantaha@bigindonesia.site',
                    'password' => '$2y$10$1ZBsWDCQ.xdFY1cJwjT0ReTOK2FNZhKWsVCevY5mYYNRDXxcxfVvW',
                    'region_id' => 1,
                    'phone' => '6285752582041',
                    'picture' => 'profile/UIMGe8c0bdf024a0a0b657e6e4d7562f992eddeb0f72bcd0f9c475a76851d1980d035170c55c552e1134bdb4a6411926558a5d9e022fbd8f5475c207e8f620e86c34..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Agistra AR',
                    'email' => 'agis@bigindonesia.site',
                    'password' => '$2y$10$RfiTmfZByow3W6lNch7VHuCppd6gmyw4IPZkDue3fUZUCU2sfIYDC',
                    'region_id' => 1,
                    'phone' => '6281257270074',
                    'picture' => 'profile/UIMGcbaa7b07931b667153e8717407f98ba436b47af2e3384002518bfabc9295868ded4e4672f1827c14a7485d8157d7c0ae32c6a9feba7deea7fbac62b79b023b4a..jpeg',
                ],
                ['Karyawan','Programmer']
            ],
            [
                [
                    'name' => 'Agustian',
                    'email' => 'agustian@bigindonesia.site',
                    'password' => '$2y$10$A76u5m0Dlyo3vn/9RZs6KuB0OgWENl3EyYvhfdXfMw.vlwsmNH3Xa',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan']
            ],
            [
                [
                    'name' => 'Alfonsius Liguori P',
                    'email' => 'alfonsiusliguoripratama@bigindonesia.site',
                    'password' => '$2y$10$AZtkoZE736FWQSvIxwhnDO02HvtGq13/4HyPz.es8HdDy.YzoZD8O',
                    'region_id' => 1,
                    'phone' => '6289680680794',
                    'picture' => 'profile/UIMG2023101109360365260a13b08ec.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Alung',
                    'email' => 'alung@bigindonesia.site',
                    'password' => '$2y$10$v9u9z/tX4tZCIu9cXUJBHONNbZLKhMV9aZCyxTzrd79kCZvQEI88a',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Along',
                    'email' => 'along@bigindonesia.site',
                    'password' => '$2y$10$IbD2TzqXULZQ5LeMQkUu4eIf.taarDvMwaIc96PfxT/kIN1H3u/7G',
                    'region_id' => 1,
                    'phone' => '6285389988326',
                    'picture' => 'profile/UIMG202311011334056541f15db42ff.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Arya Gutawa',
                    'email' => 'aryagutawa@bigindonesia.site',
                    'password' => '$2y$10$wnRaik.xaArLKskhDITiReQSOn05MKbsu0KOryA0HanVIJZRdTs2S',
                    'region_id' => 1,
                    'phone' => '6282256472964',
                    'picture' => 'profile/UIMG202310131349566528e894b6d1b.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Andika',
                    'email' => 'andika@bigindonesia.site',
                    'password' => '$2y$10$/JBX5LC5hKF7crK.r.bA8OckY851Uy2XA3ptfCNXQ0yoIAg321xpy',
                    'region_id' => 1,
                    'phone' => '62895701800518',
                    'picture' => 'profile/UIMG20231122090621655d621dde15e.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'BONI PANTURA',
                    'email' => 'bonipantura@bigindonesia.site',
                    'password' => '$2y$10$.sIebLNqZSvuLStTRaQwSeqIP9QKdPwsvsWq9G6G/xG1.5A7Grmaa',
                    'region_id' => 1,
                    'phone' => '6285787615571',
                    'picture' => 'profile/UIMG202310311859316540ec238ccc1.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Danti Amalia',
                    'email' => 'dantiamalia@bigindonesia.site',
                    'password' => '$2y$10$CUyZO4U/0ALp1TdDnOnPd.X583zYZyV4IYkZwEheMo84Esz9ZBuI2',
                    'region_id' => 1,
                    'phone' => '6289693740660',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Frontliner','CS']
            ],
            [
                [
                    'name' => 'Diky Januardi',
                    'email' => 'dikyjanuardi@bigindonesia.site',
                    'password' => '$2y$10$GlmtS8aI9pPDFvhqwbsUrOxAdw9jya7ti8VuHsKWYjoBhUwTiSAOS',
                    'region_id' => 1,
                    'phone' => '6289519879988',
                    'picture' => 'profile/UIMG20231108091932654af034ca8fd.jpg',
                ],
                ['Karyawan','Marketer']
            ],
            [
                [
                    'name' => 'Erik Fitra W',
                    'email' => 'erikfitrawijaya@bigindonesia.site',
                    'password' => '$2y$10$hqJ0a51KTLFPnuTlf9IYB.4we2fKp8JtcbJbstxYCEIc1oIjs0QiO',
                    'region_id' => 1,
                    'phone' => '628990724552',
                    'picture' => 'profile/UIMG202311011343216541f3893a60c.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Fitriadi',
                    'email' => 'fitriadi@bigindonesia.site',
                    'password' => '$2y$10$0pFfQy7PVe0wG.fMyY2z7.yaEg6/GqFcC/EQ8pfi0mXKxm7/MZuOy',
                    'region_id' => 1,
                    'phone' => '6289694027560',
                    'picture' => 'profile/UIMG2023110115403465420f02ba786.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Gunawan',
                    'email' => 'gunawan@bigindonesia.site',
                    'password' => '$2y$10$cH/5rBYiS8hOTVvXnZfWyub53EgdxYTlbGNQUNyJExJsF7v1GsAwy',
                    'region_id' => 1,
                    'phone' => '6281521846935',
                    'picture' => 'profile/UIMG2023110213051465433c1a07500.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Hendra Lesmana',
                    'email' => 'hendralesmana@bigindonesia.site',
                    'password' => '$2y$10$BWaea7FjumK6KAkxQfwjzu1Z8XnKdsX3z6UpX/q2JD/jsdG6/TjHu',
                    'region_id' => 1,
                    'phone' => '628152215635',
                    'picture' => 'profile/UIMG389bf0c733c6075a0bd233be085fa75aee749954d03774a25c39653c12fd9091d7fbd63e42a47d5f5d2c277fdf74f1cbaa87777bd55e0d32cf3ed729ef55a4d5..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Hendri',
                    'email' => 'hendri@bigindonesia.site',
                    'password' => '$2y$10$AkfU.0ZibvkLrxd9bQLbE.UxPiUZtdHXdFPEjQkFzByGcG7ZeIjKq',
                    'region_id' => 1,
                    'phone' => '6283833683988',
                    'picture' => 'profile/UIMG202311010811026541a5a690527.jpg',
                ],
                ['Karyawan','Marketer']
            ],
            [
                [
                    'name' => 'Ichsan Arrahman',
                    'email' => 'ichsanarrahman@bigindonesia.site',
                    'password' => '$2y$10$lMxHg8HxrtyQ3iNQfckR/ekzLsMleHjY/Y.3Ewl6qANAMOZFa3JYi',
                    'region_id' => 1,
                    'phone' => '6285753550595',
                    'picture' => 'profile/UIMG2023101110194965261455a963c.jpg',
                ],
                ['Karyawan','Teknisi','K3']
            ],
            [
                [
                    'name' => 'Jefri Maulana S',
                    'email' => 'jefrisaputramaulana@bigindonesia.site',
                    'password' => '$2y$10$5UflSgnqfIobnJtSwyx0VecnUBJc7JdeWeRsyW7AnzO0SXeui7xCS',
                    'region_id' => 1,
                    'phone' => '6285822714059',
                    'picture' => 'profile/UIMG5288537f971a7d107545d8015d2838d3f20620ec8c05d8143557c2bceed6a39a4c99d7d754ce30eae4175ab2ec01c7f10087db8649fd8294254e3105337aba3a..jpeg',
                ],
                ['Karyawan','Marketer']
            ],
            [
                [
                    'name' => 'Irvan Supriyatna',
                    'email' => 'irvan.supriyatna19@gmail.com',
                    'password' => '$2y$10$PpAouTUb3.ztrfc.k3sUZevsctNrSEqxtwmn0s74EcshWQE2qg05i',
                    'region_id' => 1,
                    'phone' => '6289694048405',
                    'picture' => 'profile/UIMG202311011106356541cecb29bdd.jpg',
                ],
                ['Karyawan','NOC']
            ],
            [
                [
                    'name' => 'Marsilindo',
                    'email' => 'marsilindo@bigindonesia.site',
                    'password' => '$2y$10$7OnFsVEXvlRJvLQp3y51nuqBDDunvKmTEp6qvYFemI4Eg4wc8i0wS',
                    'region_id' => 1,
                    'phone' => '6288705532057',
                    'picture' => 'profile/UIMG202311011130166541d4585e0e3.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Muhamad Ardalepa',
                    'email' => 'ard@le.pa',
                    'password' => '$2y$10$C4EnltQOLRwYOpQ0O4S/AeE.YHwNhIOR47BiBKXdjzXAAg1KrT9N.',
                    'region_id' => 1,
                    'phone' => '6281521544674',
                    'picture' => 'profile/UIMG5d13dc6988873cdf708eaa73cc30a2eb85078e89aedad7693749ec408da7368c67c4ea403f0542b51398290751ed5f45a957caee386acae09f15ad18f1f913fd..jpeg',
                ],
                ['Karyawan','Super Admin', 'Programmer']
            ],
            [
                [
                    'name' => 'Nico Prio Dwi',
                    'email' => 'nicopriodwi@bigindonesia.site',
                    'password' => '$2y$10$.dpXokwqiP3oRRc.qFOb5usJ395HU5Y10tBdi4S.8SPCZzvbPQkd6',
                    'region_id' => 1,
                    'phone' => '6283815557523',
                    'picture' => 'profile/UIMG20231108082352654ae32838b61.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Niken',
                    'email' => 'nikenramayati@bigindonesia.site',
                    'password' => '$2y$10$3KKd8PRYobYCrM3k/qt3re0PpedI9rwhpdUMtO8T3OcGkOOfdkHj6',
                    'region_id' => 1,
                    'phone' => '62895329976514',
                    'picture' => 'profile/UIMG202310111946376526992d39941.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Nurhasan',
                    'email' => 'nurhasan@bigindonesia.site',
                    'password' => '$2y$10$Y0ll/t4.3C5W99VdcA.tluDNceucg2LGNzRFrSG6qs4ElUTM2TOKG',
                    'region_id' => 1,
                    'phone' => '6281349574774',
                    'picture' => 'profile/UIMG202311010915116541b4af66d58.jpg',
                ],
                ['Karyawan','PIC']
            ],
            [
                [
                    'name' => 'Qoriatul F',
                    'email' => 'qoriatulfasyehah@bigindonesia.site',
                    'password' => '$2y$10$yQexxvqABSXUqWhuS9fbn.fJrVbqdMbwzmFuGEr/G4tD25fAPqUku',
                    'region_id' => 1,
                    'phone' => '6283891457968',
                    'picture' => 'profile/UIMG202311031122056544756d6b359.jpg',
                ],
                ['Karyawan','Admin']
            ],
            [
                [
                    'name' => 'Reza Fahlepi',
                    'email' => 'rezafahlepi@bigindonesia.site',
                    'password' => '$2y$10$pKc5yBRtd3cdZLxxrapS5Ol9jN1RPXTUrsR/0/95bDOwIqLS75sqm',
                    'region_id' => 1,
                    'phone' => '628991391931',
                    'picture' => 'profile/UIMGa70422c67c439146b9acf342f172e31cba799df9001e9306e83526a12d2bc5cccd6d6abac69521ceb38412d21bb41ab01d0c1b086bacae1172d0c389afb0b8fc..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Ridho Maulana S',
                    'email' => 'ridhomaulanasaputra@bigindonesia.site',
                    'password' => '$2y$10$IJZfkYNaYlt.Sr8lBnWEeu5HH1bPgJjo9Sd5U9GlHR1MPYAdkVHAS',
                    'region_id' => 1,
                    'phone' => '6289693524418',
                    'picture' => 'profile/UIMG2023110211060165432029e88c5.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Riki',
                    'email' => 'riki@bigindonesia.site',
                    'password' => '$2y$10$h21RqT.ICccfaRzeLVxgAO34fMY5GpbWhBJ9p1Wbr9EeQKpuW23uO',
                    'region_id' => 1,
                    'phone' => '6289689326172',
                    'picture' => 'profile/UIMG202311010838486541ac28d1d5b.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Sanintan',
                    'email' => 'sanintan@bigindonesia.site',
                    'password' => '$2y$10$8LpDAc4AdB3rlnhtyCbdhurTeWSMkzNZvejzN5Ri6Ec8TY4cNHH9O',
                    'region_id' => 1,
                    'phone' => '6285753093220',
                    'picture' => 'profile/UIMG202311010840316541ac8f4b8a7.jpg',
                ],
                ['Karyawan','Akuntan','Admin']
            ],
            [
                [
                    'name' => 'Sigit Syahsafir',
                    'email' => 'sigitsyahsafir@bigindonesia.site',
                    'password' => '$2y$10$FXxN3VcQLeAyP0I5Xh3LZOemSW.6Nlq2YWzvfFwLbOb9R8iWIY2Rm',
                    'region_id' => 1,
                    'phone' => '62895384419267',
                    'picture' => 'profile/UIMG2023103122333265411e4cc561c.jpg',
                ],
                ['Karyawan','Asset']
            ],
            [
                [
                    'name' => 'Sudirman',
                    'email' => 'sudirman@bigindonesia.site',
                    'password' => '$2y$10$fWcdafBD/M48YYz1980CxeSIkTFDci6zfmaJjPYHPanLJtjccCd8W',
                    'region_id' => 1,
                    'phone' => '62895702480843',
                    'picture' => 'profile/UIMG571ce296fedf045e36a9ba05ff8ad993d4bad4e84b569a4d64375bec0c01634a9358d561d8b9ab52eb93c051d65cb5b5296367a5a67fe123360005e55978f776..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Suparjo',
                    'email' => 'suparjo@bigindonesia.site',
                    'password' => '$2y$10$08JcUtX7ESTj538h80UnFuuXK7.C8HvyjsK.pQGao98BBibahzna.',
                    'region_id' => 1,
                    'phone' => '6285389594238',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Tommy Ryan Dwiputra',
                    'email' => 'tommyrd25@gmail.com',
                    'password' => '$2y$10$4ruF2tiRmn279gtthysgj.scSF2Jvq.o4.2lcdWzUe35UNaQgvZby',
                    'region_id' => 1,
                    'phone' => '6285156984933',
                    'picture' => 'profile/UIMGc87f481ca9121aad63d2d62540cfeaee1d6a1037bc5de14ff18b8a46645fddbe68626e81e311c74ea20734f254e081a2e76dcddaf7c306c8dfbdc738c8e2527d..jpeg',
                ],
                ['Karyawan','NOC','PIC']
            ],
            [
                [
                    'name' => 'Arya Persada',
                    'email' => 'aryapersada@bigindonesia.site',
                    'password' => '$2y$10$GGGQB8kZojl76dIMamTIQ.eAexY37Socj/xMMe1DKSYgrZkvsuHQO',
                    'region_id' => 1,
                    'phone' => '62895367236732',
                    'picture' => 'profile/UIMG5d3cccb6cef631d4381097807351be807ce751979c823d68a77ea25d574b401b2511c1834d191b58ab88ccb702c11a73716a009c0a4ec75fd03cd8ef1dca30db..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Arda Saputra',
                    'email' => 'ardasaputra@bigindonesia.site',
                    'password' => '$2y$10$U5ICEPEgQCeFE3AH71fxeOreBre18TKkWaMVKhT32VPCgHDPikNRm',
                    'region_id' => 1,
                    'phone' => '6283151835874',
                    'picture' => 'profile/UIMG20231102112553654324d16823d.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Suparjo Ketapang',
                    'email' => 'suparjo2@bigindonesia.site',
                    'password' => '$2y$10$84woegqX3Ex7OM/eqE1meOTCPEKj06rxUo/YV4PHs0eVvQTz.402S',
                    'region_id' => 1,
                    'phone' => '628000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Suryadi',
                    'email' => 'suryadi@bigindonesia.site',
                    'password' => '$2y$10$PTszyEVRJF0gv5AYgsn4meaudmCLPCbMFFg/P4h2Jy1U6QbpinNq.',
                    'region_id' => 1,
                    'phone' => '62000000000',
                    'picture' => 'profile/UIMG2023110213313665434248a0fbb.jpg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Ramadhan Sarundaitan',
                    'email' => 'ramadhan.sarundaitan@gmail.com',
                    'password' => '$2y$10$dEBtvp2aW7WeaWjCGJsoWO9vHH1tkUz9V84PdTQmpfMHeq5bttwCu',
                    'region_id' => 1,
                    'phone' => '6289601073228',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Marketer']
            ],
            [
                [
                    'name' => 'Brigitta P.H',
                    'email' => 'brigitta@gmail.com',
                    'password' => '$2y$10$Rz.JpCz11RPk3NjNh9vqeO8gPUaWoy0yHTLjTj6zL6Cx2bqMZ8xZS',
                    'region_id' => 1,
                    'phone' => '6282252992800',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Admin']
            ],
            [
                [
                    'name' => 'Budi Hartono',
                    'email' => 'budihartono@big.site',
                    'password' => '$2y$10$.P3oSkwrWyYKeNGjcAYCouLDnGL4urWXH6l8XuGfDeXTaJvFZQ8CO',
                    'region_id' => 1,
                    'phone' => '6281257618888',
                    'picture' => 'profile/UIMGb93480bbaa55ab5a9d2a70ba185b674f2b8e2b74d1c2020743869242ad0c11141ae78e7faf35785a8a3e3d7f6742acc3b097c5d5da8b4a64532c295f9a3b1993..jpeg',
                ],
                ['Supervisor']
            ],
            [
                [
                    'name' => 'Muhammad Rifai A',
                    'email' => 'mrifai@bigindonesia.site',
                    'password' => '$2y$10$Th7xQFMKzk1ihkdc5SHVw.rLdfx6gkZ7vEY.Vy0b6r1ZMrPQjf9w.',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'profile/UIMGb91b775b05c3a01d98610f913034649a8096615dcc42a072bfc19bb82a96167223d6c1b31a8099295230a329f2b258f118a0905f356773433967fc3d5b28d2e9..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Elang Firman A',
                    'email' => 'elangfa@bigindonesia.site',
                    'password' => '$2y$10$ISfwmRFOV2VT2oZM1iipDe5riQUFM57so661AOPckonVhPo6ZvCVG',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Rizky Mahendra',
                    'email' => 'rizkymahendra@bigindonesia.site',
                    'password' => '$2y$10$EeP3XQfO7/T4RHb101K7s.8ZU7B65f9uomWOiIMuJFeYKGIgJzzlS',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Fahmi Rizal F',
                    'email' => 'fahmirizalf@bigindonesia.site',
                    'password' => '$2y$10$1w4NFn86KnmdcXB2JRxkoeajqx0U5MYHGAh2RQdTxs.Vx0YvMFN.6',
                    'region_id' => 1,
                    'phone' => '6281234567890',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Gregorius Abel',
                    'email' => 'gregorius@big',
                    'password' => '$2y$10$mdBH2eIC8TyWTLWiT0rbi.IPtQau4OSAo5Mb22GLAqIh27iGHTyEy',
                    'region_id' => 1,
                    'phone' => '628000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Yus Suhardi',
                    'email' => 'yus@bigindonesia.site',
                    'password' => '$2y$10$PpPLcUQAlsmiIS7tqkSi3ub/W5Dz1pbxjw3h8vCz82gLdbpD.tYWq',
                    'region_id' => 1,
                    'phone' => '6281351226887',
                    'picture' => 'profile/UIMG47c4093729f2533d5fdce80d27411f51a10698bca7b57460826cfa72afd5358600b8c9d55e8126cd1290387a1eae6bb0d0a5c2d71558fe0b026090d382096b79..jpeg',
                ],
                ['Karyawan','Teknisi']
            ],
            [
                [
                    'name' => 'Yulita Klara',
                    'email' => 'ara@big.site',
                    'password' => '$2a$12$tBKkUu8U5UWqssMtedO17Oc2TgChyuI4VyG2JqxG0aSQgDZzpP.li',
                    'region_id' => 1,
                    'phone' => '6280000000000',
                    'picture' => 'picture/profile/dummy.avif',
                ],
                ['Supervisor']
            ]
        ];


        foreach ($users as $user) {
            $u = User::create($user[0]);
            foreach ($user[1] as $role) {
                $u->assignRole($role);
            }
        }

        
        // for ($i = 0; $i < 1000; $i++) {
        //     $user = User::create([
        //         'name' => fake()->name,
        //         'email' => uniqid() . Str::random(5) . '@big.com',
        //         'password' => '123123',
        //         'region_id' => 2,
        //         'phone' => fake()->numerify('08##########'),
        //     ]);
        //     $user->assignRole($role);
        // }
    }
}
