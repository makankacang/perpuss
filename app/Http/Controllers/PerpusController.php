<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\kategoribuku;
use Illuminate\Http\Request;
use App\Models\peminjaman;
use App\Models\ulasanbuku;
use App\Models\user;
use App\Models\koleksipribadi;
use App\Models\kategoribuku_relasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerpusController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalUser = User::count();
        $totalPeminjaman = Peminjaman::count();
        $totalUlasan = UlasanBuku::count();

        $recentPeminjaman = Peminjaman::where('StatusPeminjaman', 'konfirmasi')
        ->orderByDesc('TanggalPeminjaman')
        ->limit(5)
        ->get();

        return view('admin.dashboard', compact('recentPeminjaman', 'totalBuku', 'totalUser', 'totalPeminjaman', 'totalUlasan'));
    }

    public function indexp()
    {
        return view('peminjam.home');
    }

    public function showProfile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'tanggalPengembalian' => 'required|date|after:today',
            'bukuID' => 'required',
            'userID' => 'required',
        ]);
    
        Peminjaman::create([
            'BukuID' => $request->bukuID,
            'UserID' => $request->userID,
            'TanggalPeminjaman' => now(),
            'TanggalPengembalian' => $request->tanggalPengembalian,
            'StatusPeminjaman' => 'konfirmasi',
        ]);
    
        // Use JavaScript to show the toast message
        return redirect()->back()->with('success', 'Buku berhasil dipinjam!');
    }
    


    public function koleksip(Request $request)
    {
        $userID = Auth::id();
    
        $koleksis = KoleksiPribadi::where('UserID', $userID);
    
        // Check if a category is selected
        if ($request->has('kategori')) {
            $koleksis->whereHas('buku.kategoris', function ($query) use ($request) {
                $query->where('kategoribuku_relasi.KategoriID', $request->kategori);
            });
        }
    
        $koleksis = $koleksis->get();
        $categories = Kategoribuku::all();
    
        return view('peminjam.koleksi', compact('koleksis', 'categories'));
    }
    


    public function addToCollection(Request $request)
    {
        // Retrieve the book ID from the request
        $bukuID = $request->input('bukuID');
    
        // Add the book to the collection
        KoleksiPribadi::create([
            'UserID' => auth()->user()->id,
            'BukuID' => $bukuID,
        ]);
    
        // You can return a response if needed
        return response()->json(['success' => true]);
    }
    
    public function removeFromCollection(Request $request)
    {
        // Retrieve the book ID from the request
        $bukuID = $request->input('bukuID');
    
        // Remove the book from the collection
        KoleksiPribadi::where('BukuID', $bukuID)->delete();
    
        // You can return a response if needed
        return response()->json(['success' => true]);
    }

    public function removeFromCollections(Request $request)
    {
    // Retrieve the KoleksiID from the request
    $koleksiID = $request->input('koleksiID');

    // Find the koleksi record and delete it
    $koleksi = KoleksiPribadi::find($koleksiID);
    if ($koleksi) {
        $koleksi->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Koleksi not found'], 404);
    }
    }

    public function cancelBorrow(Request $request) {
        $peminjamanID = $request->peminjamanID;
    
        // Find the Peminjaman record
        $peminjaman = Peminjaman::find($peminjamanID);
    
        if ($peminjaman) {
            // Delete the Peminjaman record
            $peminjaman->delete();
            return response()->json(['message' => 'Peminjaman has been canceled successfully.']);
        } else {
            return response()->json(['error' => 'Peminjaman not found.'], 404);
        }
    }




    public function buku()
    {
        $bukus = Buku::all();
        $categories = kategoribuku::all(); // Retrieve all categories
        return view('admin.buku', ['bukus' => $bukus, 'categories' => $categories]); // Pass categories to the view
    }
    

    public function bookinput(Request $request)
    {
        // Validate the request
        $request->validate([
            'Judul' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'TahunTerbit' => 'required|integer',
            'KategoriID' => 'required', // Ensure KategoriID is provided
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Define validation rules for the image
        ]);
    
        // Handle file upload
        if ($request->hasFile('image')) {
            // Get the file name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just the file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Concatenate the file name and extension
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload the image
            $path = $request->file('image')->storeAs('/public/images', $fileNameToStore);
        } else {
            // If no image is uploaded, set a default value for $fileNameToStore
            $fileNameToStore = 'noimage.jpg';
        }
    
        // Create a new Buku instance with the form data
        $buku = new Buku;
        $buku->Judul = $request->input('Judul');
        $buku->Penulis = $request->input('Penulis');
        $buku->Penerbit = $request->input('Penerbit');
        $buku->TahunTerbit = $request->input('TahunTerbit');
        $buku->image = $fileNameToStore; // Set the image file name
        $buku->save();
    
        // Get the selected KategoriID
        $kategoriID = $request->input('KategoriID');
    
        // Create a new kategoribuku_relasi instance to establish the relationship
        $kategoribukuRelasi = new kategoribuku_relasi;
        $kategoribukuRelasi->BukuID = $buku->BukuID; // Assign the ID of the created Buku
        $kategoribukuRelasi->KategoriID = $kategoriID;
        $kategoribukuRelasi->save();
    
        // Redirect back with success message
        return redirect()->route('admin.buku')->with('success', 'Data berhasil di Tambah');
    }
    
    public function bookedit(Request $request, $BukuID){
        $buku = Buku::find($BukuID);
    
        // Update other fields
        $buku->Judul = $request->input('Judul');
        $buku->Penulis = $request->input('Penulis');
        $buku->Penerbit = $request->input('Penerbit');
        $buku->TahunTerbit = $request->input('TahunTerbit');
        
        // Update category ID
        $buku->kategoris()->sync([$request->input('KategoriID')]); // Update the category ID in the pivot table
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete existing image if needed
            Storage::delete('public/images/' . $buku->image);
        
            // Upload new image
            $imagePath = $request->file('image')->store('public/images');
            $buku->image = basename($imagePath);
        }
        
        // Save changes
        $buku->save();
        
        return redirect()->route('admin.buku')->with('ubah','Data berhasil di Ubah');
    }
    
    

    public function deleteBuku($id)
    {
        // Find the book by its ID
        $buku = Buku::find($id);
    
        // Check if the book exists
        if($buku) {
            // Delete the image from storage
            Storage::delete('public/images/' . $buku->image);
            
            // Delete the book record from the database
            $buku->delete();
    
            // Redirect with a success message
            return redirect()->route('admin.buku')->with('hapus', 'Data berhasil dihapus');
        } else {
            // If the book doesn't exist, redirect with an error message
            return redirect()->route('admin.buku')->with('error', 'Buku tidak ditemukan');
        }
    }
    

    public function peminjaman()
    {
        // Load Peminjaman data with their associated Buku data using eager loading
        $peminjamans = Peminjaman::with('buku')->get();
        
        // Pass the first Peminjaman object to the view
        $peminjaman = $peminjamans->first();
        
        return view('admin.pinjaman', ['peminjamans' => $peminjamans, 'peminjaman' => $peminjaman]);
    }
    

    public function peminjamansaya()
    {
        $userID = Auth::id();
    
        $peminjamans = Peminjaman::where('UserID', $userID)->get();
        return view('peminjam.pinjaman', ['peminjamans' => $peminjamans]);
    }
    
    public function konfirmasiPeminjaman($id)
    {
        // Find the peminjaman by ID
        $peminjaman = Peminjaman::findOrFail($id);
    
        // Update the status to 'dipinjam'
        $peminjaman->StatusPeminjaman = 'dipinjam';
        $peminjaman->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi');
    }

    public function cancelPeminjaman($id)
    {
        // Find the peminjaman
        $peminjaman = Peminjaman::findOrFail($id);

        // Cancel the peminjaman
        $peminjaman->delete();

        // Redirect back or wherever you want
        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan');
    }

    public function generate(Request $request)
    {
        $bukuId = $request->input('buku_id');

        // Fetch data from the database
        $peminjaman = Peminjaman::where('BukuID', $bukuId)->with('buku', 'user')->first();

        if (!$peminjaman) {
            // Handle the case where no such book is borrowed
            abort(404, 'Book not found or not borrowed');
        }

        // Return the report view with the fetched data
        return view('admin.report', compact('peminjaman'));
    }

    public function kembalikanBuku($id)
    {
        // Find the peminjaman by ID
        $peminjaman = Peminjaman::findOrFail($id);

        // Update the status to 'dikembalikan'
        $peminjaman->StatusPeminjaman = 'dikembalikan';
        $peminjaman->save();

        // Redirect back with a success message or any other action you want
        return redirect()->back()->with('success', 'Buku telah dikembalikan');
    }

    public function ulasanadmin()
    {
        // Fetch ulasan buku data from the database
        $ulasanBuku = UlasanBuku::all();

        // Pass the data to the view and return it
        return view('admin.ulasan', compact('ulasanBuku'));
    }

    public function ulasandelete($id)
    {
        // Find the ulasanBuku entry by ID
        $ulasan = UlasanBuku::findOrFail($id);
        
        // Delete the entry
        $ulasan->delete();
        
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Ulasan deleted successfully.');
    }

    public function showUsers()
{
    $users = User::all(); // Assuming User is your model for the users table
    return view('admin.user', compact('users'));
}


