<script>
import { reactive } from 'vue'
import swal from 'sweetalert';

export default ({
    data() {
        return {
            user: null,
            informasi: [],
            model: reactive({
                nisn: this.$user.nisn,
                text: '',
            }),
            gender: '',
            informasi: [],
        }
    },
    setup() {
    },
    mounted() {
        this.user = this.$user.name
        this.gender = this.$user.gender == 'L' ? 'https://cdn-icons-png.flaticon.com/512/1904/1904425.png' : 'https://cdn-icons-png.flaticon.com/512/2940/2940652.png'
        axios.get('/api/getInformasi').then((res) => {
            this.informasi = res.data.data
        })
    },
    created() {
    },
    methods: {
        handleLogout() {
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        handleHome() {
            this.$router.push('/')
        },
        handleKritik() {
            this.$router.push('/kritik')
        },
        async addInfo(){
            let vm = this
            await axios.post('/api/kritik', this.model)
                .then(response => {
                    if (response.data.success) {
                        swal({
                            title: "Berhasil ditambahkan!,",
                            text: response.data.message,
                            icon: "success",
                            button: false,
                            timer: 2500
                        }).then(function () {
                            vm.$router.push('/')
                        });
                    } else {
                        swal({
                            title: "Peringatan",
                            text: "Periksa kembali formulir!",
                            icon: "error",
                            button: false,
                            timer: 2500
                        })
                    }
                })
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
                        <img :src="gender"
                            alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ user }}</h6>
                        </li>
                        <li>
                            <router-link class="dropdown-item d-flex align-items-center" to="/profile">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link class="dropdown-item d-flex align-items-center" to="/change-password">
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
                <a class="nav-link collapsed" href="" @click="handleHome">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <router-link class="nav-link collapsed" to="/index-prestasi">
                    <i class="bi bi-journal"></i>
                    <span>Indeks Prestasi</span>
                </router-link>
            </li><!-- End Prestasi Page Nav -->

            <li class="nav-item">
                <a class="nav-link" href="" @click="handleInformasi">
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
            <h1>Pengumuman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
                    <li class="breadcrumb-item active">Pengumuman</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="card" v-for="(info, index) in informasi" :key="index">
                    <div class="card-body" style="margin-top:10px">
                        <p><strong>{{ info.title }}</strong></p>
                        <small>Dibuat oleh Staf TU, pada tanggal {{ info.updated_at }}</small>
                        <div class="float-end">
                            <router-link class="dropdown-item d-flex align-items-center" :to="'/informasi/detail/' + info.id">
                                <small>Lihat lebih...</small>
                            </router-link>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SMAN 1 Ciwaru</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

</template>
