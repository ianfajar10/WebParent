import { createRouter, createWebHistory } from "vue-router";

import homeAdminIndex from '../components/admin/home/Index.vue';
import adminDataKelas from '../components/admin/home/DataKelas.vue';
import adminDataGuru from '../components/admin/home/DataGuru.vue';
import changeGuruPasswordIndex from '../components/admin/home/ChangePassword.vue';
import adminGuruDetail from '../components/admin/home/GuruDetail.vue';
import tambahDataGuru from '../components/admin/home/form/DataGuruForm.vue';
import adminDataSiswa from '../components/admin/home/DataSiswa.vue';
import tambahDataSiswa from '../components/admin/home/form/DataSiswaForm.vue';
import adminInputNilai from '../components/admin/home/InputNilai.vue';
import adminNilaiSiswa from '../components/admin/home/form/InputNilaiForm.vue';
import adminInformasi from '../components/admin/home/Informasi.vue';
import adminTambahInformasi from '../components/admin/home/form/InformasiForm.vue';
import adminKritik from '../components/admin/home/Kritik.vue';
import adminSiswaDetail from '../components/admin/home/SiswaDetail.vue';
import homePagesIndex from '../components/pages/home/Index.vue';
import profilePagesIndex from '../components/pages/home/Profile.vue';
import changePasswordIndex from '../components/pages/home/ChangePassword.vue';
import pagesKritik from '../components/pages/home/Kritik.vue';
import pagesIndexPrestasi from '../components/pages/home/IndexPrestasi.vue';
import pagesInformasi from '../components/pages/home/Informasi.vue';
import pagesInformasiDetail from '../components/pages/home/InformasiDetail.vue';
import notFound from '../components/NotFound.vue';
import guruTidakAdaKelas from '../components/admin/home/TidakAdaKelas.vue';
import login from '../components/auth/Login.vue';
import register from '../components/auth/Register.vue';
import notAccess from '../components/NotAccess.vue';

const routes = [
    {
        path: '/register',
        name: 'Register',
        component: register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/admin/home',
        name: 'adminHome',
        component: homeAdminIndex,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/home',
        name: 'guruHome',
        component: homeAdminIndex,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/datakelas',
        name: 'adminDataKelas',
        component: adminDataKelas,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/dataguru',
        name: 'adminDataGuru',
        component: adminDataGuru,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/guru-detail/:nisn?',
        name: 'adminGuruDetail',
        component: adminGuruDetail,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/tambah-dataguru',
        name: 'adminTambahDataGuru',
        component: tambahDataGuru,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/update-dataguru/:idGuru?',
        name: 'adminUpdateGuru',
        component: tambahDataGuru,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/datasiswa',
        name: 'adminDataSiswa',
        component: adminDataSiswa,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/datasiswa',
        name: 'guruDataSiswa',
        component: adminDataSiswa,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/siswa-detail/:nisn?',
        name: 'adminSiswaDetail',
        component: adminSiswaDetail,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/tambah-datasiswa',
        name: 'adminTambahDataSiswa',
        component: tambahDataSiswa,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/update-datasiswa/:idSiswa?',
        name: 'adminUpdateSiswa',
        component: tambahDataSiswa,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/input-nilai',
        name: 'adminInputInlai',
        component: adminInputNilai,
        meta: {
            requiresAuth: true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/input-nilai-siswa/:nisn?/:smester?',
        name: 'adminNilaiSiswa',
        component: adminNilaiSiswa,
        meta: {
            requiresAuth: true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/input-nilai',
        name: 'guruInputInlai',
        component: adminInputNilai,
        meta: {
            requiresAuth: true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/input-nilai-siswa/:nisn?/:kelas?',
        name: 'guruNilaiSiswa',
        component: adminNilaiSiswa,
        meta: {
            requiresAuth: true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/informasi',
        name: 'adminInformasi',
        component: adminInformasi,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/tambah-informasi',
        name: 'adminTambahInformasi',
        component: adminTambahInformasi,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/admin/update-informasi/:idInfo?',
        name: 'adminUpdateInformasi',
        component: adminTambahInformasi,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        },
    },
    {
        path: '/admin/kritik',
        name: 'adminKritik',
        component: adminKritik,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/change-password/:nisn?',
        name: 'ChangePasswordGuru',
        component: changeGuruPasswordIndex,
        meta: {
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/guru/kritik',
        name: 'guruKritik',
        component: adminKritik,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/guru/tidak-ada-kelas',
        name: 'guruTidakAdaKelas',
        component: guruTidakAdaKelas,
        meta:{
            requiresAuth:true,
            requiresAdmin:true
        }
    },
    {
        path: '/',
        name: 'Home',
        component: homePagesIndex,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: profilePagesIndex,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/change-password/:nisn?',
        name: 'ChangePassword',
        component: changePasswordIndex,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/kritik',
        name: 'Kritik',
        component: pagesKritik,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/informasi',
        name: 'Informasi',
        component: pagesInformasi,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/informasi/detail/:id?',
        name: 'informasiDetail',
        component: pagesInformasiDetail,
    },
    {
        path: '/index-prestasi',
        name: 'IndexPrestasi',
        component: pagesIndexPrestasi,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: notFound,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/notacc',
        name: 'notAccess',
        component: notAccess,
        meta: {
            requiresAuth: false
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return { name : 'Login' }
    }

    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        if (localStorage.getItem('name') === 'admin') {
            return {
                name: 'adminHome'
            }
        } else {
            return {
                name: 'guruHome'
            }
        }
    }

    if (to.meta.requiresAdmin == true && localStorage.length != 0) {
        if (JSON.parse(localStorage.token).name != 'admin') {
            if ((JSON.parse(localStorage.token).nisn).substring(0, 3) != 'GU-') {
                return {
                    name: 'notAccess'
                }
            }
        }
    }
})

export default router