public function changeLevel($id, $level)
{
    $user = User::findOrFail($id);
    $user->level = $level;
    $user->save();
    
    return redirect()->route('users.show');
}


    public function katbuku()
    {
        $bukus = kategoribuku::all();
        return view('admin.kategori', ['kategoribukus' => $bukus]);
    }

    public function katbukuinput(Request $request)
    {
    kategoribuku::create($request->all());
    return redirect()->route('admin.kategori')->with('success','Data berhasil di Tambah');
    }

    public function katbukuedit(Request $request, $BukuID){
    $BukuID= kategoribuku::find($BukuID);
    $BukuID->update($request->all());
    return redirect()->route('admin.kategori')->with('ubah','Data berhasil di Ubah');
    }

    public function deletekatBuku($id)
    {
        $id = kategoribuku::find($id);
        $id->delete();
        return redirect()->route('admin.kategori')->with('hapus','Data berhasil di Hapus');
    }




    public function koleksi()
    {
        $koleksiPribadi = KoleksiPribadi::all();
        return view('admin.koleksi', ['koleksiPribadi' => $koleksiPribadi]);
    }

public function deleteKoleksi($id)
{
    $koleksi = KoleksiPribadi::find($id);
    
    if ($koleksi) {
        $koleksi->delete();
        return redirect()->route('admin.koleksi')->with('hapus', 'Data berhasil dihapus');
    } else {
        return redirect()->route('admin.koleksi')->with('error', 'Data tidak ditemukan');
    }
}


