<script setup>
    import { reactive, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useRoute } from 'vue-router'
    import swal from 'sweetalert';

    const router = useRouter()
    const route = useRoute()

    let submit = route.params.idSiswa ? 'Ubah' : 'Submit'

    let model = reactive({
        nisn: '',
        name: '',
        telp: '',
        gender: '',
        address: '',
        parent_name: '',
        parent_number: '',
        parent_work: '',
        birth_day: '',
        birth_month: '',
        birth_year: '',
        email: '',
        password: '',
        c_password: ''
    })

    const register = async() => {
        if (route.params.idSiswa) {
            await axios.post('/api/register_update', model)
            .then(response => {
                if (response.data.success) {
                    swal({
                        title: "Berhasil diubah!,",
                        text: response.data.message,
                        icon: "success",
                        button: false,
                        timer: 2500
                    }).then(function() {
                        router.go(-1)
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
        } else {
            await axios.post('/api/register', model)
            .then(response => {
                if (response.data.success) {
                    swal({
                        title: "Berhasil disimpan!",
                        text: response.data.message,
                        icon: "success",
                        button: false,
                        timer: 2500
                    }).then(function() {
                        router.go(-1)
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
    }

    onMounted(() => {
        if (route.params.idSiswa) {
            var nisn = route.params.idSiswa
            axios.get('/api/siswa_detail/' + nisn ).then((res) => {
                var siswa = res.data.data[0]

                var months = [null, "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"]

                model.nisn = nisn
                model.name = siswa.name
                model.telp = siswa.telp
                model.gender = siswa.gender
                model.birth_day = siswa.birth.substr(0, 2)
                model.birth_month = siswa.birth.substr(3, 2)
                model.birth_year = siswa.birth.substr(6, 4)
                model.email = siswa.email
                model.address = siswa.address
                model.parent_work = siswa.parent_work
                model.parent_name = siswa.parent_name
                model.parent_number = siswa.parent_number
            })
        }
    })

    function close() {
        router.go(-1)
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
        } else {
        return true;
        }
    }
</script>
<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff"
            @click="close">
            X
        </button>
        <form @submit.prevent="register">
            <div class="row">
                <div class="col-md-6 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profil Siswa</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">NISN</label><input type="text" class="form-control"
                                    maxlength="10" minlength="10" @keypress="isNumber($event)" placeholder="Masukkan nisn" v-model="model.nisn" :disabled="route.params.idSiswa"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Nama</label><input type="text" class="form-control"
                                    placeholder="Masukkan nama" v-model="model.name"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Nomor Telepon</label><input type="text"
                                    maxlength="15" minlength="12" @keypress="isNumber($event)" class="form-control" placeholder="Masukkan nomor telepon" v-model="model.telp"></div>
                        </div>
                        <div class="row mt-3">
                            <label class="labels">Tanggal Lahir</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="model.birth_day" @keypress="isNumber($event)" placeholder="Tanggal" maxlength="2" aria-label="Username">
                            <span class="input-group-text">/</span>
                            <input type="text" class="form-control" v-model="model.birth_month" @keypress="isNumber($event)" placeholder="Bulan" maxlength="2" aria-label="Server">
                            <span class="input-group-text">/</span>
                            <input type="text" class="form-control" v-model="model.birth_year" @keypress="isNumber($event)" placeholder="Tahun" maxlength="4" aria-label="Server">
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Email</label><input type="email" class="form-control"
                                    placeholder="Masukkan email" v-model="model.email"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Jenis Kelamin</label>
                                <br />
                                <input type="radio" v-model="model.gender" value="L"> Laki-Laki
                                <input type="radio" v-model="model.gender" value="P"> Perempuan
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Agama</label><input type="text" class="form-control"
                                    placeholder="Masukkan agama" maxlength="20" v-model="model.religion"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Alamat</label><textarea type="text" class="form-control"
                                    placeholder="Masukkan alamat" v-model="model.address"></textarea></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience"><span>Data Orangtua</span>
                        </div><br>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Nama Ayah/Ibu (cth: Ahmad/Siti)</label><input type="text"
                                    class="form-control" placeholder="Masukkan nama ayah/nama ibu" v-model="model.parent_name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Nomor Telepon</label><input type="text"
                                    class="form-control" maxlength="15" minlength="12" @keypress="isNumber($event)" placeholder="Masukkan nomor telepon valid" v-model="model.parent_number">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Pekerjaan Ayah/Ibu (cth: Guru/Ibu Rumah
                                    Tangga)</label><input type="text" class="form-control" placeholder="Masukkan pekerjaan"
                                    v-model="model.parent_work"></div>
                        </div>
                        <input type="submit" :value="submit" class="btn btn-primary btn-lg"
                            style="margin-top: 10px; padding-left: 2.5rem; padding-right: 2.5rem;" />
                    </div>
                </div>
            </div>
        </form>
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
<style>
</style>
