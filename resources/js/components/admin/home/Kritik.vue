<script>

export default ({
    data() {
        return {
            user: null,
            kritik: [],
            isAdmin: true,
            btnExport: false,
            periode: [
                {
                    text: "1 BULAN",
                    value: "1"
                },
                {
                    text: "3 BULAN",
                    value: "3"
                },
                {
                    text: "6 BULAN",
                    value: "6"
                },
                {
                    text: "12 BULAN",
                    value: "12"
                },
            ],
            selected_periode: null,
            nisn : '',
            model: {
                text: '',
                id: '',
                parent_num: ''
            },
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

        axios.get('/api/getKritik').then((res) => {
            this.kritik = res.data.data
            if (res.data.data.length > 0) {
                this.btnExport = true
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
        handleDataSiswa(){
            this.isAdmin == true ? this.$router.push('/admin/datasiswa') : this.$router.push('/guru/datasiswa')
        },
        handleHome(){
            this.isAdmin == true ? this.$router.push('/admin/home') : this.$router.push('/guru/home')
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
        handleExport() {
            var periode = this.selected_periode
            axios.get('/api/create-pdf-kritik-saran/' + periode).then((res) => {
                console.log('Berhasil');
            })
        },
        handleBalas(id_kritik, parent_number) {
            this.model.id = id_kritik
            this.model.parent_num = parent_number
        },
        async handleKirim(){
            let vm = this
            let number = vm.model.parent_num
            let text = vm.model.text

            console.log(text);

            var changeTelp = number
            if (number[0] === '0') {
                changeTelp = number.replace(number[0], '62');
            }

            await axios.post('/api/balas_kritik', this.model)
            .then(response => {
                if (response.data.success) {
                    swal({
                        title: "Berhasil dikirim!,",
                        text: response.data.message,
                        icon: "success",
                        button: false,
                        timer: 2500
                    }).then(function () {
                        window.open("https://api.whatsapp.com/send/?phone="+ changeTelp + "&text=" + text + "&type=phone_number&app_absent=0");
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
                <a class="nav-link" href="" @click="handleKritik">
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
            <h1>Kritik & Saran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
                    <li class="breadcrumb-item active">Kritik & Saran</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalExportLabel">Pilih Periode</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <v-select
                                    :options="periode"
                                    :reduce="(text) => text.value"
                                    label="text"
                                    v-model="selected_periode"
                                    ></v-select>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" @click="handleExport">Proses</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal modal-lg fade" id="modalTanggapan" tabindex="-1" aria-labelledby="modalTanggapanLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="row justify-content-center">
                                        <div class="col-md-11">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTanggapanLabel">Tanggapan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="row mt-3">
                                                <input type="text" class="form-control" v-show="false" v-model="model.id">
                                                <div class="col-md-12"><textarea type="text"
                                                    class="form-control" v-model="model.text" style="height: 20vh;"
                                                    placeholder="Masukkan Tanggapan"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary" @click="handleKirim">Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Kritik/Saran</th>
                                    <th scope="col">Tanggapan</th>
                                    <th scope="col">Dipublikasikan Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(kritik, index) in kritik" :key="index">
                                    <td>{{ kritik.kategori }}</td>
                                    <td>{{ kritik.text }}</td>
                                    <td>{{ kritik.text_answer ? kritik.text_answer : 'Belum ada tanggapan' }} <button v-if="!kritik.text_answer" type="button" data-bs-toggle="modal" data-bs-target="#modalTanggapan" class="btn btn-primary btn-sm" @click="handleBalas(kritik.id, kritik.parent_number)"><i class="bi bi-reply-fill"></i> Balas</button></td>
                                    <td>{{ kritik.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <button v-if="btnExport" type="button" data-bs-toggle="modal" data-bs-target="#modalExport" class="btn btn-primary float-end">Cetak</button>
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
