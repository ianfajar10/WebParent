<script setup>
import { reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRoute } from 'vue-router'
import swal from 'sweetalert';
import Swal from 'sweetalert2'

const router = useRouter()
const route = useRoute()

let model = reactive({
    name: '',
    nisn: route.params.nisn,
    selected_smester: 'GANJIL',
    selected_pelajaran: '',
    show: false,
    tugas: '',
    uts: '',
    uas: '',
    update: false,
    tahun_ajaran: (new Date().getFullYear() + 1) + '/' + (new Date().getFullYear())
})

let kelas = route.params.kelas

const pelajaran = reactive([])

const smester = [
        {
            text: "GANJIL",
            value: "GANJIL"
        },
        {
            text: "GENAP",
            value: "GENAP"
        },
    ]

    function close() {
        router.go(-1)
    }

    function handleSubmit() {
        if (model.selected_pelajaran) {
            model.show = true
            var nisn = model.nisn
            var pelajaran = model.selected_pelajaran
            var smester = model.selected_smester
            axios.get('/api/nilai_detail/' + nisn + '/' + kelas + '/' + pelajaran + '/' + smester).then((res) => {
                var nilai = res.data.data[0]
                console.log(nilai);
                model.tugas = nilai.tugas
                model.uts = nilai.uts
                model.uas = nilai.uas
                model.update = true
            })
        } else {
            swal({
                title: "Peringatan",
                text: "Pelajaran Belum Diisi!",
                icon: "error",
                button: false,
                timer: 2500
            })
        }
    }

const nilai = async () => {
    var mode = model.update ? 'mengubah' : 'menyimpan'
    await Swal.fire({
        icon: 'info',
        title: 'Yakin untuk ' + mode + ' data nilai?',
        showDenyButton: true,
        confirmButtonText: 'Ya, saya yakin',
        denyButtonText: `Batal`,
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('/api/nilai', {nisn: model.nisn, kelas: kelas, kd_pelajaran: model.selected_pelajaran, smester: model.selected_smester, tugas: model.tugas, uts: model.uts, uas: model.uas, mode: mode, tahun_ajaran: model.tahun_ajaran})
            .then(response => {
                if (response.data.success) {
                    swal({
                        title: "Berhasil disimpan!,",
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

onMounted(() => {
    var nisn = route.params.nisn

    console.log(model.tahun_ajaran);

    axios.get('/api/siswa_detail/' + nisn).then((res) => {
        var siswa = res.data.data[0]
        model.name = siswa.name
    })

    axios.get("/api/pelajaran").then((response) => {
        const array = []
        let data = response.data.data;
        array.push(data)
        array[0].forEach((item) => {
            pelajaran.push({
            label: item.name,
            code: item.id,
            });
        });
    });
})
</script>

<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff"
            @click="close">
            X
        </button>
        <div class="row">
            <div class="col-md-12 border-right">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-right">{{model.name}} (Kelas {{ kelas }})</h4>
                    </div>
                </div>
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
                        Pilih Pelajaran
                        <v-select
                        :options="pelajaran"
                        :reduce="(label) => label.code"
                        label="label"
                        v-model="model.selected_pelajaran"
                        ></v-select>
                        <button v-if="!model.show" value="Submit" class="btn btn-primary btn-lg" @click="handleSubmit" style="margin-top: 10px; margin-bottom: 10px; padding-left: 2.5rem; padding-right: 2.5rem;">Submit</button>
                    </div>
                    <div class="card-body" v-if="model.show" style="margin-top: 20px;">
                        <form @submit.prevent="nilai">
                            <div class="row ml-2 mr-2">
                                <div class="form-group row">
                                    <label class="col-sm-10 col-form-label">TUGAS</label>
                                    <div class="col-sm-2">
                                        <div class="col-md-2"></div>
                                        <input class="form-control" type="number" max="100" v-model="model.tugas">
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-10 col-form-label">UTS</label>
                                    <div class="col-sm-2">
                                        <div class="col-md-2"></div>
                                        <input class="form-control" type="number" max="100" v-model="model.uts">
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <label class="col-sm-10 col-form-label">UAS</label>
                                    <div class="col-sm-2">
                                        <div class="col-md-2"></div>
                                        <input class="form-control" type="number" max="100" v-model="model.uas">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <input type="submit" value="NILAI" class="btn btn-primary btn-lg mb-4"
                                    style="margin-top: 10px; padding-left: 2.5rem; padding-right: 2.5rem;" />
                            </div>
                        </form>
                    </div>
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
