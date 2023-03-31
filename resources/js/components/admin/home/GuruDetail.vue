<script>
import Swal from 'sweetalert2'

export default ({
    data () {
        return {
            model : {
                name : '',
                gender: '',
                religion: '',
                telp: '',
                birth: '',
                email: '',
                alamat: '',
                nisn: ''
            },
        }
    },
    mounted() {
        var nisn = this.$route.params.nisn
        axios.get('/api/guru_detail/' + nisn ).then((res) => {
            var guru = res.data.data[0]

            var months = [null, "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"]

            var genders = ["Laki - Laki", "Perempuan"]
            var selectedGender = genders[guru.gender == 'L' ? 0 : 1]
            var selectedMonthName = months[parseInt(guru.birth.substr(3, 2))]

            this.model.nisn = nisn
            this.model.name = guru.name
            this.model.telp = guru.telp
            this.model.gender = selectedGender
            this.model.religion = guru.religion
            this.model.birth = guru.birth.substr(0, 2) + " " + selectedMonthName + " " + guru.birth.substr(6, 4)
            this.model.email = guru.email
            this.model.alamat = guru.address
        })
    },
    created() {
    },
    methods: {
        logout(){
            localStorage.removeItem('token')
            this.$router.go('/')
        },
        close(){
            this.$router.go(-1)
        },
        handleReset(nisn, birth) {
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk mengatur ulang kata sandi?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/resetPassword', {nisn: nisn, birth: birth})
                    .then(response => {
                        if (response.data.success) {
                            swal({
                                title: "Berhasil direset! Kata sandi diatur kembali (sesuai nomor nip),",
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
        }
    },
})
</script>

<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff" @click="close">
                X
            </button>
        <div class="row">
            <div class="col-md-12 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profil Guru</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">NISN</label><input type="text" class="form-control"
                                placeholder="Masukkan nisn" v-model="model.nisn" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Nama</label><input type="text" class="form-control" placeholder="Masukkan nama" v-model="model.name" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Nomor Telepon</label><input type="text" class="form-control" placeholder="Masukkan nomor telepon" v-model="model.telp" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Jenis Kelamin</label><input type="text" class="form-control" placeholder="Masukkan jenis kelamin" v-model="model.gender" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Agama</label><input type="text" class="form-control" placeholder="Masukkan agama" v-model="model.religion" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Tanggal Lahir</label><input type="text" class="form-control" placeholder="Masukkan tanggal lahir" v-model="model.birth" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="Masukkan email" v-model="model.email" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Alamat</label><textarea type="text" class="form-control" placeholder="Masukkan alamat" v-model="model.alamat" :disabled="true"></textarea></div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-primary" @click="handleReset(model.nisn, model.birth_reset)">Atur Ulang Kata Sandi</button>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
body {
    background: rgb(99, 39, 120)
}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
</style>
