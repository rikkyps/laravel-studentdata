<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Siswa;
use App\Telepon;
use App\Kelas;
use App\Hobi;
use Storage;
use Session;
//use Validator;
use App\Http\Requests\SiswaRequest;

class SiswaController extends Controller
{
    protected $request;

    public function __construct(Request $req)
    {
        $this->middleware('auth', ['except' => [
            'index',
            'show',
            'cari',
        ]]);
        $this->request = $req;
    }

    public function index()
    {
        $siswa_list = Siswa::orderBy('nisn', 'asc')->paginate(5);
        $jumlah_siswa = $siswa_list->total();
        return view('siswa.index', compact('siswa_list', 'jumlah_siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(SiswaRequest $request)
    {
        $input = $request->all();

        //Upload foto
        if ($request->hasFile('foto')) {
            $input['foto'] = $this->uploadFoto($request);
        }
        
        //Simpan data siswa
        $siswa = Siswa::create($input);

        //Simpan data telepon
        $telepon = new Telepon;
        $telepon->nomor_telepon = $request->input('nomor_telepon');
        $siswa->telepon()->save($telepon);

        //Simpan data hobi
        $siswa->hobi()->attach($request->input('hobi_siswa'));

        //Flash message
        Session::flash('flash_message', 'Data Siswa berhasil disimpan.');
        return redirect('siswa');
    }

    public function show(Siswa $siswa)
    {
        //$siswa = Siswa::findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        //$siswa = Siswa::findOrFail($id);
        $siswa->nomor_telepon = $siswa->telepon->nomor_telepon;
        //$list_kelas = Kelas::pluck('nama_kelas', 'id');
        //$list_hobi = Hobi::pluck('nama_hobi', 'id');
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Siswa $siswa, SiswaRequest $request)
    {
        //$siswa = Siswa::findOrFail($id);
        $input = $request->all();

        //Cek apakah ada foto baru di form
        if ($request->hasFile('foto')) {

            //Hapus foto lama jika ada foto baru
            $this->hapusFoto($siswa);

            //Upload foto baru
            $input['foto'] = $this->uploadFoto($request);
        }

        //Update siswa di tabel siswa
        $siswa->update($input);
        
        //Update telepon di tabel telepon
        $telepon = $siswa->telepon;
        $telepon->nomor_telepon = $request->input('nomor_telepon');
        $siswa->telepon()->save($telepon);

        //Update hobi di tabel hobi_siswa
        $siswa->hobi()->sync($request->input('hobi_siswa'));
        
        Session::flash('flash_message', 'Data Siswa berhasil diupdate.');
        return redirect('siswa');
    }

    public function destroy(Siswa $siswa)
    {
        //$siswa = Siswa::findOrFail($id);
        $this->hapusFoto($siswa);
        $siswa->delete();
        Session::flash('flash_message', 'Data Siswa berhasil dihapus.');
        Session::flash('penting', true);
        return redirect('siswa');
    }

    public function tesCollection()
    {
      $collection = Siswa::select('nisn' ,'nama_siswa')->get();
      $koleksi = $collection->toArray();
      foreach ($koleksi as $siswa){
          echo $siswa['nisn']. ' - ' .$siswa['nama_siswa']. '</br>'; 

      }
    }

    public function dateMutator()
    {
        $siswa = Siswa::findOrFail(1);
        $str = 'Tanggal Lahir : '.
        $siswa->tanggal_lahir->format('d-m-Y') .'<br>'.'Ulang tahun ke-30 akan jatuh pada tanggal: '.
        '<strong>'.
        $siswa->tanggal_lahir->addYears(30)->format('d-m-Y')
        .'</strong>';

        return $str;
    }

    public function uploadFoto(SiswaRequest $request)
    {
        $foto = $request->file('foto');
        $ext = $foto->getClientOriginalExtension();

        if ($request->file('foto')->isValid()) {
            $foto_name = date('YmdHis'). ".$ext";
            $upload_path = 'fotoupload';
            $request->file('foto')->move($upload_path, $foto_name);

            return $foto_name;
        }

        return false;
    }

    public function hapusFoto(Siswa $siswa)
    {
        $exist = Storage::disk('foto')->exists($siswa->foto);
            if (isset($siswa->foto) && $exist){
                $delete = Storage::disk('foto')->delete($siswa->foto);
                if ($delete) {
                    return true;
                }
                return false;
            }
    }

    public function cari(Request $request)
    {
        $kata_kunci     = trim($request->input('kata_kunci'));

        if (! empty($kata_kunci)) {
            $jenis_kelamin = $request->input('jenis_kelamin');
            $id_kelas      = $request->input('id_kelas');

            //Query
            $query          = Siswa::where('nama_siswa', 'LIKE', '%' .$kata_kunci. '%');
            (! empty($jenis_kelamin)) ? $query->JenisKelamin($jenis_kelamin) : '';
            (! empty($id_kelas)) ? $query->Kelas($id_kelas) : '';
            $siswa_list = $query->paginate(2);

            //Url Links pagination

            $pagination = (! empty($jenis_kelamin)) ? $siswa_list->appends(['jenis_kelamin' => $jenis_kelamin]) : '';
            $pagination = (! empty($id_kelas)) ? $pagination = $siswa_list->appends(['id_kelas' => $id_kelas]) : '';
            $pagination = $siswa_list->appends(['kata_kunci' => $kata_kunci]);

            $jumlah_siswa = $siswa_list->total();
            return view('siswa.index', compact('siswa_list', 'kata_kunci', 'pagination', 'jumlah_siswa', 'id_kelas', 'jenis_kelamin'));
        }

        return redirect('siswa');
        
        // $siswa_list     = $query->paginate(2);
        // $pagination     = $siswa_list->appends($request->except('page'));
        // $jumlah_siswa   = $siswa_list->total();
        // return view('siswa.index', compact('siswa_list', 'kata_kunci', 'pagination', 'jumlah_siswa'));
    
    }
}
