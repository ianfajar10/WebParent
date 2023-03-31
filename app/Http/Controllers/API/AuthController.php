<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interface\SiswaRepositoryInterface;
use App\Repositories\Interface\KelasRepositoryInterface;
use App\Repositories\Interface\GuruRepositoryInterface;
use App\Repositories\Interface\InformasiRepositoryInterface;
use App\Repositories\Interface\KritikRepositoryInterface;
use App\Repositories\Interface\SubjectRepositoryInterface;
use App\Repositories\Interface\NilaiRepositoryInterface;
use App\Models\User;
use App\Models\Informations;
use App\Models\Critics;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(NilaiRepositoryInterface $NilaiRepositoryInterface, SubjectRepositoryInterface $SubjectRepositoryInterface, KelasRepositoryInterface $KelasRepositoryInterface, SiswaRepositoryInterface $SiswaRepositoryInterface, InformasiRepositoryInterface $InformasiRepositoryInterface, KritikRepositoryInterface $KritikRepositoryInterface, Nilai $Nilai, GuruRepositoryInterface $GuruRepositoryInterface)
    {
        $this->siswa = $SiswaRepositoryInterface;
        $this->informasi = $InformasiRepositoryInterface;
        $this->kritik = $KritikRepositoryInterface;
        $this->nilai = $NilaiRepositoryInterface;
        $this->guru = $GuruRepositoryInterface;
        $this->kelas = $KelasRepositoryInterface;
        $this->pelajaran = $SubjectRepositoryInterface;
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
                'nisn' => 'required',
                'name' => 'required',
                'telp' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'address' => 'required',
                'parent_name' => 'required',
                'parent_number' => 'required',
                'parent_work' => 'required',
                'birth_day' => 'required',
                'birth_month' => 'required',
                'birth_year' => 'required',
                'email' => 'required|email',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $nisn = $input['nisn'];
        $name = $input['name'];
        $telp = $input['telp'];
        $gender = $input['gender'];
        $religion = $input['religion'];
        $address = $input['address'];
        $parent_name = $input['parent_name'];
        $parent_number = $input['parent_number'];
        $parent_work = $input['parent_work'];
        $birth = $input['birth_day'] . '/' . $input['birth_month'] . '/' . $input['birth_year'];
        $email = $input['email'];
        $password = bcrypt($input['birth_day'].$input['birth_month'].$input['birth_year']);
        $data = [
            'nisn' =>  $nisn,
            'name' =>  $name,
            'telp' =>  $telp,
            'gender' =>  $gender,
            'religion' =>  $religion,
            'birth' =>  $birth,
            'address' =>  $address,
            'parent_name' =>  $parent_name,
            'parent_number' =>  $parent_number,
            'parent_work' =>  $parent_work,
            'email' => $email,
            'password' => $password,
        ];
        $user = User::create($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, data siswa telah dibuat"
        ];

        return response()->json($response, 200);
    }

    public function register_update(Request $request){
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'telp' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'address' => 'required',
                'parent_name' => 'required',
                'parent_number' => 'required',
                'parent_work' => 'required',
                'birth_day' => 'required',
                'birth_month' => 'required',
                'birth_year' => 'required',
                'email' => 'required|email',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $name = $input['name'];
        $telp = $input['telp'];
        $gender = $input['gender'];
        $religion = $input['religion'];
        $address = $input['address'];
        $parent_name = $input['parent_name'];
        $parent_number = $input['parent_number'];
        $parent_work = $input['parent_work'];
        $birth = $input['birth_day'] . '/' . $input['birth_month'] . '/' . $input['birth_year'];
        $email = $input['email'];
        $password = bcrypt($input['birth_day'].$input['birth_month'].$input['birth_year']);
        $data = [
            'name' =>  $name,
            'telp' =>  $telp,
            'gender' =>  $gender,
            'religion' =>  $religion,
            'birth' =>  $birth,
            'address' =>  $address,
            'parent_name' =>  $parent_name,
            'parent_number' =>  $parent_number,
            'parent_work' =>  $parent_work,
            'email' => $email,
            'password' => $password,
        ];
        $register = DB::table('Users')->where('nisn', $input['nisn'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, data siswa telah diubah"
        ];

        return response()->json($response, 200);
    }

    public function resetPassword(Request $request){
        $input = $request->all();
        $nisn = $input['nisn'];
        $guru = substr($nisn, 0, 2);
        if ($guru === 'GU') {
            $nisn_default = explode('-', $nisn);
            $password = bcrypt($nisn_default[1]);
            $data = [
                'password' =>  $password,
            ];
            $reset = DB::table('Users')->where('nisn', $nisn)->update($data);
        } else {
            $birth = explode('/', $input['birth']);
            $password = bcrypt($birth[0].$birth[1].$birth[2]);
            $data = [
                'password' =>  $password,
            ];
            $reset = DB::table('Users')->where('nisn', $nisn)->update($data);
        }

        $response = [
            'success' => true,
            'message' => "Berhasil, kata sandi telah diatur ulang"
        ];

        return response()->json($response, 200);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
                'password' => 'required',
                'conf_password' => 'same:password',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $nisn = $input['nisn'];
        $password = bcrypt($input['password']);
        $data = [
            'password' =>  $password,
        ];
        $change = DB::table('Users')->where('nisn', $nisn)->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, kata sandi telah diubah"
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request) {
        if (Auth::attempt(['nisn' => $request->nisn, 'password' => $request->password])) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['created_at'] = $user->created_at;
            $success['nisn'] = $user->nisn;
            $success['telp'] = $user->telp;
            $success['address'] = $user->address;
            $success['parent_name'] = $user->parent_name;
            $success['parent_number'] = $user->parent_number;
            $success['parent_work'] = $user->parent_work;
            $success['birth'] = $user->birth;
            $success['email'] = $user->email;
            $success['email_verified_at'] = $user->email_verified_at;
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['gender'] = $user->gender;
            $success['religion'] = $user->religion;
            $success['updated_at'] = $user->updated_at;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => "User login successfully"
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => "Mohon periksa kembali kombinasi email dan password!"
            ];

            return response()->json($response, 200);
        }
    }

    public function siswa($param) {
        $user = $this->siswa->getAllSiswa($param);
        $response = [
            'success' => true,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function pelajaran() {
        $pelajaran = $this->pelajaran->getAllPelajaran();
        $response = [
            'success' => true,
            'data' => $pelajaran
        ];

        return response()->json($response, 200);
    }

    public function nilai_pelajaran($nisn,$kelas,$smester) {
        $nilai_pelajaran = $this->nilai->getAllNilaiPelajaran($nisn,$kelas,$smester);
        $response = [
            'success' => true,
            'data' => $nilai_pelajaran
        ];

        return response()->json($response, 200);
    }

    public function siswa_per_class(Request $request) {
        $nisn = $request->nisn;
        $user = $this->siswa->getAllSiswaPerClass($nisn);
        $response = [
            'success' => true,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function guru($param) {
        $user = $this->guru->getAllGuru($param);
        $response = [
            'success' => true,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function kelas_siswa($nisn) {
        $kelas_siswa = $this->siswa->getAllKelas($nisn);
        $response = [
            'success' => true,
            'data' => $kelas_siswa
        ];

        return response()->json($response, 200);
    }

    public function getKelas(Request $request) {
        $nisn = $request->nisn;
        $kelas = $this->kelas->getCheckKelas($nisn);
        $response = [
            'success' => true,
            'data' => $kelas
        ];

        return response()->json($response, 200);
    }

    public function nilaiKelas(Request $request) {
        $nisn = $request->nisn;
        $kelas = $this->kelas->getNilaiKelas($nisn);
        $response = [
            'success' => true,
            'data' => $kelas
        ];

        return response()->json($response, 200);
    }

    public function nilaiSmester(Request $request) {
        $nisn = $request->nisn;
        $smester = $this->kelas->getNilaiSmester($nisn);
        $response = [
            'success' => true,
            'data' => $smester
        ];

        return response()->json($response, 200);
    }

    public function getKelasSiswa(Request $request) {
        $nisn = $request->nisn;
        $kelas = $this->kelas->getCheckKelasSiswa($nisn);
        $response = [
            'success' => true,
            'data' => $kelas
        ];

        return response()->json($response, 200);
    }

    public function getWaliKelasSiswa(Request $request) {
        $kelas = $request->kelas;
        $kelas = $this->kelas->getCheckWaliKelasSiswa($kelas);
        $response = [
            'success' => true,
            'data' => $kelas
        ];

        return response()->json($response, 200);
    }

    public function kelas(Request $request) {
        $user = $this->kelas->getAllKelas();
        $response = [
            'success' => true,
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function guru_add(Request $request) {
        $validator = Validator::make($request->all(),[
                'nisn' => 'required',
                'name' => 'required',
                'telp' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'address' => 'required',
                'birth_day' => 'required',
                'birth_month' => 'required',
                'birth_year' => 'required',
                'email' => 'required|email',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $nisn = 'GU-'.$input['nisn'];
        $name = $input['name'];
        $telp = $input['telp'];
        $gender = $input['gender'];
        $religion = $input['religion'];
        $address = $input['address'];
        $birth = $input['birth_day'] . '/' . $input['birth_month'] . '/' . $input['birth_year'];
        $email = $input['email'];
        $password = bcrypt($input['nisn']);
        $data = [
            'nisn' =>  $nisn,
            'name' =>  $name,
            'telp' =>  $telp,
            'gender' =>  $gender,
            'religion' =>  $religion,
            'birth' =>  $birth,
            'address' =>  $address,
            'email' => $email,
            'password' => $password,
        ];
        $guru = User::create($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, data guru telah dibuat"
        ];

        return response()->json($response, 200);
    }

    public function guru_update(Request $request) {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'telp' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'address' => 'required',
                'birth_day' => 'required',
                'birth_month' => 'required',
                'birth_year' => 'required',
                'email' => 'required|email',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $name = $input['name'];
        $telp = $input['telp'];
        $gender = $input['gender'];
        $religion = $input['religion'];
        $address = $input['address'];
        $birth = $input['birth_day'] . '/' . $input['birth_month'] . '/' . $input['birth_year'];
        $email = $input['email'];
        $password = bcrypt($input['nisn']);
        $data = [
            'name' =>  $name,
            'telp' =>  $telp,
            'gender' =>  $gender,
            'religion' =>  $religion,
            'birth' =>  $birth,
            'address' =>  $address,
            'email' => $email,
            'password' => $password,
        ];
        $guru = DB::table('Users')->where('nisn', $input['nisn'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, data guru telah diubah"
        ];

        return response()->json($response, 200);
    }

    public function getInformasi(Request $request) {
        $informasi = $this->informasi->getAllInformasi();
        $response = [
            'success' => true,
            'data' => $informasi
        ];

        return response()->json($response, 200);
    }

    public function information(Request $request){
        $validator = Validator::make($request->all(),[
                'title' => 'required',
                'text' => 'required',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        setlocale (LC_TIME, 'IND');
        $date = strftime( "%A, %d %B %Y %H:%M", time());

        $input = $request->all();
        $title = $input['title'];
        $text = $input['text'];
        $data = [
            'title' =>  $title,
            'text' =>  '<center><h5>' . $title . '</h5></center><p>' . $text . '</p><p>' . $date . '<strong>  Admin</strong>' . '</p>',
        ];
        $information = Informations::create($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, informasi telah dibuat"
        ];

        return response()->json($response, 200);
    }

    public function information_update(Request $request){
        $validator = Validator::make($request->all(),[
                'title' => 'required',
                'text' => 'required',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        setlocale (LC_TIME, 'IND');
        $date = strftime( "%A, %d %B %Y %H:%M", time());

        $input = $request->all();
        $title = $input['title'];
        $text = $input['text'];
        $data = [
            'title' =>  $title,
            'text' =>  '<center><h5>' . $title . '</h5></center><p>' . $text . '</p><p>' . $date . '<strong>  Admin</strong>' . '</p>',
        ];
        $information = DB::table('Informations')->where('id', $input['id'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, informasi telah diubah"
        ];

        return response()->json($response, 200);
    }

    public function deleteInformasi(Request $request){
        $data = $request->all();

        $query = DB::table('Informations')->where('id', $data['id'])->delete();

        $response = [
            'success' => true,
            'message' => "Berhasil, informasi telah dihapus"
        ];

        return response()->json($response, 200);
    }

    public function deleteSiswa(Request $request){
        $data = $request->all();

        $query = DB::table('Users')->where('nisn', $data['nisn'])->delete();

        $response = [
            'success' => true,
            'message' => "Berhasil, siswa telah dihapus"
        ];

        return response()->json($response, 200);
    }

    public function deleteSiswaPerKelas(Request $request){
        $input = $request->all();
        $data = [
            'id_class' =>  null,
        ];
        $siswa = DB::table('users')->where('nisn', $input['nisn'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, siswa telah dihapus"
        ];

        return response()->json($response, 200);
    }

    public function deleteGuru(Request $request){
        $data = $request->all();

        $query = DB::table('Users')->where('nisn', $data['nisn'])->delete();

        $response = [
            'success' => true,
            'message' => "Berhasil, guru telah dihapus"
        ];

        return response()->json($response, 200);
    }

    public function deleteWaliKelas(Request $request){
        $input = $request->all();

        $data = [
            'nisn_guru' =>  '',
        ];
        $wali = DB::table('classes')->where('id', $input['kelas'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, wali kelas telah dihapus"
        ];

        return response()->json($response, 200);
    }

    public function simpanWaliKelas(Request $request){
        $input = $request->all();
        $data = [
            'nisn_guru' =>  $input['nisn'],
        ];
        $wali = DB::table('classes')->where('id', $input['kelas'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, wali kelas berhasil disimpan"
        ];

        return response()->json($response, 200);
    }

    public function simpanSiswa(Request $request){
        $input = $request->all();
        $data = [
            'id_class' =>  $input['kelas'],
        ];
        $siswa = DB::table('users')->where('nisn', $input['nisn'])->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, siswa berhasil disimpan kedalam kelas"
        ];

        return response()->json($response, 200);
    }

    public function informasi_detail($id) {
        $informasi_detail = $this->informasi->detailInformasi($id);
        $response = [
            'success' => true,
            'data' => $informasi_detail
        ];

        return response()->json($response, 200);
    }

    public function kritik(Request $request){
        $validator = Validator::make($request->all(),[
                'nisn' => 'required',
                'text' => 'required',
                'selected_kategori' => 'required',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $nisn = $input['nisn'];
        $text = $input['text'];
        $kategori = $input['selected_kategori'];
        $data = [
            'nisn' =>  $nisn,
            'text' =>  $text,
            'kategori' =>  $kategori,
        ];
        $kritik = Critics::create($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, terimakasih telah mengisi kritik dan saran"
        ];

        return response()->json($response, 200);
    }

    public function balas_kritik(Request $request){
        $validator = Validator::make($request->all(),[
                'text' => 'required',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $text = $input['text'];
        $data = [
            'text_answer' =>  $text,
        ];
        $kritik = DB::table('critics')
            ->where('id', $input['id'])
            ->update($data);

        $response = [
            'success' => true,
            'message' => "Berhasil, terimakasih telah menanggapi"
        ];

        return response()->json($response, 200);
    }

    public function getKritik(Request $request) {
        $nisn = null;
        if ($request->nisn) {
            $nisn = $request->nisn;
        }
        $kritik = $this->kritik->getAllKritik($nisn);
        $response = [
            'success' => true,
            'data' => $kritik
        ];

        return response()->json($response, 200);
    }

    public function siswa_detail($nisn, Request $request) {
        $siswa_detail = $this->siswa->getSiswa($nisn);
        $response = [
            'success' => true,
            'data' => $siswa_detail
        ];

        return response()->json($response, 200);
    }

    public function nilai_detail($nisn,$kelas,$pelajaran,$smester) {
        $nilai_detail = $this->nilai->getNilai($nisn,$kelas,$pelajaran,$smester);
        $response = [
            'success' => true,
            'data' => $nilai_detail
        ];

        return response()->json($response, 200);
    }

    public function guru_detail($nisn, Request $request) {
        $guru_detail = $this->guru->getGuru($nisn);
        $response = [
            'success' => true,
            'data' => $guru_detail
        ];

        return response()->json($response, 200);
    }

    public function count_siswa(Request $request) {
        $count_siswa = $this->siswa->getCountSiswa();
        $response = [
            'success' => true,
            'data' => $count_siswa
        ];

        return response()->json($response, 200);
    }

    public function count_kritik(Request $request) {
        $count_kritik = $this->kritik->getCountKritik();
        $response = [
            'success' => true,
            'data' => $count_kritik
        ];

        return response()->json($response, 200);
    }

    public function count_kritik_total(Request $request) {
        $count_kritik = $this->kritik->getCountKritikTotal();
        $response = [
            'success' => true,
            'data' => $count_kritik
        ];

        return response()->json($response, 200);
    }

    public function nilai(Request $request) {
        $validator = Validator::make($request->all(),[
                'nisn' => 'required',
                'kelas' => 'required',
                'kd_pelajaran' => 'required',
                'smester' => 'required',
                'tahun_ajaran' => 'required',
                'tugas' => 'required',
                'uts' => 'required',
                'uas' => 'required',
            ],
        );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $nisn = $input['nisn'];
        $kelas = $input['kelas'];
        $pelajaran = $input['kd_pelajaran'];
        $smester = $input['smester'];
        $tahun_ajaran = $input['tahun_ajaran'];
        $tugas = $input['tugas'];
        $uts = $input['uts'];
        $uas = $input['uas'];

        if ($input['mode'] === 'mengubah') {
            $data = [
                'tugas' =>  $tugas,
                'uts' =>  $uts,
                'uas' =>  $uas,
            ];
            $nilai = DB::table('nilais')
            ->where('nisn', $nisn)
            ->where('id_class', $kelas)
            ->where('id_subject', $pelajaran)
            ->where('semester', $smester)
            ->update($data);;

            $response = [
                'success' => true,
                'message' => "Berhasil, nilai siswa telah diubah"
            ];
        } else {
            $data = [
                'nisn' =>  $nisn,
                'id_class' =>  $kelas,
                'id_subject' =>  $pelajaran,
                'semester' =>  $smester,
                'tahun_ajaran' =>  $tahun_ajaran,
                'tugas' =>  $tugas,
                'uts' =>  $uts,
                'uas' =>  $uas,
            ];
            $nilai = Nilai::create($data);

            $response = [
                'success' => true,
                'message' => "Berhasil, nilai siswa telah disimpan"
            ];
        }

        return response()->json($response, 200);
    }
}
