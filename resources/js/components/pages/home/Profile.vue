<script>
export default ({
    data () {
        return {
            model : {
                name : '',
                gender: '',
                telp: '',
                birth: '',
                email: '',
                alamat: '',
                parent_name: '',
                parent_number: '',
                parent_work: '',
            },
        }
    },
    mounted() {
        var months = [null, "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"]

        var genders = ["Laki - Laki", "Perempuan"]
        var selectedGender = genders[this.$user.gender == 'L' ? 0 : 1]

        var selectedMonthName = months[parseInt(this.$user.birth.substr(3, 2))]

        this.model.name = this.$user.name
        this.model.telp = this.$user.telp
        this.model.gender = selectedGender
        this.model.birth = this.$user.birth.substr(0, 2) + " " + selectedMonthName + " " + this.$user.birth.substr(6, 4)
        this.model.email = this.$user.email
        this.model.alamat = this.$user.address
        this.model.parent_work = this.$user.parent_work
        this.model.parent_name = this.$user.parent_name
        this.model.parent_number = this.$user.parent_number

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
    },
})
</script>

<template>
    <div class="container rounded bg-white mt-5 mb-5">
        <button type="button" class="btn col-md-1 float-end" style="background-color: #4154F1; color: #ffffff" @click="close">
                X
            </button>
        <div class="row">
            <div class="col-md-6 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profil Siswa</h4>
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
                        <div class="col-md-12"><label class="labels">Tanggal Lahir</label><input type="text" class="form-control" placeholder="Masukkan tanggal lahir" v-model="model.birth" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="Masukkan email" v-model="model.email" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Alamat</label><textarea type="text" class="form-control" placeholder="Masukkan alamat" v-model="model.alamat" :disabled="true"></textarea></div>
                    </div>
                    <!-- <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center experience"><span>Data Orangtua</span></div><br>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Nama Ayah/Ibu (cth: Ahmad/Siti)</label><input type="text" class="form-control" placeholder="Masukkan nama ayah/nama ibu" v-model="model.parent_name" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Nomor Telepon</label><input type="text" class="form-control" placeholder="Masukkan nomor telepon valid" v-model="model.parent_number" :disabled="true"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Pekerjaan Ayah/Ibu (cth: Guru/Ibu Rumah Tangga)</label><input type="text" class="form-control" placeholder="Masukkan pekerjaan" v-model="model.parent_work" :disabled="true"></div>
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
