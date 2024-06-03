<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- 00. Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid col-md-7">
            <div class="navbar-brand">Simple To Do List</div>
            <!--
            <div class="navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Akun Saya
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                            <li><a class="dropdown-item" href="#">Update Data</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        -->
        </div>
    </nav>

    <div class="container mt-4">
        <!-- 01. Content-->
        <h1 class="text-center mb-4">To Do List</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif
                        <!-- 02. Form input data -->
                        <form id="todo-form" action="{{ route('todo.post') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="task" id="todo-input"
                                    placeholder="Tambah task baru" value="{{ old('task') }}" required>
                                <button class="btn btn-primary" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <section class="vh-100 gradient-custom-2">
                    <div class="container py-5 h-100">
                      <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-12 col-xl-10">
                  
                          <div class="card mask-custom">
                            <div class="card-body p-4 text-white">
                  
                              <div class="text-center pt-3 pb-2">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                                  alt="Check" width="60">
                                <h2 class="my-4">Task List</h2>
                                
                                <!-- Form Pencarian -->
                                <form id="todo-form" action="{{ route('todo') }}" method="get">
                                  <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci">
                                    <button class="btn btn-secondary" type="submit">Cari</button>
                                  </div>
                                </form>
                              </div>
                  
                              <!-- Tabel Tugas -->
                              <table class="table text-white mb-0">
                                <thead>
                                  <tr>
                                    <th scope="col">Task</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($data as $item)
                                  <tr class="fw-normal">
                                    <td class="align-middle">
                                      <span class="task-text">
                                        {!! $item->is_done == '1' ? '<del>' : '' !!}{{ $item->task }}{!! $item->is_done == '1' ? '</del>' : '' !!}
                                      </span>
                                    </td>
                                    <td class="align-middle">
                                      <span class="badge {{ $item->is_done == '1' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $item->is_done == '1' ? 'Selesai' : 'Belum' }}
                                      </span>
                                    </td>
                                    <td class="align-middle">
                                      <div class="btn-group">
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">Edit</button>
                  
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('todo.delete', ['id' => $item->id]) }}" method="POST" onsubmit="return confirm('Apakah Yakin Untuk Dihapus?')">
                                          @csrf
                                          @method('delete')
                                          <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                      </div>
                                    </td>
                                  </tr>
                                  <!-- Form Edit Tugas -->
                                  <tr id="collapse-{{ $loop->index }}" class="collapse">
                                    <td colspan="3">
                                      <form action="{{ route('todo.update', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="input-group mb-3">
                                          <input type="text" class="form-control" name="task" value="{{ $item->task }}">
                                          <button class="btn btn-outline-primary" type="submit">Update</button>
                                        </div>
                                        <div class="d-flex">
                                          <div class="form-check form-check-inline">
                                            <input type="radio" value="1" name="is_done" class="form-check-input" id="selesai-{{ $loop->index }}" {{ $item->is_done == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="selesai-{{ $loop->index }}">Selesai</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input type="radio" value="0" name="is_done" class="form-check-input" id="belum-{{ $loop->index }}" {{ $item->is_done == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="belum-{{ $loop->index }}">Belum</label>
                                          </div>
                                        </div>
                                      </form>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              <!-- Links untuk navigasi -->
                              {{ $data->links() }}
                  
                            </div>
                          </div>
                  
                        </div>
                      </div>
                    </div>
                  </section>
                  
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
