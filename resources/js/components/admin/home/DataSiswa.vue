<script>
import axios from 'axios';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import Swal from 'sweetalert2'

DataTable.use(DataTablesLib);

export default ({
    data () {
        return {
            user: null,
            siswa: [],
            kelas: '',
            isAdmin: true,
            names: [],
            kelas_nilai: [],
            id: '',
            nisn: '',
            selected_kelas_nilai: '',
            smester: [],
            model: {
                selected_smester: ''
            },
            nisn_nilai: ''
        }
    },
    setup() {
    },
    async mounted() {
        this.nisn = this.$user.nisn
        if (this.$user.nisn != 'admin') {
            this.isAdmin = false
            axios.get('/api/siswa_per_class', { params: { nisn: this.$user.nisn } }).then((res) => {
                this.siswa = res.data.data
            })
        } else {
            var param = null
            axios.get('/api/siswa/' + param).then((res) => {
                this.siswa = res.data.data
            })
        }

        if (this.$user.nisn != 'admin') {
            await axios.get('/api/getKelas', { params: { nisn: this.$user.nisn } }).then((res) => {
                if (res.data.data[0]) {
                    if (res.data.data[0].id) {
                        this.kelas = res.data.data[0].id
                    }
                } else {
                    this.$router.push('/guru/tidak-ada-kelas')
                }
            })
        }

        var param = "OK"
        axios.get("/api/siswa/" + param).then((response) => {
            const array = []
            let data = response.data.data;
            array.push(data)
            array[0].forEach((item) => {
                this.names.push({
                label: item.name,
                code: item.nisn,
                });
            });
        });

        this.user = this.$user.name
    },
    created() {
    },
    methods: {
        async handleDownloadNilai(id) {
            var nisn = id
            this.nisn_nilai = id
            await axios.get("/api/nilaiKelas/", { params: { nisn: nisn } }).then((response) => {
            const array = []
            let data = response.data.data;
            array.push(data)
            array[0].forEach((item) => {
                    this.kelas_nilai.push({
                        label: item.id,
                        code: item.id,
                    });
                });
            });
            await axios.get("/api/nilaiSmester/", { params: { nisn: nisn } }).then((response) => {
            const array = []
            let data = response.data.data;
            array.push(data)
            array[0].forEach((item) => {
                    this.smester.push({
                        label: item.id,
                        code: item.id,
                    });
                });
            });
        },
        handleExport() {
            var semester = this.model.selected_smester
            var kelas = this.selected_kelas_nilai
            var nisn = this.nisn_nilai
            axios.get('/api/create-pdf-nilai/' + semester + '/' + kelas + '/' + nisn ).then((res) => {
                console.log('Berhasil');
            })
        },
        handleLogout(){
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        handleDataGuru(){
            this.$router.push('/admin/dataguru')
        },
        handleDataSiswa(){
            this.isAdmin == true ? this.$router.push('/admin/datasiswa') : this.$router.push('/guru/datasiswa')
        },
        handleHome(){
            this.isAdmin == true ? this.$router.push('/admin/home') : this.$router.push('/guru/home')
        },
        handleInformasi(){
            this.$router.push('/admin/informasi')
        },
        handleDetailSiswa(data){
            this.$router.push({ name: 'adminSiswaDetail', params: { nisn: data }})
        },
        handleKritik() {
            this.isAdmin == true ? this.$router.push('/admin/kritik') : this.$router.push('/guru/kritik')
        },
        handleNilai() {
            this.isAdmin == true ? this.$router.push('/admin/input-nilai') : this.$router.push('/guru/input-nilai')
        },
        handleSaveSiswaAdmin(){
            this.$router.push('/admin/tambah-datasiswa')
        },
        handleUpdateSiswa(data) {
            this.$router.push({ name: 'adminUpdateSiswa', params:{idSiswa:data}})
        },
        handleDeleteSiswa(data) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk menghapus siswa ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteSiswa', {nisn: data})
                    .then(response => {
                        if (response.data.success) {
                            swal({
                                title: "Berhasil dihapus!,",
                                text: response.data.message,
                                icon: "success",
                                button: false,
                                timer: 2500
                            }).then(function() {
                                window.location.reload()
                            });
                        } else {
                            swal({
                                title: "Peringatan",
                                text: "Gagal!",
                                icon: "error",
                                button: false,
                                timer: 2500
                            })
                        }
                    })
                }
            })
        },
        handleDeleteSiswaPerKelas(data) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk menghapus siswa ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteSiswaPerKelas', {nisn: data})
                    .then(response => {
                        if (response.data.success) {
                            swal({
                                title: "Berhasil dihapus!,",
                                text: response.data.message,
                                icon: "success",
                                button: false,
                                timer: 2500
                            }).then(function() {
                                window.location.reload()
                            });
                        } else {
                            swal({
                                title: "Peringatan",
                                text: "Gagal!",
                                icon: "error",
                                button: false,
                                timer: 2500
                            })
                        }
                    })
                }
            })
        },
        handleDataKelas() {
            this.$router.push('/admin/datakelas')
        },
        handleSendFormation(telp) {
            var informasi = []
            axios.get('/api/getInformasi').then((res) => {
                if ((res.data.data).length > 0) {
                    informasi.push((res.data.data[0]))
                    this.Send(telp, informasi[0])
                }
            })
        },
        Send(telp, informasi) {
            var changeTelp = telp
            if (telp[0] === '0') {
                changeTelp = telp.replace(telp[0], '62');
            }
            var id = informasi.id
            window.open("https://api.whatsapp.com/send/?phone="+ changeTelp + "&text=Informasi%0AHal%20%3A%20" + informasi.title + "%0AKunjungi%20tautan%20berikut%20untuk%20melihat%20surat%0Ahttp://webparent.test/informasi/detail/" + id + "&type=phone_number&app_absent=0");
        },
        handleSaveSiswa(nisn) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk menyimpan data siswa ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/simpanSiswa', {nisn: nisn, kelas: this.kelas})
                    .then(response => {
                        if (response.data.success) {
                            swal({
                                title: "Berhasil disimpan!,",
                                text: response.data.message,
                                icon: "success",
                                button: false,
                                timer: 2500
                            }).then(function() {
                                window.location.reload()
                            });
                        } else {
                            swal({
                                title: "Peringatan",
                                text: "Gagal!",
                                icon: "error",
                                button: false,
                                timer: 2500
                            })
                        }
                    })
                }
            })
        },
    },
})
</script>

