<?php


namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use Database\Seeders\KelasSeeder;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->get('cari');
        if ($cari) {
            $mahasiswas = Mahasiswa::with('kelas');
            $paginate = Mahasiswa::orderBy('Nim', 'asc')->where("Nama", "LIKE", "%$cari%")->paginate(3);
        } else {
            $mahasiswas = Mahasiswa::with('kelas');
            $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        }
        return view('mahasiswas.index', ['mahasiswas' => $mahasiswas, 'paginate' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            // 'foto' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);
        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        }

        // $mahasiswa = new Mahasiswa;
        // $mahasiswa->Nim = $request->Nim;
        // $mahasiswa->Nama = $request->Nama;
        Mahasiswa::create([
            'Nim' => $request->Nim,
            'Nama' => $request->Nama,
            'foto' => $image_name,
            'Jurusan' => $request->Jurusan,
            'No_Handphone' =>  $request->No_Handphone,
            'kelas_id' => $request->kelas_id,

        ]);
        // $mahasiswa->foto = $image_name;
        // $mahasiswa->Jurusan = $request->Jurusan;
        // $mahasiswa->No_Handphone = $request->No_Handphone;
        // $mahasiswa->kelas_id = $request->kelas_id;
        // $mahasiswa->Email = $request->Email;
        // $mahasiswa->Tanggal_Lahir = $request->Tanggal_Lahir;
        // $mahasiswa->save();

        // Mahasiswa::create([
        //     'foto' => $image_name,
        // ]);
        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data berdasarkan nim
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan nim untuk diedit
        // parameter pada function where terdiri dari nama kolom pada tabel database, variabel yang menjadi parameter
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            // 'foto' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);

        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $Mahasiswa->Nim = $request->Nim;
        $Mahasiswa->Nama = $request->Nama;
        $Mahasiswa->Jurusan = $request->Jurusan;
        $Mahasiswa->No_Handphone = $request->No_Handphone;
        $Mahasiswa->kelas_id = $request->kelas_id;
        $Mahasiswa->Email = $request->Email;
        $Mahasiswa->Tanggal_Lahir = $request->Tanggal_Lahir;

        if ($Mahasiswa->foto && file_exists(storage_path('app/public/' . $Mahasiswa->foto))) {
            Storage::delete('public/' . $Mahasiswa->foto);
        }
        $image_name = $request->file('image')->store('images', 'public');
        $Mahasiswa->foto = $image_name;

        $Mahasiswa->save();

        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function nilai($Nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        return view('mahasiswas.nilai', compact('Mahasiswa'));
    }
    public function cetak_pdf($Nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $pdf = PDF::loadview('mahasiswas.cetak_pdf', ['Mahasiswa' => $Mahasiswa]);
        return $pdf->stream();
    }
}
