<script>
import Swal from 'sweetalert2'

export default ({
    data() {
        return {
            user: null,
            informasi: [],
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
            isAdmin: true,
            selected_periode: null,
            btnExport: false,
            nisn : ''
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
        axios.get('/api/getInformasi').then((res) => {
            this.informasi = res.data.data
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
        handleDataSiswa() {
            this.$router.push('/admin/datasiswa')
        },
        handleHome() {
            this.$router.push('/admin/home')
        },
        handleInformasi() {
            this.$router.push('/admin/informasi')
        },
        handleKritik() {
            this.$router.push('/admin/kritik')
        },
        handleNilai() {
            this.$router.push('/admin/input-nilai')
        },
        handleUpdate(data) {
            this.$router.push({ name: 'adminUpdateInformasi', params:{idInfo:data}})
        },
        handleDelete(data) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk menghapus informasi ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/deleteInformasi', {id: data})
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
        handleExport() {
            var periode = this.selected_periode
            axios.get('/api/create-pdf-informasi/' + periode).then((res) => {
                console.log('Berhasil');
            })
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
                        <img src="https://static.vecteezy.com/system/resources/thumbnails/006/017/842/small_2x/customer-service-icon-user-with-laptop-computer-and-headphone-illustration-free-vector.jpg"
                            alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user }}</span>
                    </a><!-- End Profile Iamge Icon -->

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

            <li class="nav-item">
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
                <a class="nav-link collapsed" href="" v-if="!isAdmin" @click="handleNilai">
                    <i class="bi bi-book"></i>
                    <span>Input Nilai</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="" @click="handleInformasi">
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
            <h1>Pengumuman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" @click="handleHome">Home</a></li>
                    <li class="breadcrumb-item active">Pengumuman</li>
                </ol>
            </nav>
        </div>

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
                        <router-link class="btn" style="margin-top: 20px; background-color: #4154F1; color: white;"
                            to="/admin/tambah-informasi">
                            <span>Tambah </span>
                            <i class="bi bi-plus-circle-fill"></i>
                        </router-link>
                        <br />
                        <br />

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Isi</th>
                                    <th scope="col">Dibuat Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(info, index) in informasi" :key="index">
                                    <td>{{ info.title }}</td>
                                    <td>{{
                                            info.text.split('<p>')[1].split('</p>')[0]
                                        }}</td>
                                    <td>{{ info.created_at }}</td>
                                    <td><button type="button" class="btn" style="background-color: #4154F1; color: white; width: 100%;" @click="handleUpdate(info.id)">Ubah</button><button type="button" class="btn" style="background-color: #f1416d; color: white; margin-top: 10px; width: 100%;" @click="handleDelete(info.id)">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button v-if="btnExport" type="button" data-bs-toggle="modal" data-bs-target="#modalExport" class="btn btn-primary float-end">Cetak</button>
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

</template>