<template>

    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">SMAN 1 CIWARU</span>
        </a>

        </div>

        <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/006/017/842/small_2x/customer-service-icon-user-with-laptop-computer-and-headphone-illustration-free-vector.jpg" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ user }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                <h6>{{ user }}</h6>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>
                <li v-if="!isAdmin">
                    <router-link class="dropdown-item d-flex align-items-center" :to="'/guru/change-password/' + nisn">
                        <i class="bi bi-key-fill"></i>
                        <span>Ganti Kata Sandi</span>
                    </router-link>
                </li>
                <li>
                <a class="dropdown-item d-flex align-items-center" href="#" @click="handleLogout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
                </li>
            </ul>
            </li>

        </ul>
        </nav>

    </header>


    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="" @click="handleHome">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item" v-if="isAdmin">
            <a class="nav-link collapsed" href="" @click="handleDataKelas">
            <i class="bi bi-person-workspace"></i>
            <span>Kelas</span>
            </a>
        </li>

        <li class="nav-item" v-if="isAdmin">
            <a class="nav-link collapsed" href="" @click="handleDataGuru">
            <i class="bi bi-person"></i>
            <span>Data Guru</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" @click="handleDataSiswa">
            <i class="bi bi-people"></i>
            <span>Data Siswa</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" v-if="!isAdmin" href="" @click="handleNilai">
                <i class="bi bi-book"></i>
                <span>Input Nilai</span>
            </a>
        </li>

        <li class="nav-item" v-if="isAdmin">
            <a class="nav-link collapsed" href="" @click="handleInformasi">
            <i class="bi bi-info-circle-fill"></i>
            <span>Pengumuman</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="" @click="handleKritik">
                <i class="bi bi-question-circle"></i>
                <span>Kritik & Saran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" @click="handleLogout">
            <i class="bi bi-box-arrow-left"></i>
            <span>Keluar</span>
            </a>
        </li>

        </ul>

    </aside>

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
            <li class="breadcrumb-item active">Data Siswa</li>
            </ol>
        </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <div class="modal fade" id="modalExportNilai" tabindex="-1" aria-labelledby="modalExportNilaiLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalExportNilaiLabel">Pilih Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Pilih Kelas
                                <v-select
                                :options="kelas_nilai"
                                :reduce="(label) => label.code"
                                label="label"
                                v-model="selected_kelas_nilai"
                                ></v-select>
                                <br>
                                Pilih Semester
                                <v-select
                                :options="smester"
                                :reduce="(label) => label.code"
                                label="label"
                                v-model="model.selected_smester"
                                ></v-select>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" @click="handleExport">Unduh</button>
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalSiswa" tabindex="-1" aria-labelledby="modalSiswaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalSiswaLabel">Pilih Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <v-select
                                :options="names"
                                :reduce="(label) => label.code"
                                label="label"
                                v-model="id"
                                ></v-select>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" @click="handleSaveSiswa(id)">Simpan</button>
                            </div>
                            </div>
                        </div>
                        </div>

                        <button type="button" v-if="!isAdmin" class="btn" data-bs-toggle="modal" data-bs-target="#modalSiswa" style="margin-top: 20px; background-color: #4154F1; color: white;">
                            <span>Tambah </span>
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <button type="button" v-if="isAdmin" class="btn" @click="handleSaveSiswaAdmin" style="margin-top: 20px; background-color: #4154F1; color: white;">
                            <span>Tambah </span>
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
                        <br/>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">No Telepon</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in siswa" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.telp }}</td>
                                    <td>{{ user.gender === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #25D366; color: white; margin-right:5px" @click="handleSendFormation(user.parent_number)" v-if="isAdmin"><span class="btn-label"><i class="bi bi-whatsapp"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm btn-primary" style="margin-right:5px" @click="handleDetailSiswa(user.nisn)"><span class="btn-label"><i class="bi bi-info-circle"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #4154F1; color: white;" @click="handleUpdateSiswa(user.nisn)" v-if="isAdmin"><span class="btn-label"><i class="bi bi-pencil-square"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #f1416d; color: white; margin-left:5px" @click="handleDeleteSiswa(user.nisn)" v-if="isAdmin"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" data-bs-toggle="modal" data-bs-target="#modalExportNilai" style="background-color: #00008B; color: white; margin-left:5px" v-if="isAdmin" @click="handleDownloadNilai(user.nisn)"><span class="btn-label"><i class="bi bi-file-earmark-arrow-down-fill"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #f1416d; color: white; margin-left:5px" @click="handleDeleteSiswaPerKelas(user.nisn)" v-if="!isAdmin"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

    </main>


    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>SMAN 1 CIWARU</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</template>
