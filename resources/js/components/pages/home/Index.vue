<script>
import Swal from 'sweetalert2'

export default ({
    data () {
        return {
            user : null,
            gender : null,
            events: ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],
            logoutTimer: null,
            nisn: '',
            kelas: 'Belum ada kelas',
            wali_kelas: 'Belum ada wali kelas'
        }
    },
    setup() {
    },
    async mounted() {
        var informasi = []
        this.user = this.$user.name
        this.nisn = this.$user.nisn
        if (this.user === 'admin') {
            this.$router.push('/admin/home')
        }

        await axios.get('/api/getInformasi').then((res) => {
            if ((res.data.data).length > 0) {
                informasi.push((res.data.data[0]))
                this.showSwal(informasi[0])
            }
        })

        await axios.get('/api/getKelasSiswa', { params: { nisn: this.$user.nisn } }).then((res) => {
            if (res.data.data[0]) {
                if (res.data.data[0].id_class) {
                    this.kelas = res.data.data[0].id_class
                    console.log(this.kelas);
                    this.searchWaliKelas(this.kelas)
                } else {
                    this.kelas = 'Belum ada kelas'
                }
            }
        })

        this.gender = this.$user.gender == 'L' ? 'https://cdn-icons-png.flaticon.com/512/1904/1904425.png' : 'https://cdn-icons-png.flaticon.com/512/2940/2940652.png'

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
        async searchWaliKelas(kelas) {
            await axios.get('/api/getWaliKelasSiswa', { params: { kelas: kelas } }).then((res) => {
                if (res.data.data[0]) {
                    if (res.data.data[0].name) {
                        this.wali_kelas = res.data.data[0].name
                    } else {
                        this.wali_kelas = 'Belum ada wali kelas'
                    }
                }
            })
        },
        handleLogout(){
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        showSwal(informasi){
            Swal.fire({
                title: 'Pengumuman',
                width: 1200,
                icon: 'info',
                html: informasi.text,
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
            })
        },
        handleKritik() {
            this.$router.push('/kritik')
        },
        handleInformasi() {
            this.$router.push('/informasi')
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
        <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img :src="gender" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ user }}</span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{ user }}</h6>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                <router-link class="dropdown-item d-flex align-items-center" to="/profile">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </router-link>
                </li>
                <li>
                    <router-link class="dropdown-item d-flex align-items-center" :to="'/change-password/' + nisn">
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

            </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <router-link class="nav-link" to="/">
                <i class="bi bi-grid"></i>
                <span>Index</span>
            </router-link>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <router-link class="nav-link collapsed" to="/index-prestasi">
                <i class="bi bi-journal"></i>
                <span>Indeks Prestasi</span>
            </router-link>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="" @click="handleInformasi">
                <i class="bi bi-info-circle-fill"></i>
                <span>Pengumuman</span>
            </a>
        </li><!-- End Pengumuman Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="" @click="handleKritik">
                <i class="bi bi-question-circle"></i>
                <span>Kritik & Saran</span>
            </a>
        </li><!-- End Kritik & Saran Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" @click="handleLogout">
            <i class="bi bi-box-arrow-left"></i>
            <span>Keluar</span>
            </a>
        </li><!-- End Contact Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
            <div class="row">

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-6">

                <div class="card info-card customers-card">

                    <div class="card-body">
                    <h5 class="card-title">Kelas</h5>

                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h6>{{ kelas }}</h6>
                        </div>
                    </div>

                    </div>
                </div>

                </div><!-- End Customers Card -->

                <!-- Reports -->
                <div class="col-6">
                <div class="card info-card customers-card">

                    <div class="card-body">
                    <h5 class="card-title">Wali Kelas</h5>

                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h6>{{ wali_kelas }}</h6>
                        </div>
                    </div>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    </div>

                </div>
                </div><!-- End Reports -->

            </div>
            </div><!-- End Left side columns -->

        </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>SMAN 1 Ciwaru</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</template>
