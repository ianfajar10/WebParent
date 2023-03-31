<script>
import Swal from 'sweetalert2'
export default ({
    data () {
        return {
            model : {
                password : '',
                conf_password : '',
            },
        }
    },
    mounted() {
    },
    created() {
    },
    methods: {
        close(){
            this.$router.go(-1)
        },
        handleChangePassword() {
            let vm = this
            Swal.fire({
                icon: 'info',
                title: 'Yakin untuk mengganti kata sandi?',
                showDenyButton: true,
                confirmButtonText: 'Ya, saya yakin',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/changePassword', {nisn: this.$route.params.nisn, password: this.model.password, conf_password: this.model.conf_password})
                    .then(response => {
                        if (response.data.success) {
                            swal({
                                title: "Berhasil diubah!",
                                text: response.data.message,
                                icon: "success",
                                button: false,
                                timer: 2500
                            }).then(function() {
                                vm.$router.push('/')
                            });
                        } else {
                            swal({
                                title: "Peringatan",
                                text: "Periksa kembali password dan konfirmasi password!",
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff" @click="close">
                            X
                        </button>
                    </div>
                    <div class="card-body">
                        <br>
                        <form method="POST" @submit.prevent="handleChangePassword">
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="model.password" autofocus required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="conf_password" class="col-md-4 col-form-label text-md-end">Konfirmasi Password</label>
                                <div class="col-md-6">
                                    <input id="conf_password" type="password" class="form-control" name="conf_password" v-model="model.conf_password" required>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Ubah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
</style>
