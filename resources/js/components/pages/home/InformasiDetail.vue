<script setup>
import { reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

let model = reactive({
    title: '',
    nomor: '',
    text: '',
    date: '',
})


function close() {
    router.go(-1)
}

onMounted(() => {
    var id = route.params.id
    axios.get('/api/informasi_detail/' + id ).then((res) => {
        var informasi = res.data.data[0]

        console.log(informasi);

        var split1 = informasi.text.split('<p>')[1]
        var split2 = split1.split('</p>')[0]
        var months = [null, "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"]
        var date_info = informasi.updated_at ? informasi.updated_at : informasi.created_at
        var selectedMonthName = months[parseInt(date_info.substr(5, 2))]
        model.date = date_info.substr(8,2) + ' ' + selectedMonthName + ' ' + date_info.substr(0,4)

        console.log(selectedMonthName);

        const rndInt = date_info.substr(8,2)
        const rndInt2 = date_info.substr(5,2)
        const rndInt3 = date_info.substr(0,4)

        model.title = informasi.title
        model.nomor = rndInt + '/' + rndInt2 + '/' + rndInt3 + '/' + id
        model.text = split2

    })
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
                <div class = "rangkasurat">
                    <table width = "100%">
                        <tr>
                            <td><img src="http://www.smanciwaru.sch.id/office/92SMAN1CWR%20new%20200x200.png"></td>
                            <td class = "tengah">
                                <h5>PEMERINTAH DAERAH PROVINSI JAWA BARAT</h5>
                                <h5>DINAS PENDIDIKAN</h5>
                                <h4>SEKOLAH MENENGAH ATAS NEGERI 1 CIWARU</h4>
                                <h4>KUNINGAN</h4>
                                <b>Jalan Raya 11 April Rt. 04 Rw. 02 Desa Linggajaya Kec. Ciwaru Kab. Kuningan 45583</b>
                            </td>
                        </tr>
                    </table >
                    <hr>
                    <div class="float-end">
                        {{ model.date }}
                    </div>
                    <p>Nomor : {{ model.nomor }}<br>Perihal : {{ model.title }}<br>Lampiran : -</p>
                    <p>Kepada<br>Bapak/Ibu/Orang Tua Wali<br>Di<br>Tempat</p>
                    <p>Assalamu'alaikum Warahmatullahi Wabarokatuh<br>{{ model.text }}</p>
                    <p>Wassalamu'alaikum Warahmatullahi Wabarokatuh</p>
                    <div class="float-end pb-4">
                        Kepala Sekolah SMAN 1 Ciwaru
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    body {
        font-family: arial;
        background-color : #ccc
    }

    .rangkasurat {
        width : 980px;margin:0 auto;
        background-color : #fff;
        height: 500px;
        padding: 20px;
    }

    table {
        border-bottom : 5px solid # 000;
        padding: 2px
    }

    .tengah {
        text-align : center;
        line-height: 5px;
    }

    hr {
        border: none;
        height: 2px;
        /* Set the hr color */
        color: rgb(0, 0, 0); /* old IE */
        background-color: rgb(0, 0, 0); /* Modern Browsers */
    }
</style>
