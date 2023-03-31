<script>
import Swal from 'sweetalert2'

export default ({
    data () {
        return {
            user : null,
            gender : null,
            events: ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],
            logoutTimer: null,
            model: {
                show: false,
                selected_smester: 'GANJIL',
                selected_kelas: '',
                show: false,
                tugas: '',
                uts: '',
                uas: '',
            },
            nilai: [],
            smester: [
                {
                    text: "GANJIL",
                    value: "GANJIL"
                },
                {
                    text: "GENAP",
                    value: "GENAP"
                },
            ],
            cur_kelas: [],
        }
    },
    setup() {
    },
    mounted() {
        this.user = this.$user.name
        if (this.user === 'admin') {
            this.$router.push('/admin/home')
        }
        this.gender = this.$user.gender == 'L' ? 'https://cdn-icons-png.flaticon.com/512/1904/1904425.png' : 'https://cdn-icons-png.flaticon.com/512/2940/2940652.png'
        var nisn = this.$user.nisn
        axios.get("/api/kelas_siswa/" + nisn).then((response) => {
            let data = response.data.data;
            data.forEach((item) => {
                this.cur_kelas.push({
                    label: item.name,
                    code: item.id,
                });
            });
        });
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
        handleLogout(){
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        handleKritik() {
            this.$router.push('/kritik')
        },
        handleInformasi() {
            this.$router.push('/informasi')
        },
        async handleSubmit() {
            var nisn = this.$user.nisn
            var kelas = this.model.selected_kelas
            var smester = this.model.selected_smester
            if (this.model.selected_kelas) {
                await axios.get("/api/nilai_pelajaran/" + nisn + '/' + kelas + '/' + smester).then((response) => {
                    let data = response.data.data;
                    this.nilai.push(data)
                });
                this.model.show = true
            } else {
                swal({
                    title: "Peringatan",
                    text: "Kelas Belum Dipilih!",
                    icon: "error",
                    button: false,
                    timer: 2500
                })
            }
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

        <li class="nav-item collapsed">
            <router-link class="nav-link collapsed" to="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </router-link>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <router-link class="nav-link" to="/index-prestasi">
                <i class="bi bi-journal"></i>
                <span>Indeks Prestasi</span>
            </router-link>
        </li><!-- End Prestasi Page Nav -->

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
        <h1>Indeks Prestasi</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Indeks Prestasi</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-md-12 border-right">
                    <div class="card col-md-12">
                        <div style="margin-top: 10px;margin-right: 2%; margin-left: 2%">
                            Pilih Semester
                            <v-select
                            :options="smester"
                            :reduce="(text) => text.value"
                            label="text"
                            v-model="model.selected_smester"
                            ></v-select>
                            <br>
                            Pilih Kelas
                            <v-select
                            :options="cur_kelas"
                            :reduce="(label) => label.code"
                            label="label"
                            v-model="model.selected_kelas"
                            ></v-select>
                            <button v-if="!model.show" value="Submit" class="btn btn-primary btn-lg" @click="handleSubmit" style="margin-top: 10px; margin-bottom: 10px; padding-left: 2.5rem; padding-right: 2.5rem;">Submit</button>
                        </div>
                        <div class="card-body" v-if="model.show" style="margin-top: 20px;">
                            <div>
                                <!-- Bordered Table -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Pelajaran</th>
                                            <th scope="col">Tugas</th>
                                            <th scope="col">UTS</th>
                                            <th scope="col">UAS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(nilai, index) in nilai[0]" :key="index">
                                            <td>{{ nilai.name }}</td>
                                            <td>{{ nilai.tugas }}</td>
                                            <td>{{ nilai.tugas }}</td>
                                            <td>{{ nilai.tugas }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</template>
