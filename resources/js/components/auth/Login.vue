<script setup>
    import { reactive } from 'vue'
    import { useRouter } from 'vue-router'
    import swal from 'sweetalert';

    const router = useRouter()

    let form = reactive({
        email: '',
        password: ''
    })

    const login = async() => {
        await axios.post('/api/login', form)
        .then(response => {
            if (response.data.success) {
                if (response.data.name === 'admin') {
                    localStorage.setItem('token', response.data.data.token)
                    swal({
                        title: "Berhasil masuk!,",
                        text: response.data.message,
                        icon: "success",
                        button: false,
                        timer: 2500
                    }).then(function() {
                        router.push('/admin/home')
                    });
                } else {
                    localStorage.setItem('token', response.data.data.token)
                    swal({
                        title: "Berhasil masuk!,",
                        text: response.data.message,
                        icon: "success",
                        button: false,
                        timer: 2500
                    }).then(function() {
                        router.push('/')
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
                    <img src="https://media.istockphoto.com/id/1394000588/vector/graduate-student-with-his-proud-parents.jpg?s=612x612&w=0&k=20&c=zWO8ZtR0Izisjb4atrMjGFzyCBPg-ry0jarsBYPsZ-o="
                    class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form @submit.prevent="login">
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-0 mb-0">SELAMAT DATANG</p>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Masukkan email valid" v-model="form.email"/>
                        </div>
                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="form-control form-control-lg"
                            placeholder="Masukkan kata sandi" v-model="form.password"/>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                            Ingat saya
                            </label>
                            </div>
                            <a href="#!" class="text-body">Lupa kata sandi?</a>
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <input type="submit" value="Masuk" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;"/>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Belum punya akun ? <router-link to="/register" class="link-danger">Klik disini</router-link></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Webparent Copyright © 2022. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>

            </div>
            <!-- Right -->
        </div>
    </section>
</template>
