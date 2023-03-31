<script>

export default ({
    data () {
        return {
            user: null,
            events: [ 'click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load' ],
            logoutTimer: null,
            count_siswa: '',
            count_kritik: '',
            isAdmin: true,
            penjualan: [],
            nisn: ''
        }
    },
    setup() {
    },
    mounted() {
        this.nisn = this.$user.nisn
        if (this.$user.nisn != 'admin') {
            this.isAdmin = false
        }
        this.user = this.$user.name
        axios.get('/api/count_siswa').then((res) => {
            var result = res.data.data[0]
            this.count_siswa = result.count_siswa
        })
        axios.get('/api/count_kritik_total').then((res) => {
            var result = res.data.data[0]
            this.count_kritik = result.count_kritik
        })
        axios.get('/api/count_kritik').then((res) => {
            var result = res.data.data[0]
            var object = res.data.data.reduce((obj, item) => Object.assign(obj, { [item.kategori]: item.count_kritik }), {});
            this.penjualan.push(object)
        })
    },
    created() {
        this.events.forEach(function (event) {
            window.addEventListener(event, function () {
                if (event) {
                    clearTimeout(this.logoutTimer)
                    this.logoutTimer = setTimeout(() => {
                        localStorage.removeItem('token')
                    }, 600000)
                } else {
                    this.logoutTimer = setTimeout(() => {
                        localStorage.removeItem('token')
                    }, 600000)
                }
            })
        })
    },
    methods: {
        logout(){
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
            this.$router.go()
        },
        handleInformasi() {
            this.$router.push('/admin/informasi')
        },
        handleKritik() {
            this.isAdmin == true ? this.$router.push('/admin/kritik') : this.$router.push('/guru/kritik')
        },
        handleNilai() {
            this.isAdmin == true ? this.$router.push('/admin/datasiswa') : this.$router.push('/guru/input-nilai')
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
                <a class="dropdown-item d-flex align-items-center" href="#" @click="logout">
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
            <a class="nav-link " href="" @click="handleHome">
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
            <a class="nav-link collapsed" href="#" @click="logout">
            <i class="bi bi-box-arrow-left"></i>
            <span>Keluar</span>
            </a>
        </li>

        </ul>

    </aside>

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        </div>

        <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
            <div class="row">
                <div class="col-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                    <h5 class="card-title">Siswa</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{count_siswa}}</h6>
                        </div>
                    </div>
                    </div>
                </div>

                </div>
                <div class="col-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                    <h5 class="card-title">Laporan</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-chat-square-dots"></i>
                        </div>
                        <div class="ps-3">
                        <h6>{{count_kritik}}</h6>
                        </div>
                    </div>
                    <div id="reportsChart"></div>
                    </div>
                </div>
                </div>

                <h3>Kritik Saran</h3>
            <p>Jumlah Laporan Kritik Saran 1 Bulan Terakhir</p>
            <line-chart :data="penjualan[0]"></line-chart>
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
