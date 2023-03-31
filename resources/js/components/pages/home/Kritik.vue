<script>
import { reactive } from 'vue'
import swal from 'sweetalert';

export default ({
    data() {
        return {
            user: null,
            kritik_saran: [],
            model: reactive({
                nisn: this.$user.nisn,
                text: '',
                selected_kategori: ''
            }),
            gender: '',
            kategori: [
                { 'value': 'Kebersihan', 'text': 'Kebersihan' },
                { 'value': 'Fasilitas', 'text': 'Fasilitas' },
                { 'value': 'Pengajaran', 'text': 'Pengajaran' },
                { 'value': 'Lingkungan', 'text': 'Lingkungan' },
                { 'value': 'Lainnya', 'text': 'Lainnya' }
            ],
            selected_kategori: null
        }
    },
    setup() {
    },
    mounted() {
        this.user = this.$user.name
        this.gender = this.$user.gender == 'L' ? 'https://cdn-icons-png.flaticon.com/512/1904/1904425.png' : 'https://cdn-icons-png.flaticon.com/512/2940/2940652.png'
        axios.get('/api/getKritik', { params: { nisn: this.$user.nisn } }).then((res) => {
            this.kritik_saran = res.data.data
            console.log(this.kritik_saran);
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
        handleInformasi() {
            this.$router.push('/informasi')
        },
        async addKritikSaran(){
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
                            window.location.reload()
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
        }
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
                    </ul>
                </li>

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
                <a class="nav-link collapsed" href="" @click="handleInformasi">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Pengumuman</span>
                </a>
            </li><!-- End Pengumuman Page Nav -->

            <li class="nav-item">
                <a class="nav-link" href="" @click="handleKritik">
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
            <h1>Kritik & Saran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
                    <li class="breadcrumb-item active">Kritik & Saran</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <button class="btn" style="margin-top: 20px; background-color: #4154F1; color: white;"  data-bs-toggle="modal" data-bs-target="#modalKritikSaran">
                <span>Tambah </span>
                <i class="bi bi-plus-circle-fill"></i>
            </button>
            <br>
            <br>
            <div class="row">
                <!-- Modal -->
                <div class="modal modal-lg fade" id="modalKritikSaran" tabindex="-1" aria-labelledby="modalKritikSaranLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form @submit.prevent="addKritikSaran">
                                <div class="row justify-content-center">
                                    <div class="col-md-11">
                                        <br>
                                        <div>Pilih Kategori:</div>

                                        <select class="form-select" v-model="model.selected_kategori">
                                            <option v-for="kategori in kategori" :value="kategori.value" :key="kategori.id">{{kategori.text}}</option>
                                        </select>

                                        <div class="row mt-3">
                                            <div class="col-md-12"><textarea type="text"
                                                    class="form-control" v-model="model.text" style="height: 20vh;"
                                                    placeholder="Masukkan kritik dan saran"></textarea></div>
                                        </div>
                                        <input type="submit" value="Kirim" class="btn btn-primary btn-lg"
                                            style="margin-top: 10px; margin-bottom: 10px; padding-left: 2.5rem; padding-right: 2.5rem;" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card" v-for="(kritiksaran, index) in kritik_saran" :key="index">
                    <div class="card-body" style="margin-top:10px">
                        <p><strong>{{ kritiksaran.kategori }}</strong></p>
                        <p>{{ kritiksaran.text }}</p>
                        <small>Diposting pada tanggal {{ kritiksaran.created_at }}</small>
                        <div class="float-end">
                            <a v-if="kritiksaran.text_answer" class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#modalLihatJawaban">
                                <small>Lihat Tanggapan</small>
                            </a>
                            <p v-if="!kritiksaran.text_answer">Belum ada tanggapan...</p>
                        </div>
                        <div class="modal modal-lg fade" id="modalLihatJawaban" tabindex="-1" aria-labelledby="modalLihatJawabanLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="row justify-content-center">
                                        <div class="col-md-11">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="margin-left: -3%" id="modalLihatJawabanLabel">Tanggapan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="row mt-3">
                                                <p>{{ kritiksaran.text_answer }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                Hormat, Admin
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

</template>