public function perpustakaan(Request $request)
{
    $bukus = Buku::query();

    // Check if a category is selected
    if ($request->has('kategori')) {
        $bukus->whereHas('kategoris', function ($query) use ($request) {
            $query->where('kategoribuku_relasi.KategoriID', $request->kategori);
        });
    }

    $bukus = $bukus->paginate(6);
    $userCollections = KoleksiPribadi::where('UserID', auth()->user()->id)->pluck('BukuID')->toArray();
    $categories = Kategoribuku::all();

        

        return view('peminjam.perpus', compact('bukus', 'userCollections', 'categories',));
}

public function submitReview(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'BukuID' => 'required|exists:buku,BukuID', // Assuming 'BukuID' is the primary key of the 'bukus' table
        'Ulasan' => 'required|string',
        'Rating' => 'required|numeric|min:1|max:5',
    ]);

    // Create a new review
    $review = new UlasanBuku;
    $review->UserID = auth()->id(); // Assuming the user is authenticated
    $review->BukuID = $validatedData['BukuID'];
    $review->Ulasan = $validatedData['Ulasan'];
    $review->Rating = $validatedData['Rating'];
    $review->save();

    // Redirect back with success message or handle response as needed
    return back()->with('success', 'Ulasan berhasil ditambahkan.');
}

public function updateReview(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'BukuID' => 'required|exists:buku,BukuID', // Assuming 'BukuID' is the primary key of the 'bukus' table
            'Ulasan' => 'required|string',
            'Rating' => 'required|numeric|min:1|max:5',
        ]);

        // Find the review to update
        $review = UlasanBuku::where('BukuID', $validatedData['BukuID'])
                            ->where('UserID', auth()->id())
                            ->first();

        // Update the review
        $review->Ulasan = $validatedData['Ulasan'];
        $review->Rating = $validatedData['Rating'];
        $review->save();

        // Redirect back with success message or handle response as needed
        return back()->with('success', 'Ulasan berhasil diperbarui.');
    }

    public function fetchOtherReviews(Request $request)
    {
        $bukuId = $request->input('bukuId');
        
        // Fetch other users' reviews for the specified book
        $otherReviews = UlasanBuku::where('BukuID', $bukuId)
            ->where('UserID', '!=', auth()->id()) // Exclude current user's review
            ->get();
        
        return view('other_reviews', ['otherReviews' => $otherReviews]);
    }

    public function cetakReport()
    {
        // Fetch all peminjaman data
        $peminjamans = Peminjaman::all();
        
        // Here you can implement the logic for generating and returning the report
        
        // For example, you can return a view with the data:
        return view('admin.cetak', compact('peminjamans'));
    }

public function profile()
{
    $user = auth()->user(); // Mengambil pengguna yang sedang login
    return view('peminjam.profile', compact('user'));
}

public function checkBorrowStatus(Request $request)
    {
        $bukuId = $request->input('bukuId');
        $userId = auth()->id(); // Assuming the user is authenticated

        // Check the user's borrowing status for the specific book
        $status = Peminjaman::where('BukuID', $bukuId)
            ->where('UserID', $userId)
            ->whereIn('StatusPeminjaman', ['dipinjam', 'dikembalikan'])
            ->exists() ? 'dipinjam' : 'konfirmasi'; // Adjust as needed

        return response()->json(['status' => $status]);
    }

    public function checkReview(Request $request)
{
    $bukuId = $request->input('bukuId');
    $userId = auth()->id(); // Assuming the user is authenticated

    // Check if the user has already reviewed the book
    $review = UlasanBuku::where('BukuID', $bukuId)
        ->where('UserID', $userId)
        ->first();

    return response()->json(['review' => $review]);
}

public function updateProfile(Request $request)
{
    $user = User::find(auth()->id()); // Find the authenticated user by their ID
    $user->update($request->all());

    return redirect()->back()->with('success', 'Profile updated successfully');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
