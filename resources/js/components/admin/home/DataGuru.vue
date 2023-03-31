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
            guru: [],
            isAdmin: true,
            nisn: ''
        }
    },
    setup() {
    },
    mounted() {
        if (this.$user.nisn != 'admin') {
            this.isAdmin = false
        }
        this.nisn = this.$user.nisn
        this.user = this.$user.name
        var param = null
        axios.get('/api/guru/' + param).then((res) => {
            this.guru = res.data.data
        })
    },
    created() {
    },
    methods: {
        handleLogout(){
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        handleDataGuru(){
            this.$router.push('/admin/dataguru')
        },
        handleDataSiswa(){
            this.$router.push('/admin/datasiswa')
        },
        handleHome(){
            this.$router.push('/admin/home')
        },
        handleInformasi(){
            this.$router.push('/admin/informasi')
        },
        handleDetailGuru(data){
            this.$router.push({ name: 'adminGuruDetail', params: { nisn: data }})
        },
        handleKritik() {
            this.$router.push('/admin/kritik')
        },
        handleNilai() {
            this.$router.push('/admin/input-nilai')
        },
        handleUpdateGuru(data) {
            this.$router.push({ name: 'adminUpdateGuru', params:{idGuru:data}})
        },
        handleDeleteGuru(data) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk menghapus guru ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteGuru', {nisn: data})
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
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link" href="" @click="handleDataGuru">
            <i class="bi bi-person"></i>
            <span>Data Guru</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="" @click="handleDataSiswa">
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

        <li class="nav-item">
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
        <h1>Data Guru</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
            <li class="breadcrumb-item active">Data Guru</li>
            </ol>
        </nav>
        </div>

        <section class="section dashboard">
            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <router-link class="btn" style="margin-top: 20px; background-color: #4154F1; color: white;" to="/admin/tambah-dataguru">
                            <span>Tambah </span>
                            <i class="bi bi-plus-circle-fill"></i>
                        </router-link>
                        <br/>
                        <br/>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in guru" :key="index">
                                    <th scope="row">{{ index+1 }}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.gender }}</td>
                                    <td>
                                        <button type="button" class="btn btn-labeled btn-sm btn-primary" style="margin-right:5px" @click="handleDetailGuru(user.nisn)"><span class="btn-label"><i class="bi bi-info-circle"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #4154F1; color: white;" @click="handleUpdateGuru(user.nisn)"><span class="btn-label"><i class="bi bi-pencil-square"></i></span></button>
                                        <button type="button" class="btn btn-labeled btn-sm" style="background-color: #f1416d; color: white; margin-left:5px" @click="handleDeleteGuru(user.nisn)"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
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
