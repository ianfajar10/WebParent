<script>
import { useRouter } from 'vue-router'

const router = useRouter()

export default ({
    data() {
        return {
            user: null,
            informasi: [],
            siswa: [],
            isAdmin: true,
            kelas: '',
            nisn : ''
        }
    },
    setup() {
        },
    async mounted() {
        this.nisn = this.$user.nisn
        if (this.$user.nisn != 'admin') {
            this.isAdmin = false
        }
        this.user = this.$user.name

        await axios.get('/api/siswa_per_class', { params: { nisn: this.$user.nisn } }).then((res) => {
            this.siswa = res.data.data
        })

        await axios.get('/api/getKelas', { params: { nisn: this.$user.nisn } }).then((res) => {
            if (res.data.data[0]) {
                if (res.data.data[0].id) {
                    this.kelas = res.data.data[0].id
                }
            } else {
                this.$router.push('/guru/tidak-ada-kelas')
            }
        })
    },
    created() {
    },
    methods: {
        handleLogout() {
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        handleDataGuru(){
            this.$router.push('/admin/dataguru')
        },
        handleDataSiswa() {
            this.isAdmin == true ? this.$router.push('/admin/datasiswa') : this.$router.push('/guru/datasiswa')
        },
        handleHome() {
            this.isAdmin == true ? this.$router.push('/admin/home') : this.$router.push('/guru/home')
        },
        handleInformasi() {
            this.$router.push('/admin/informasi')
        },
        handleKritik() {
            this.isAdmin == true ? this.$router.push('/admin/kritik') : this.$router.push('/guru/kritik')
        },
        handleNilai() {
            this.isAdmin == true ? this.$router.push('/admin/input-nilai') : this.$router.push('/guru/input-nilai')
        },
        handleNilaiSiswa(data) {
            this.$router.push({ name: 'guruNilaiSiswa', params: { nisn: data, kelas: this.kelas } })
        },
        handleDataKelas() {
            this.$router.push('/admin/datakelas')
        },
    },
})
</script>

<template>
    <!-- ======= Header ======= -->
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
                        <img src="https://static.vecteezy.com/system/resources/thumbnails/006/017/842/small_2x/customer-service-icon-user-with-laptop-computer-and-headphone-illustration-free-vector.jpg"
                            alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ user }}</h6>
                        </li>
                        <li v-if="!isAdmin">
                            <router-link class="dropdown-item d-flex align-items-center" :to="'/guru/change-password/' + nisn">
                                <i class="bi bi-key-fill"></i>
                                <span>Ganti Kata Sandi</span>
                            </router-link>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
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

    <!-- ======= Sidebar ======= -->
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
                <a class="nav-link collapsed" href="" @click="handleDataSiswa">
                    <i class="bi bi-people"></i>
                    <span>Data Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" @click="handleNilai">
                    <i class="bi bi-book"></i>
                    <span>Input Nilai</span>
                </a>
            </li>
            <li class="nav-item" v-if="isAdmin">
                <a class="nav-link collapsed" href="" @click="handleInformasi">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Informasi</span>
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
            <h1>Input Nilai <small>(Kelas {{ kelas }})</small></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
                    <li class="breadcrumb-item active">Input Nilai</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">

                <div class="card">
                    <div class="card-body" style="margin-top: 20px;">
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in siswa" :key="index">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td>{{ user.name }}</td>
                                        <td><button type="button" class="btn" style="background-color: #4154F1; color: white;"
                                                @click="handleNilaiSiswa(user.nisn)">Nilai</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SMAN 1 CIWARU</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

</template>
