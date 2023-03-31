<script setup>
    import { reactive, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import swal from 'sweetalert';

    const router = useRouter()

    let form = reactive({
        nisn: '',
        password: ''
    })

    const login = async() => {
        await axios.post('/api/login', form)
        .then(response => {
            if (response.data.success) {
                if (response.data.data.name === 'admin' || (response.data.data.nisn).substring(0, 3) === "GU-") {
                    localStorage.setItem('token', JSON.stringify(response.data.data))
                    swal({
                    title: "Berhasil masuk!,",
                    text: response.data.message,
                    icon: "success",
                    button: false,
                    timer: 2500
                    }).then(function() {
                        if ((response.data.data.nisn).substring(0, 3) === "GU-") {
                            router.push('/guru/home').then(() => { router.go() })
                        } else {
                            router.push('/admin/home').then(() => { router.go() })
                        }
                    });
                } else {
                    localStorage.setItem('token', JSON.stringify(response.data.data))
                    swal({
                    title: "Berhasil masuk!,",
                    text: response.data.message,
                    icon: "success",
                    button: false,
                    timer: 2500
                    }).then(function() {
                        router.push('/').then(() => { router.go() })
                    });
                }
            } else {
                swal({
                    title: "Mohon Maaf,",
                    text: response.data.message,
                    icon: "error",
                    button: false,
                    timer: 2500
                });
            }
        })
    }
</script>
<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .h-custom {
        height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
</style>
<template>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="/assets/img/vector_login.png" alt="logo">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form @submit.prevent="login">
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-0 mb-0">SELAMAT DATANG</p>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Masukkan nomor NIP/NISN" v-model="form.nisn"/>
                        </div>
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="form-control form-control-lg"
                            placeholder="Masukkan kata sandi" v-model="form.password"/>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <input type="submit" value="Masuk" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0">
                SMAN 1 CIWARU Copyright © 2022. All rights reserved.
            </div>
            <div>
            </div>
        </div>
    </section>
</template>
