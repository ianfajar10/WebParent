<script setup>
import { reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRoute } from 'vue-router'
import swal from 'sweetalert';

const router = useRouter()
const route = useRoute()

let model = reactive({
        title: '',
        text: '',
        id: route.params.idInfo ? route.params.idInfo : ''
    })

const addInfo = async () => {
    if (route.params.idInfo) {
        await axios.post('/api/information_update', model)
        .then(response => {
            if (response.data.success) {
                swal({
                    title: "Berhasil diubah!,",
                    text: response.data.message,
                    icon: "success",
                    button: false,
                    timer: 2500
                }).then(function () {
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
        await axios.post('/api/information', model)
        .then(response => {
            if (response.data.success) {
                swal({
                    title: "Berhasil ditambahkan!,",
                    text: response.data.message,
                    icon: "success",
                    button: false,
                    timer: 2500
                }).then(function () {
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
    if (route.params.idInfo) {
        var id = route.params.idInfo
        axios.get('/api/informasi_detail/' + id ).then((res) => {
            var informasi = res.data.data[0]

            var split1 = informasi.text.split('<p>')[1]
            var split2 = split1.split('</p>')[0]

            model.title = informasi.title
            model.text = split2
        })
    }
})

function close() {
    router.go(-1)
}
</script>
<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff" @click="close">
            X
        </button>
        <form @submit.prevent="addInfo">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-0 mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Pengumuman</h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Judul Pengumuman</label><input type="text" class="form-control" v-model="model.title"
                                placeholder="Masukkan judul pengumuman"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Isi Pengumuman</label><textarea type="text" class="form-control" v-model="model.text" style="height: 20vh;" placeholder="Masukkan isi pengumuman"></textarea></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Isi Penutup</label><input type="text" class="form-control"
                                placeholder="Masukkan Penutup" value="Admin" :disabled="true"></div>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary btn-lg"
                        style="margin-top: 10px; margin-bottom: 10px; padding-left: 2.5rem; padding-right: 2.5rem;" />
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
